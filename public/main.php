<?php

require "../vendor/autoload.php";

$settings = ['displayErrorDetails' => true];

$app = new \Slim\App(['settings' => $settings]);

// twig template setup.
$container = $app->getContainer();
$container['view'] = function($container) {
	$view = new \Slim\Views\Twig('../templates');
	
	$basePath = rtrim(str_ireplace('index.php', '', 
	$container->get('request')->getUri()->getBasePath()), '/');

	$view->addExtension(
	new Slim\Views\TwigExtension($container->get('router'), $basePath));
	
	return $view;
};


// main landing 
$app->get('/', function($request, $response, $args) {
    
    return $this->view->render($response, 'landing.html');
});
$app->post('/login', function($request, $response, $args) {
});
$app->post('/signup', function($request, $response, $args) {
    // get user data from request.

    $firstname = $request->getParam('firstname');
    $lastname = $request->getParam('lastname');
    $address = $request->getParam('address');
    $dob = $request->getParam('dob');
    $phone = $request->getParam('phone');
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $insurance_prov = $request->getParam('insurance');

    $patient = new Patient();
    $patient->setFirstName($firstname);
    $patient->setLastName($lastname);
    $patient->setAddress($address);
    $patient->setDateOfBirth($dob);
    $patient->setInsurance($phone);
    $patient->setUsername($username);
    $patient->setPassword($password);
    $patient->save();


});

$app->run();
