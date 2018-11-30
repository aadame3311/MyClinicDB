



//event handlers/////////////////////////////////////////////
$(document).ready(function() {
    LoadModule("Overview");
});
$("a.sidenav-elem").on('click', function(e) {
    e.preventDefault();
    var module_title = $(this).text();
    $(".current-select h2").html(module_title);
    LoadModule(module_title);
});
/////////////////////////////////////////////////////////////




//functions/////////////////////////////////////////////////
function LoadModule(name) {
    $(".module").prop('hidden', true);
    $("."+name+"-module").prop('hidden', false);
}
///////////////////////////////////////////////////////////