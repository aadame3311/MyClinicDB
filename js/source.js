// global variables that store user information. 
// these are global because they are used by multiple methods. 


$(document).ready(function() {
    $('.parallax').parallax();

    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
});

// open loginModal to allow user to login.
$('.login').on('click', function() {
    loginModal.open();
});
// open personalinfoModal on navbar signup click. 
// the personalinfoModal carries over to the signupModal.
$('.signup').on('click', function() {
    personalinfoModal.open();
});









