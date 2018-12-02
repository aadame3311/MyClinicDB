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
    '</form>'+
    '<p hidden class="warning" style="color: red">wrong username or password</p>';

var personalinfo_form = 
    '<h1>Sign Up</h1>' +
    '<form class ="personal-form">'+
        // first and last name
        '<div class="row">'+
            '<div class="input-field col s6"><input id="firstname" type="text"><label for="firstname">First Name</label></div>' +
            '<div class="input-field col s6"><input id="lastname" type="text"><label for="lastname">Last Name</label></div></div>' +
        // date of birth selection
        '<div class="row">' +
            '<div class="input-field col s12"><input id ="dob" type="date" value=getDate() min="1930-01-01 max="2017-12-31">' +
            '<label for="dob">Date of Birth</label></input>' +
        '</div>' +
        // Address, phone, and second phone
        '<div class="row"><div class="input-field col s12"><input id="address" type="text"><label for="address">Address</label></div></div>' +
        '<div class="row"><div class="input-field col s12"><input id="phone" type="text"><label for="phone">Phone Number</label></div></div>'+
        '<div class="row"><div class="input-field col s12"><input id="second-phone" type="text"><label for="second-phone">Phone Number</label></div></div>'+
        // insurance selection
        '<div class="row">' +
        '<select id = "insurance-list">'+
            '<option value="">Select Insurance Provider</option>'+
            '<option value="Company 1">Insurance Company 1</option>'+
            '<option value="Company 2">Insurance Company 2</option>'+
            '<option value="Company 3">Insurance Company 3</option>'+
            '<option value="N/A">None</option>'+
        '</select>'+
        '</div>' +
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
            '<input id="signup-password" type="password">' +
            '<label for="signup-password">Password</label>'+
        '</div>'+
        '<div class="input-field">'+
            '<input id="signup-cPassword" type="password">' +
            '<label for="signup-cPassword">Confirm Password</label>'+
        '</div>'+
    '</form>';

// verify first sign up form
function verifyInput(fn, ln, dob, add, ph, ins, sph)
{
    var alpha = /^[A-Za-z]+$/;
    var alphanum = /^[a-z A-Z0-9.,]+$/;

    // verify all fields are filled
    if(fn=="" || ln=="" || dob=="" || add=="" || ph=="" || ins=="" || sph==""){
        alert("Please fill in all fields");
        return false;
    }
    // verify first and last name are alpha
    else if(!alpha.test(fn) || !alpha.test(ln)){
        alert("Please verify first and last name fields");
        return false;
    }
    //verify address is alphanumeric
    else if(!alphanum.test(add)){
        alert("Please verify address field");
        return false;
    }
    // verify phone numbers are numeric
    else if(isNaN(ph) || isNaN(sph) || ph.length > 10 || sph.length > 10
                      || ph.length < 10 || sph.length < 10){
        alert("Please verify phone number fields");
        return false;
    }
    else{
        return true;
    }
}
// PERSONAL INFORMATION THAT IS SENT TO SIGNUP //
personalinfoModal.setContent(personalinfo_form);
personalinfoModal.addFooterBtn('Exit', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    personalinfoModal.close();
});
personalinfoModal.addFooterBtn('Next', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    // verify fields are filled
    if(verifyInput($('#firstname').val(),$('#lastname').val(),$('#dob').val(),
        $('#address').val(),$('#phone').val(),$("#insurance-list").val(),$("#second-phone").val()))
    {
        // send user data to server
        _firstname = $('#firstname').val();
        _lastname = $('#lastname').val(); 
        _dob = $('#dob').val();
        _address = $('#address').val();
        _phone = $('#phone').val();
        _insurance = $("#insurance-list").val();
        _secondphone = $("#second-phone").val();
        // switch modals.
        personalinfoModal.close()
        signupModal.open();
    }
    console.log(_insurance);
});

// verify second sign up form
function verifySecondInput(e, un, p, cp)
{
     // verify all fields are filled
     if(e=="" || un=="" || p=="" || cp==""){
        alert("Please fill in all fields");
        return false;
    }
    // verify password inputs
    else if(p != cp){
        alert("Verify password fields");
        return false;   
    }
    else{
        return true;
    }
}
// SIGNUP FORM //
signupModal.setContent(signupinfo_form);3
signupModal.addFooterBtn('Back', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    signupModal.close();
    personalinfoModal.open();
});
signupModal.addFooterBtn('Submit<i class="material-icons right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    
    if(verifySecondInput($('#signup-email').val(), $('#signup-username').val(), $('#signup-password').val(), $('#signup-cPassword').val()))
    {
        // send user data to server
        _email = $('#signup-email').val();
        _username = $('#signup-username').val(); 
        _password = $('#signup-password').val();
        // display submission confirmation
        alert("Submission successful!");
        // do ajax call to back end close modals. 
        signupModal.close(); 
    }
 
    /*
     * VERIFY THIS INFORMATION
     */
    /*if (_firstname !="" && _lastname != "" ) {
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
    }*/
});

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









