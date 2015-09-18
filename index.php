<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
require 'PHPMailer/PHPMailerAutoload.php';




/**************
* CONFIG FILE *
***************/
$config_array = parse_ini_file("config.ini");


/*******************
* PHP Mailer Setup *
*******************/

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username   = $config_array['google_username']; // SMTP account username example
$mail->Password   = $config_array['google_password'];        // SMTP account password example
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to


//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML










\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim(array(
    'mode' => 'development',
    'debug' => true,
    'templates.path' => './templates',
));



$app->get('/', function () use ($app) {
    $app->render('home.php');
});


$app->post('/api/send_email', function () use ($app, $mail, $config_array) {
    //Create book
    

    $address= $app->request->params('address');
    $email= $app->request->params('email');
    $first_name= $app->request->params('first_name');
    $last_name= $app->request->params('last_name');
    $org_name= $app->request->params('org_name');
    $other_assistance= $app->request->params('other_assistance');
    $phone= $app->request->params('phone');
    $project_cost_estimate= $app->request->params('project_cost_estimate');
    $project_description= $app->request->params('project_description');
    $project_end_date= $app->request->params('project_end_date');
    $project_expected_results= $app->request->params('project_expected_results');
    $project_grant_amount_requested= $app->request->params('project_grant_amount_requested');
    $project_name= $app->request->params('project_name');
    $project_objectives= $app->request->params('project_objectives');
    $project_other_assistance= $app->request->params('project_other_assistance');
    $project_plan= $app->request->params('project_plan');
    $project_start_date= $app->request->params('project_start_date');
    $website= $app->request->params('website');



    if (empty($address)){
        $address = '';
    }
    if (empty($email)){
        $email = '';
    }    
    if (empty($first_name)){
        $first_name = '';
    }
    if (empty($last_name)){
         $last_name = '';
    }
    if (empty($org_name)){
        $org_name = '';
    }
    if (empty($other_assistance)){
        $other_assistance = '';
    }
    if (empty($phone)){
        $phone = '';
    }
    if (empty($project_cost_estimate)){
        $project_cost_estimate = '';
    }
    if (empty($project_description)){
        $project_description = '';
    }
    if (empty($project_end_date)){
        $project_end_date = '';
    }
    if (empty($project_expected_results)){
        $project_expected_results = '';
    }
    if (empty($project_grant_amount_requested)){
        $project_grant_amount_requested = '';
    }
    if (empty($project_name)){
        $project_name = '';
    }
    if (empty($project_objectives)){
        $project_objectives = '';
    }
    if (empty($project_other_assistance)){
        $project_other_assistance = '';
    }
    if (empty($project_start_date)){
        $project_start_date = '';
    }
    if (empty($website)){
        $website = '';
    }        
    

    //secret (required)   6Leq3gwTAAAAAIXugq0ixQxHM4ZkFEDlq0WrSDGF
    //response (required) The value of 'g-recaptcha-response'.
    //remoteip    The end user's ip address.


    /****************
    * EMAIL TO COCA *
    *****************/
    $mail->From = $config_array['from_email'];
    $mail->FromName = 'COCA Support';
    $mail->addAddress($config_array['coca_support_email'], 'COCA Team');     // Add a recipient
    $mail->Subject = 'New Aid Request Application: '.$app->request->params('project_name');
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->Body    = '<html>
                        <head>
                            <meta charset="utf-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                            <!--[if lt IE 9]>
                                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                            <![endif]-->
                        </head>
                        <body>
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-md-12">
                                        <h1>New Aid Request Submitted</h1>
                                        <h3>Organization Details</h3>
                                        <p>
                                            Organization Name: '.$org_name.'<br/>
                                            Address: '.$address.'<br/>
                                            Website: '.$website.'<br/>
                                        </p>
                                        <h3>Contact Information</h3>
                                        <p>
                                            First Name: '.$first_name.'<br/>
                                            Last Name: '.$last_name.'<br/>
                                            Phone Number: '.$phone.'<br/>
                                            Email: '.$email.'<br/>
                                        </p>
                                        <h3>Project Proposal</h3>
                                        <p>                            
                                            Program/Project Name: '.$project_name.'<br/>
                                            Estimated Total Cost: $'.$project_cost_estimate.'<br/>
                                            Amount of Grant Requested: $'.$project_grant_amount_requested.'<br/>
                                            Other Assistance Requested: '.$project_other_assistance.'<br/>
                                            Description of Project: '.$project_description.'<br/>
                                            Specific Objectives: '.$project_objectives.'<br/>
                                            Expected Results: '.$project_expected_results.'<br/>
                                            Proposed Start Date: '.$project_start_date.'<br/>        
                                            Proposed End Date: '.$project_end_date.'<br/>
                                            Project Plan: '.$project_plan.'                                                                                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </body>
                     </html>';



    $app->response->header('Content-Type', 'application/json');
    //$app->contentType('application/json');


    if(!$mail->send()) {
        //echo 'Message could not be sent.';
        $result = array('error' => 'Mailer Error: ' . $mail->ErrorInfo);
        $app->response->setStatus(201);
    } else {
        $result = array('error' => null, 'data' => 'success');
        $app->response->setStatus(201);
    }

    $app->response->setBody(json_encode($result));

   /*******************
    * EMAIL TO PERSON *
    *******************/
    $mail->ClearAddresses();
    $mail->From = $config_array['from_email'];
    $mail->FromName = 'COCA Support';
    $mail->addAddress($email, $first_name.' '.$last_name);     // Add a recipient
    $mail->Subject = 'Confirmation for COCA Aid Request Application: '.$app->request->params('project_name');
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->Body    = '<html>
                        <head>
                            <meta charset="utf-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
                            <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                            <!--[if lt IE 9]>
                                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                            <![endif]-->
                        </head>
                        <body>
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-md-12">
                                        <h1>Thank you!</h1>
                                        <p>
                                            The Children of Central Asia foundation would like to formally thank you for 
                                            submitting your application. Please expect several weeks for your application to be 
                                            processed. If your project is selected, COCA will reach out.
                                        </p>
                                        <p>
                                            Thanks again,
                                        </p>
                                        <p>
                                            John Griffin, Executive Director
                                        </p>
                                        <hr/>
                                        <h3>Organization Details</h3>
                                        <p>
                                            Organization Name: '.$org_name.'<br/>
                                            Address: '.$address.'<br/>
                                            Website: '.$website.'<br/>
                                        </p>
                                        <h3>Contact Information</h3>
                                        <p>
                                            First Name: '.$first_name.'<br/>
                                            Last Name: '.$last_name.'<br/>
                                            Phone Number: '.$phone.'<br/>
                                            Email: '.$email.'<br/>
                                        </p>
                                        <h3>Project Proposal</h3>
                                        <p>                            
                                            Program/Project Name: '.$project_name.'<br/>
                                            Estimated Total Cost: $'.$project_cost_estimate.'<br/>
                                            Amount of Grant Requested: $'.$project_grant_amount_requested.'<br/>
                                            Other Assistance Requested: '.$project_other_assistance.'<br/>
                                            Description of Project: '.$project_description.'<br/>
                                            Specific Objectives: '.$project_objectives.'<br/>
                                            Expected Results: '.$project_expected_results.'<br/>
                                            Proposed Start Date: '.$project_start_date.'<br/>        
                                            Proposed End Date: '.$project_end_date.'<br/>
                                            Project Plan: '.$project_plan.'                                                                                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </body>
                     </html>';



    $mail->send();

});


$app->run();






