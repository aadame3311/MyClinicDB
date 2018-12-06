



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
$(".app-item").on('click', function() {
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
    }
    
    console.log(module_name);
    $("."+module_name+"-module").prop('hidden', false);
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