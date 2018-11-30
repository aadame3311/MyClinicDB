//GLOBALS//
// user information.
var _firstnmae, _lastname, _address, _dob, _phone,_secondphone, _username, _password;

// instantiate new loginModal
var loginModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
// instantiate new signupModals
var personalinfoModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
var signupModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
////////////////////////////////////////////////////////////////

//FUNCTIONS//
$(document).ready(function() {
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











