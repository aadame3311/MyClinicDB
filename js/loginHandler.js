// requests access to user dashboard to the server.
function AccessDashboard(user, code) {
    // valid code is 1. otherwise, 0 means invalid login.
    if (code == 1) {
        // send ajax call to server for dashboard access. 
        $.ajax({
            url: './main.php/dashboard',
            method: "POST",
            data: {
                'code': code,
                'username': user
            }
        }).done(function(data) {
            console.log('dashboard loaded!');
        });
    }
}



// create login modal.
loginModal.setContent(logininfo_form);
loginModal.addFooterBtn('Exit', 'btn waves-effect waves-light tingle-btn--pull-left', function() {
    loginModal.close();
});
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

            // send request to access the user dashboard. 
            AccessDashboard(_username, data['code']);

        }
        else if (data['code'] == 0) {
            // wrong username or password. 
            console.log('a')
            $("p.warning").prop('hidden', false);
        }
    });
});