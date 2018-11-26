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
        if ( $pwd = password_verify($password, $usr->getPasswordHash()) ) {
            // Succesful Login!
            $login_info = [
                'code' => 1
            ];
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
        echo "a";


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
    
            if ($_phone != null || $_phone != "") {
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

$app->run();
