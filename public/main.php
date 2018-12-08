<?php

require "../vendor/autoload.php";
require_once '../generated-conf/config.php';


function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

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
$app->post('/login', function($request, $response) {
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
$app->post('/logout', function($request, $response) {
    session_id('s-'.$request->getParam('user_code'));
    session_start();
    session_destroy();
    unset($_COOKIE["user"]);
    setcookie("user", "", time()-1800);

    // redirect to main page.
    header("Location: ../main.php");
    exit();

});
$app->post('/signup', function($request, $response) {

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


        // retrieve patient info from db.
        $patient_username = (string)$_SESSION['username'];
        $patient = PatientQuery::create()->filterByUsername($patient_username)->findOne();
        $patient_id = $patient->getID();
        $first_name = $patient->getFirstName();
        $last_name = $patient->getLastName();
        $email = $patient->getEmail();
        $address = $patient->getAddress();
        $insurance = $patient->getInsurance();
        $main_phone = PatientphoneQuery::create()->filterByPatientId($patient_id)->findOne()->getPhoneNumber();

        // retrieve patients health history.
        $health_history = HealthhistoryQuery::create()->filterByPatientId($patient_id);

        // return patient info to patient dashboard.
        return $this->view->render($response, 'patient.html', [
            'username'=>$patient_username,
            'first_name'=>$first_name, 
            'last_name'=>$last_name,
            'email'=>$email,
            'address'=>$address,
            'insurance'=>$insurance,
            'main_phone'=>$main_phone,
            'health_history'=>$health_history,
        ]);
    }
    else {
        echo "redirecting...";
        header("Location: ../../main.php");
        exit();
    }

});
$app->post("/dashboard/getApps", function($request, $response) {
    $sort = $request->getParam('sort');
    $time_slots = array();
    if ($sort == 0) {
        $time_slots = TimeslotQuery::create()->filterByAvailability(1)->orderByStartTime()->find();
    }
    else if ($sort == 1) {
        $time_slots = TimeslotQuery::create()->filterByAvailability(1)->orderByStartTime('desc')->find();
    }
    

    // construct json object. 
    $schedules = array();
    $obj = array();
    foreach($time_slots as $t) {
        $emp = $t->getEmployee();
        $obj = [
            'employee_id'=>$emp->getID(),
            'first_name'=>$emp->getFirstName(),
            'last_name'=>$emp->getLastName(),
            'start_time'=>$t->getStartTime(),
            'end_time'=>$t->getEndTime(),
            'app_id'=>$t->getID()
        ];

        array_push($schedules, $obj);
    }

    return $response->withJson($schedules);
});
$app->post("/dashboard/searchApp", function($request, $response) {
    $search_query = $request->getParam('search');
    if ($search_query != "") {
        $keywords = multiexplode(array(" ",",",":",".","-"), $search_query);
        $keywords = array_unique($keywords);
    
        $result = array();
    
        $emp = null;
        foreach($keywords as $word) {
            if ($emp = EmployeeQuery::create()->filterByFirstName($word)->find()) {
                foreach($emp as $e) {
                    $obj = array();
                    $emp_times = TimeslotQuery::create()->filterByEmployeeId($e->getID())->find();
                    foreach($emp_times as $t) {
                        $obj = [
                            'employee_id'=>$e->getID(),
                            'first_name'=>$e->getFirstName(),
                            'last_name'=>$e->getLastName(),
                            'start_time'=>$t->getStartTime(),
                            'end_time'=>$t->getEndTime(),
                            'app_id'=>$t->getID()
                        ];
                        array_push($result, $obj);
                    }
                } 
            }
        }
    }
    else {
        $time_slots = TimeslotQuery::create()->filterByAvailability(1)->orderByStartTime()->find();

        // construct json object. 
        $result = array();
        $obj = array();
        foreach($time_slots as $t) {
            $emp = $t->getEmployee();
            $obj = [
                'employee_id'=>$emp->getID(),
                'first_name'=>$emp->getFirstName(),
                'last_name'=>$emp->getLastName(),
                'start_time'=>$t->getStartTime(),
                'end_time'=>$t->getEndTime(),
                'app_id'=>$t->getID()
            ];
    
            array_push($result, $obj);
        }
    }
    return $response->withJson($result);

});

$app->post("/dashboard/scheduleApp", function($request, $response) {
    $t_id = $request->getParam('t_id');
    $emp_id = $request->getParam('employee_id');
    $room = $request->getParam('room');
    $cost = $request->getParam('cost');
    // find username currently logged in. 
    $user_hash = $_COOKIE["user"];
    session_id("s-".$user_hash);
    session_start();
    $username = $_SESSION['username'];
    $user = PatientQuery::create()->filterByUsername($username)->findOne();
    echo $username;

    // assign appointment to the username. 
    $appointment = new Appointment();
    $appointment->setPatientId($user->getID());
    $appointment->setTimeslotId($t_id);
    $appointment->setEmployeeId($emp_id);
    $appointment->setRoom($room);
    $appointment->setCost($cost);
    $appointment->save();

    // make the selected timeslot unavailable.
    $time_slot = TimeslotQuery::create()->findPK($t_id);
    $time_slot->setAvailability(0);
    $time_slot->save();
});

$app->post("/isAdmin", function($request, $response) {

});

$app->run();
