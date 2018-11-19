// global variables that store user information. 
// these are global because they are used by multiple methods. 
var _firstnmae, _lastname, _address, _dob, _phone,_secondphone, _username, _password;


// instanciate new loginModal
var loginModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});
// instanciate new signupModal
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


var logininfo_form = 
    '<h1>Login</h1>' +
    '<form class ="login-form" action="./main.php/login">'+
        '<input id="login-username" type="text" placeholder="Username">' +
        '<input id="login-password" type="password" placeholder="Password">' +
    '</form>';
// set sign up form content
var personalinfo_form = 
    '<h1>Sign Up</h1>'+
    '<form class ="personal-form">'+
        '<div class="row">'+
            '<div class="input-field col s6"><input id="firstname" type="text"><label for="firstname">First Name</label></div>' +
            '<div class="input-field col s6"><input id="lastname" type="text"><label for="lastname">Last Name</label></div>' +
        '</div>'+
        '<div class="row"><div class="input-field col s12"><input id="dob" type="text"><label for="dob">Date of Birth</label></div></div>' +
        '<div class="row"><div class="input-field col s12"><input id="address" type="text"><label for="address">Address</label></div></div>' +
        '<div class="row"><div class="input-field col s12"><input id="phone" type="text"><label for="phone">Phone Number</label></div></div>'+
        '<div class="row"><div class="input-field col s12"><input id="second-phone" type="text"><label for="second-phone">Phone Number</label></div></div>'+
        '<select id="insurance-list">'+
            '<option value="" disabled selected>Select Insurance Provider</option>'+
            '<option value="Company 1">Insurance Company 1</option>'+
            '<option value="Company 2">Insurance Company 2</option>'+
            '<option value="Company 3">Insurance Company 3</option>'+
            '<option value="N/A">None</option>'+
        '</select>'+
    '</form>';
// set sign up form content.
var signupinfo_form = 
    '<h1>Sign Up</h1>'+
    '<form class="signup-form" action="./main.php/signup">'+
        '<div class="input-field">'+
            '<input id="signup-email" type="email">' +
            '<label for="signup-email">Email</label>'+
        '</div>'+
        '<div class="input-field">'+
            '<input id="signup-username" type="text">' +
            '<label for="signup-username">Username</label>'+
        '</div>'+
        '<div class="input-field">'+
            '<input id="signup-password" type="text">' +
            '<label for="signup-password">Password</label>'+
        '</div>'+
        '<div class="input-field">'+
            '<input id="signup-cPassword" type="text">' +
            '<label for="signup-cPassword">Confirm Password</label>'+
        '</div>'+
    '</form>';

// LOGIN FORM //
loginModal.setContent(logininfo_form);
loginModal.addFooterBtn('Exit', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    loginModal.close();
});
loginModal.addFooterBtn('Submit<i class="material-icons right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    // send user data to server for authentication.
    var _url = $('form.login-form').attr('action');
    var _username = $('#login-username').val();
    var _password = $('#login-password').val();

    console.log("username: "+_username);
    console.log("password: "+_password);
    console.log(_url);

    // send post request to url to be handled by main.php.
    $.ajax({
        url: _url,
        data: {
            'username': _username,
            'password': _password
        },
        method: "POST",
        dataType: "JSON"
    }).done(function(data) {
        console.log(data['code']);

    });
});

// PERSONAL INFORMATION THAT IS SENT TO SIGNUP //
personalinfoModal.setContent(personalinfo_form);
personalinfoModal.addFooterBtn('Exit', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    personalinfoModal.close();
});
personalinfoModal.addFooterBtn('Next', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    // send user data to server for authentication.
    _firstname = $('#firstname').val();
    _lastname = $('#lastname').val();
    _dob = $('#dob').val();
    _address = $('#address').val();
    _phone = $('#phone').val();
    _insurance = $("#insurance-list").val();
    _secondphone = $("#second-phone").val();
    console.log(_insurance);

    // switch modals.
    personalinfoModal.close()
    signupModal.open();

});
// SIGNUP FORM //
signupModal.setContent(signupinfo_form);
signupModal.addFooterBtn('Back', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    signupModal.close();
    personalinfoModal.open();
});
signupModal.addFooterBtn('Submit<i class="material-icons right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    // get username, password and email values.
    var _email = $("#signup-email").val();
    var _username = $("#signup-username").val();
    if ($("#signup-password").val() == $("#signup-cPassword").val()) {
        var _password = $("#signup-password").val();
    } else {
        return;
    }


    if (_firstname !="" && _lastname != "" ) {
        //ajax call. 
        console.log($(".signup-form").attr('action'))
        $.ajax({
            url:$(".signup-form").attr('action'),
            data: {
                'firstname'     :   _firstname, 
                'lastname'      :   _lastname, 
                'dob'           :   _dob,
                'address'       :   _address,
                'phone'         :   _phone, 
                'second_phone'  :   _secondphone,
                'email'         :   _email,
                'username'      :   _username,
                'password'      :   _password,
                'insurance'     :   _insurance
            },
            method : "POST",
            dataType : "JSON"
        }).done(function(data) {
        });

    }
    else {
        console.log('fill em out!')
    }


    console.log("firstname:: " + _firstname);
    console.log("lastname:: " + _lastname);
    console.log("dob:: " + _dob);
    console.log("address:: " + _address);
    console.log("phone:: " + _phone);
    console.log("username:: " + _username);
    console.log("password:: " + _password);

    // do ajax call to back end close modals. 
    signupModal.close();
    console.log('a');



});





$(document).ready(function() {
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









