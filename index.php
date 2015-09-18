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









/*******************
* PHP Mailer Setup *
*******************/

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username   = 'davidlarrimore@childrenofcentralasia.org'; // SMTP account username example
$mail->Password   = 'L33tp$$wrD';        // SMTP account password example
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


$app->post('/api/send_email', function () use ($app, $mail) {
    //Create book
    
    
    $address= (empty($app->request->params('address')) ?  '' : $app->request->params('address'));
    $email= (empty($app->request->params('email')) ?  '' : $app->request->params('email'));
    $first_name= (empty($app->request->params('first_name')) ?  '' : $app->request->params('first_name'));
    $grant_request_amount= (empty($app->request->params('grant_request_amount')) ?  '' : $app->request->params('grant_request_amount'));
    $last_name= (empty($app->request->params('last_name')) ?  '' : $app->request->params('last_name'));
    $org_name= (empty($app->request->params('org_name')) ?  '' : $app->request->params('org_name'));
    $other_assistance= (empty($app->request->params('other_assistance')) ?  '' : $app->request->params('other_assistance'));
    $phone= (empty($app->request->params('phone')) ?  '' : $app->request->params('phone'));
    $project_cost_estimate= (empty($app->request->params('project_cost_estimate')) ?  '' : $app->request->params('project_cost_estimate'));
    $project_description= (empty($app->request->params('project_description')) ?  '' : $app->request->params('project_description'));
    $project_end_date= (empty($app->request->params('project_end_date')) ?  '' : $app->request->params('project_end_date'));
    $project_expected_results= (empty($app->request->params('project_expected_results')) ?  '' : $app->request->params('project_expected_results'));
    $project_grant_amount_requested= (empty($app->request->params('project_grant_amount_requested')) ?  '' : $app->request->params('project_grant_amount_requested'));
    $project_name= (empty($app->request->params('project_name')) ?  '' : $app->request->params('project_name'));
    $project_objectives= (empty($app->request->params('project_objectives')) ?  '' : $app->request->params('project_objectives'));
    $project_other_assistance= (empty($app->request->params('project_other_assistance')) ?  '' : $app->request->params('project_other_assistance'));
    $project_plan= (empty($app->request->params('project_plan')) ?  '' : $app->request->params('project_plan'));
    $project_start_date= (empty($app->request->params('project_start_date')) ?  '' : $app->request->params('project_start_date'));
    $website= (empty($app->request->params('website')) ?  '' : $app->request->params('website'));


    $app->response->setStatus(201);


//secret (required)   6Leq3gwTAAAAAIXugq0ixQxHM4ZkFEDlq0WrSDGF
//response (required) The value of 'g-recaptcha-response'.
//remoteip    The end user's ip address.


    /****************
    * EMAIL TO COCA *
    *****************/
    $mail->From = 'support@childrenofcentralasia.org';
    $mail->FromName = 'COCA Support';
    $mail->addAddress('davidlarrimore@childrenofcentralasia.org', 'Test');     // Add a recipient
    $mail->Subject = 'Aid Request Application: '.$app->request->params('project_name');
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    $app->response->header('Content-Type', 'application/json');
    //$app->contentType('application/json');
    $result = array('error' => null, 'data' => 'success');

    $app->response->write(json_encode($result));

/*
    if(!$mail->send()) {
        //echo 'Message could not be sent.';
        $app->response->write('Mailer Error: ' . $mail->ErrorInfo);
        $app->response->setStatus(201);
    } else {
        $app->response->write('Message has been sent');
    }
*/


});


$app->run();






