
//GLOBALS/////////////////////////////////////////////////////////////////////////////////////////////
var _USER_CODE = "";
var _LOGIN_CODE = "";

// instantiate new loginModal
var loginModal = new tingle.modal({
    footer: true,
    stickyFooter: false,
    closeMethods: ['overlay', 'escape'],
    closeLabel: "Close",
    cssClass: ['custom-class-1', 'custom-class-2']
});


var logininfo_form = 
    '<div class="container">'+
        '<h3 style="text-align: center;">Login</h3>' +
        '<form class ="login-form" action="./main.php/login">'+
            '<div class="input-field">'+
                '<input id="login-username" type="text" autocomplete="off" autocorrect="off"/>' +
                '<label for="login-username">Username</label>'+
            '</div>'+
            '<div class="input-field">'+
                '<input id="login-password" type="password" autocomplete="off" autocorrect="off"/>' +
                '<label for="login-password">Password</label>'+
            '</div>'+
        '</form>'+
        '<p hidden class="warning" style="color: red">wrong username or password</p>'+
    '</div>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////// 


// requests access to user dashboard to the server.
function AccessDashboard(user, code, user_code) {
    // valid code is 1. otherwise, 0 means invalid login.
    if (code == 1) {
        // send ajax call to server for dashboard access. 
        $.ajax({
            url: './main.php/dashboard/'+user_code,
            method: "GET",
        }).done(function(data) {
            console.log('dashboard loaded!');
            // load url to dashboard.
            var target_url = window.location.pathname+"/dashboard/"+user_code;
            window.location.href = target_url;

        });
    }
}

// create login modal.
loginModal.setContent(logininfo_form);
loginModal.addFooterBtn('Exit', 'btn btn-danger waves-effect waves-light tingle-btn--pull-left', function() {
    loginModal.close();
});
// on submit button press.
loginModal.addFooterBtn('Submit<i class="material-icons right">send</i>', 'btn waves-effect waves-light tingle-btn--pull-right', function() {
    // send user data to server for authentication.
    var _url = $('form.login-form').attr('action');
    var _username = $('#login-username').val();
    var _password = $('#login-password').val();

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
        console.log(data['code'])
        if (data['code'] == 1) {
            // user is logged in, go to user dashboard.
            $("p.warning").prop('hidden', true);
            _USER_CODE = data['user_code'];
            _LOGIN_CODE = data['code'];
            // send request to access the user dashboard. 
            AccessDashboard(_username, _LOGIN_CODE, _USER_CODE);

        }
        else if (data['code'] == 0) {
            // wrong username or password. 
            console.log('a')
            $("p.warning").prop('hidden', false);
        }
    });
});

// on logout button press (dashboard navbar).
$(".logout").on('click', function() {
    $.ajax({
        url: "../../main.php/logout",
        method: "POST",
        data: {
            "user_code": _USER_CODE
        }
    }).done(function() {
        // load url to main.
        var target_url = "../../main.php";
        window.location.href = target_url;
    })
})