// set sign up form content
var personalinfo_form = 
    
    '<div class="container">'+
        '<h3 style="text-align: center;">Sign Up</h3>'+
        '<form class ="personal-form">'+
            '<div class="row">'+
                '<div class="input-field col s6"><input id="firstname" type="text"><label for="firstname">First Name</label></div>' +
                '<div class="input-field col s6"><input id="lastname" type="text"><label for="lastname">Last Name</label></div>' +
            '</div>'+
            '<div class="row"><div class="input-field col s12"><input id="dob" type="text"><label for="dob">Date of Birth (MM/DD/YYYY)</label></div></div>' +
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
        '</form>'+
    '</div>';
// set sign up form content.
var signupinfo_form = 
    '<div class="container">'+
        '<h3 style="text-align: center;">Sign Up</h3>'+
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
        '</form>'+
    '</div>';


// PERSONAL INFORMATION THAT IS SENT TO SIGNUP //
personalinfoModal.setContent(personalinfo_form);
personalinfoModal.addFooterBtn('Exit', 'btn btn-danger waves-effect waves-light tingle-btn--pull-left', function() {
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
signupModal.addFooterBtn('Back', 'btn btn-danger waves-effect waves-light tingle-btn--pull-left', function() {
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

    // do ajax call to back end close modals. 
    signupModal.close();


});

