//GLOBALS///////////////////////////////////////////////////////
// user information.
var _firstnmae, _lastname, _address, _dob, _phone,_secondphone, _username, _password;
////////////////////////////////////////////////////////////////




//event listeners///////////////////////////////////////////////
$(document).ready(function() {
    // materialize js initializers.
    $('.parallax').parallax();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
});

$('.login').on('click', function() {
    loginModal.open();
});
$('.signup').on('click', function() {
    personalinfoModal.open();
});
///////////////////////////////////////////////////////////////

