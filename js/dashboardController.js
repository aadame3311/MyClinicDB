

var app_template = $(".app-template").clone();
var sort_type = 0;
var can_select = true;

var bill_id = 0;

var confirmModal = new tingle.modal({
    footer: false,
    stickyFooter: false,
    closeMethods: [''],
    //closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
var payModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    //closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
payModal.setContent(
    '<div class="input-field">'+
        '<input id="payment-ammount" type="text" autocomplete="off" autocorrect="off"/>' +
        '<label for="payment-ammount">Payment Amount ($)</label>'+
    '</div>');
payModal.addFooterBtn('</div>Submit<i class="material-icons submit-arrow right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    let payment = $("#payment-ammount").val();
    $.ajax({
        url: "../../main.php/dashboard/makePayment",
        data: {
            'bill_id': bill_id,
            'pay': payment
        },
        method: "POST"
    }).done(function() {
        payModal.close();
    });
});


//event handlers/////////////////////////////////////////////
$(document).ready(function() {
    LoadModule("Overview");
    $(".submit-btn").prop('hidden', true);
});
$("a.sidenav-elem").on('click', function(e) {
    e.preventDefault();
    var module_title = $(this).text();
    $(".current-select h2").html(module_title);
    LoadModule(module_title);
});
$(".sort-btn").on('click', function(e) {
    e.preventDefault();
    if (sort_type == 0 ) {
        GetApps(1);
        sort_type = 1;
        $("#current-sort").text("Latest");
    }
    else {
        GetApps(0);
        sort_type = 0;
        $("#current-sort").text("Earliest");

    }

});
$(".search-app").on('submit', function(e) {
    e.preventDefault();
    $(".app-item").remove();
    let search = $(".search-input").val();
    $.ajax({
        url:'../../main.php/dashboard/searchApp',
        data: {
            'search':search
        },
        method: "POST",
        dataType:"JSON"
    }).done(function(data) {
        $.each(data, function(key, value) {
            var new_app = app_template.clone();
            new_app.removeClass('app-template');
            $(new_app).attr('time-id', value['app_id']);
            $(new_app).attr('employee-id', value['employee_id']);
            new_app.prop('hidden', false);
            new_app.find('.l-content').html(
                '<span class="employee-name">'+value['first_name']+" "+value['last_name']+'</span>'+
                '<span class="time-range right">'+value['start_time']+'-'+value['end_time']+'</span>'
            );
            $('.results').append(new_app);
        });
        
        // set event listener for appointment selection.
        $(".app-item").on('click', function() {
            // toggles the currently selected one.
            if ($(this).hasClass('app-selected')) {
                $(this).removeClass('app-selected');
                DisplaySubmit(false);
            } else if ( can_select && !$(this).hasClass('app-selected') ) {
                // ensure only one appointment can be selected at a time.
                $(".app-item").removeClass('app-selected');
                $(this).addClass('app-selected');
                DisplaySubmit(true);
            }
        
        });
    });
});
$(".schedule-btn").on('click', function(e) {
    e.preventDefault();
    can_select = false;
    let t_id = $(".app-selected").attr('time-id');
    let employee_id = $(".app-selected").attr('employee-id');
    confirmModal.setContent("please wait...");
    confirmModal.open();
    DisplaySubmit(false);

    $.ajax({
        url: "../../main.php/dashboard/scheduleApp",
        data: {
            't_id':t_id,
            'employee_id':employee_id,
            'room':0,
            'cost':1000
        },
        method: "POST"
    }).done(function() {
        can_select = true;
        $(".app-selected").remove();


        confirmModal.setContent("<h2 style='color:green;'>Appointment set!</h2>");
        setTimeout(function() {
            confirmModal.close();
        }, 1500);
    });
});
$(".remove-app").on('click', function(e) {
    //e.preventDefault();
    console.log('click');
    $(".loader").prop('hidden', false);
    // get id of appointment. 
    var app_id = $(this).parent().parent().attr('id');

    // remove appointment on the front-end and trust the server to do so as well.
    $.ajax({
        url: '../../main.php/dashboard/removeApp',
        data: {
            'app_id': app_id
        },
        method: "POST"
    }).done(function() {
        $(".loader").prop('hidden', true);
        $("#"+app_id).remove();

    });
});
$(".payment-icon").on('click', function() {
    bill_id = $(this).parent().parent().attr('id');
    payModal.open();
})
/////////////////////////////////////////////////////////////




//functions/////////////////////////////////////////////////
function LoadModule(name) {
    var module_name = "";
    $(".module").prop('hidden', true);
    if (name == "Overview") {
        module_name = 'overview';
    }
    else if (name == "Set Appointments") {
        module_name = 'set-appointments';
        // initial default sort.
        GetApps(sort_type);
    }
    else if (name == "Bills") {
        module_name = 'bills';
    }
    $("."+module_name+"-module").prop('hidden', false);
}

function GetApps(sort) {
    $(".app-item").remove();
    $.ajax({
        url:'../../main.php/dashboard/getApps',
        data: {
            'sort':sort
        },
        method: "POST",
        dataType: "JSON"
    }).done(function(data) {
        $.each(data, function(key, value) {
            var new_app = app_template.clone();
            new_app.removeClass('app-template');
            $(new_app).attr('time-id', value['app_id']);
            $(new_app).attr('employee-id', value['employee_id']);
            new_app.prop('hidden', false);
            new_app.find('.l-content').html(
                '<span class="employee-name">'+value['first_name']+" "+value['last_name']+'</span>'+
                '<span class="time-range right">'+value['start_time']+'-'+value['end_time']+'</span>'
            );
            $('.results').append(new_app);
        });

        // set event listener for appointment selection.
        $(".app-item").on('click', function() {
            console.log('clicked');
            // toggles the currently selected one.
            if ($(this).hasClass('app-selected')) {
                $(this).removeClass('app-selected');
                DisplaySubmit(false);
            } else if ( can_select && !$(this).hasClass('app-selected') ) {
                // ensure only one appointment can be selected at a time.
                $(".app-item").removeClass('app-selected');
                $(this).addClass('app-selected');
                DisplaySubmit(true);
            }
        
        });
    });
}

function DisplaySubmit(is_activate) {
    if (is_activate) {
        $(".submit-btn").prop('hidden', false);
    }
    else {
        $(".submit-btn").prop('hidden', true);
    }
}
///////////////////////////////////////////////////////////