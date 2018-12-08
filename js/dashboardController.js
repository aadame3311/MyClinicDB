

var app_template = $(".app-template").clone();
var sort_type = 0;


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
            console.log('clicked');
            // toggles the currently selected one.
            if ($(this).hasClass('app-selected')) {
                $(this).removeClass('app-selected');
                DisplaySubmit(false);
            } else {
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
    let t_id = $(".app-selected").attr('time-id');
    let employee_id = $(".app-selected").attr('employee-id');
    console.log(t_id);
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
        $(".app-selected").remove();
        console.log('appointment set!');
    });
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
            } else {
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