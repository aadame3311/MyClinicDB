





// // instanciate new loginModal
// var loginModal = new tingle.modal({
//     footer: true,
//     stickyFooter: false,
//     closeMethods: ['overlay', 'button', 'escape'],
//     closeLabel: "Close",
//     cssClass: ['custom-class-1', 'custom-class-2']
// });
// // instanciate new signupModal
// var signupModal = new tingle.modal({
//     footer: true,
//     stickyFooter: false,
//     closeMethods: ['overlay', 'button', 'escape'],
//     closeLabel: "Close",
//     cssClass: ['custom-class-1', 'custom-class-2']
// });



// // set login form content
// loginModal.setContent('<h1>Login</h1> <form class="login-form" action="./main.php/login"> <input id="username" type="text" placeholder="Username"><input id="password" type="password" placeholder="Password"></form>');
// loginModal.addFooterBtn('Submit', 'tingle-btn tingle-btn--primary', function() {
//     // send user data to server for authentication.
//     var _url = $('form.login-form').attr('action');
//     var _username = $('#username').val();
//     var _password = $('#password').val();

//     console.log("username: "+_username);
//     console.log("password: "+_password);
//     console.log(_url);

//     // send post request to url to be handled by main.php.
//     $.ajax({
//         url: _url,
//         data: {
//             'username':_username,
//             'password': _password
//         },
//         method: "POST",
//         dataType: "JSON"
//     }).done(function() {

//     });
// });

// // set sign up form content
// var form = 
//     '<h1>Sign Up</h1>'+
//     '<form class ="signup-form" action="./main.php/signup">'+
//     '<input id="username" type="text" placeholder="Username">'+
//     '<input id="firstname" type="text" placeholder="First Name">' +
//     '<input id="lastname" type="text" placeholder="Last Name">' +
//     '<input id="dob" type="text" placeholder="mm/dd/yyyy">' +
//     '<input id="address" type="text" placeholder="Address">' +
//     '<input id="phone" type="text" placeholder="Phone Number">';


// signupModal.setContent(form);
// signupModal.addFooterBtn('Submit', 'tingle-btn tingle-btn--primary', function() {
//     // send user data to server for authentication.
//     var _url = $('form.signup-form').attr('action');
//     var _firstname = $('#username').val();
//     var _lastname = $('#password').val();

//     console.log("username: "+_username);
//     console.log("password: "+_password);
//     console.log(_url);

//     // send post request to url to be handled by main.php.
//     $.ajax({
//         url: _url,
//         data: {
//             'username':_username,
//             'password': _password
//         },
//         method: "POST",
//         dataType: "JSON"
//     }).done(function() {

//     });
// });



$(document).ready(function() {
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
});

// open loginModal to allow user to login.
$('.login').on('click', function(e) {
    e.preventDefault();
    // display login vex modal.
    vex.dialog.open({
        message: 'Enter your username and password:',
        input: [
            '<input name="username" type="text" placeholder="Username" required />',
            '<input name="password" type="password" placeholder="Password" required />'
        ].join(''),
        buttons: [
            $.extend({}, vex.dialog.buttons.YES, { text: 'Login' }),
            $.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
        ],
        callback: function (data) {
            if (!data) {
                console.log('Cancelled')
            } else {
                // send ajax call to the backend for authorization.
                console.log('Username', data.username, 'Password', data.password)
            }
        }
    });

});
$('.signup').on('click', function() {
    signupModal.open();
});









