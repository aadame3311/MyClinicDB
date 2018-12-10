//GLOBALS/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

// set sign up form content
var personalinfo_form = 
    
    '<div class="container">'+
        '<h3 style="text-align: center;">Sign Up</h3>'+
        '<form class ="personal-form">'+
            '<div class="row">'+
                '<div class="input-field col s6"><input id="firstname" type="text"><label for="firstname">First Name</label></div>' +
                '<div class="input-field col s6"><input id="lastname" type="text"><label for="lastname">Last Name</label></div>' +
            '</div>'+
            //'<div class="row"><div class="input-field col s12"><input id="dob" type="text"><label for="dob">Date of Birth (MM/DD/YYYY)</label></div></div>' +
            '<div class="row"><div class="input-field col s12"><input id ="dob" type="date" value=getDate() min="1930-01-01 max="2017-12-31"><label for="dob">Date of Birth</label></div></div>' +
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
        '<p hidden class="warning invalid-input-warning" style="color: red">Please fill out all the fields.</p>'+
    '</div>';
// set sign up form content.
var signupinfo_form = 
    '<div class="container">'+
        '<h3 style="text-align: center;">Sign Up</h3><div hidden class="loader"></div>'+
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
        '<p hidden class="warning invalid-input-warning" style="color: red">Please fill out all the fields.</p>'+
    '</div>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





// more modal setters and event listeners for modals////////////////////////////////////////////////////////////////////////////
// PERSONAL INFORMATION THAT IS SENT TO SIGNUP //
personalinfoModal.setContent(personalinfo_form);
personalinfoModal.addFooterBtn('Exit', 'btn btn-danger waves-effect waves-light tingle-btn--pull-left', function() {
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
});
// SIGNUP FORM //
signupModal.setContent(signupinfo_form);
signupModal.addFooterBtn('Back', 'btn btn-danger waves-effect waves-light tingle-btn--pull-left', function() {
    signupModal.close();
    personalinfoModal.open();
});
signupModal.addFooterBtn('Submit<i class="material-icons right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    
    if(verifySecondInput($('#signup-email').val(), $('#signup-username').val(), $('#signup-password').val(), $('#signup-cPassword').val()))
    {
        $(".loader").prop('hidden', false);
        // send user data to server
        _email = $('#signup-email').val();
        _username = $('#signup-username').val(); 
        _password = $('#signup-password').val();

        //ajax call to server to register user. 
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
            $(".loader").prop('hidden', true);
            if (data['code'] == 1) {
                $(".invalid-input-warning").html("Username is already taken.");
                $(".invalid-input-warning").prop('hidden', false);
                return;
            }
            else if (data['code'] == 0) {
                $(".invalid-input-warning").prop('hidden', true);
                signupModal.close(); 
            }
        });
        
    }
});

// verify first sign up form
function verifyInput(fn, ln, dob, add, ph, ins, sph)
{
    var alpha = /^[A-Za-z]+$/;
    var alphanum = /^[a-z A-Z0-9.,]+$/;

    // verify all fields are filled
    if(fn=="" || ln=="" || dob=="" || add=="" || ph=="" || ins=="" || sph==""){
        $(".invalid-input-warning").html("Please fill in all the fields.");
        $(".invalid-input-warning").prop('hidden', false);
        return false;
    }
    // verify first and last name are alpha
    else if(!alpha.test(fn) || !alpha.test(ln)){
        $(".invalid-input-warning").html("Invalid first or last name.");
        $(".invalid-input-warning").prop('hidden', false);
        return false;
    }
    //verify address is alphanumeric
    else if(!alphanum.test(add)){
        $(".invalid-input-warning").html("Invalid address.");
        $(".invalid-input-warning").prop('hidden', false);
        return false;
    }
    // verify phone numbers are numeric
    else if(isNaN(ph) || isNaN(sph) || ph.length > 10 || sph.length > 10
                      || ph.length < 10 || sph.length < 10){
        $(".invalid-input-warning").html("Invalid Phone Number");
        $(".invalid-input-warning").prop('hidden', false);
        return false;
    }
    else{
        $(".invalid-input-warning").prop('hidden', true);
        return true;
    }
}
// verify second sign up form
function verifySecondInput(e, un, p, cp)
{
     // verify all fields are filled
     if(e=="" || un=="" || p=="" || cp==""){
        $(".invalid-input-warning").html("Please fill in all the fields.");
        $(".invalid-input-warning").prop('hidden', false);
        return false;
    }
    // verify password inputs
    else if(p != cp){
        $(".missing-info-warning").html("Passwords do not match.");
        $(".passwords-dont-match").prop('hidden', false);
        return false;   
    }
    else{
        $(".passwords-dont-match").prop('hidden', true);
        return true;
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////