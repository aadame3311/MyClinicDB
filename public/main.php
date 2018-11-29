<?php

require "../vendor/autoload.php";
require_once '../generated-conf/config.php';


$settings = ['displayErrorDetails' => true];

$app = new \Slim\App(['settings' => $settings]);

// twig template setup.
$container = $app->getContainer();
$container['view'] = function($container) {
	$view = new \Slim\Views\Twig('../templates');
	
	$basePath = rtrim(str_ireplace('index.php', '', 
	$container->get('request')->getUri()->getBasePath()), '/');
//jjj
//ll
	$view->addExtension(
	new Slim\Views\TwigExtension($container->get('router'), $basePath));
	
	return $view;
};


// main landing 
$app->get('/', function($request, $response, $args) {
    
    return $this->view->render($response, 'landing.html');
});
$app->post('/login', function($request, $response, $args) {
    $username = $request->getParam('username');
    $password = $request->getParam('password');

    // verify username. 
    if ($usr = PatientQuery::create()->filterByUsername($username)->findOne()) {
        // verify password. 
        if ( password_verify($password, $usr->getPasswordHash()) ) {
            // Succesful Login!
            $username_hash = hash('ripemd160', $username);
            $login_info = [
                'code' => 1,
                'user_code'=> $username_hash
            ];
            session_id("s-".$username_hash);
            session_start();
            $_SESSION['username'] = $username;
            setcookie("user", $username_hash);

            return $response->withJson($login_info);
        }
        else {
            // Wrong password.
            $login_info = [
                'code' => 0
            ];
            return $response->withJson($login_info);
        }
    }
    else {
        // Wrong username.
        $login_info = [
            'code' => 0
        ];
        return $response->withJson($login_info);
    }


});
$app->post('/logout', function($request, $response, $args) {
    session_id('s-'.$request->getParam('user_code'));
    session_start();
    session_destroy();
    unset($_COOKIE["user"]);
    setcookie("user", "", time()-1800);

    // redirect to main page.
    header("Location: ../main.php");
    exit();

});
$app->post('/signup', function($request, $response, $args) {

    // get user data from request.
    // we assume that this data is alreay formatted by the client.
    $firstname = $request->getParam('firstname');
    $lastname = $request->getParam('lastname');
    $address = $request->getParam('address');
    $dob = $request->getParam('dob');
    $phone = $request->getParam('phone');
    $secondphone = $request->getParam('second_phone');
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $insurance_prov = $request->getParam('insurance');
    $email = $request->getParam('email');


    // make sure this username has not been created before.
    if (!PatientQuery::create()->filterByUsername($username)->findOne()) {
        $patient = new Patient();
        $patient_phones = array($phone, $secondphone);



        // set patient entries.
        $patient->setFirstName($firstname);
        $patient->setLastName($lastname);
        $patient->setAddress($address);
        $patient->setDateOfBirth($dob);
        $patient->setInsurance($insurance_prov);
        $patient->setUsername($username);
        $patient->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));
        $patient->setEmail($email);
        $patient->save();

        // set the patients' phone numbers. 
        foreach ($patient_phones as $_phone) {
    
            if ($_phone != null && $_phone != "") {
                $patient_phone = new Patientphone();
                $patient_phone->setPhoneNumber($_phone);
                $patient_phone->setPatientId($patient->getID());
                $patient_phone->save();
            }
        }
    }
    else {
        return $response->withStatus(400);
    }


});


// USER DASHBOARD//
$app->get('/dashboard/{user_code}', function($request, $response, $args) {
    if (isset($_COOKIE["user"]) && $_COOKIE["user"] == $args['user_code']) {
        session_id("s-".$_COOKIE["user"]);
        session_start();
        return $this->view->render($response, 'patient.html', [
            'username'=>$_SESSION['username']
        ]);
    }
    else {
        echo "redirecting...";
        header("Location: ../../main.php");
        exit();
    }

});

$app->run();
