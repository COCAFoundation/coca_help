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









/*
*
* PHP Mailer SEtup
*
*/
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
    $name = $app->request->params('name');
    $app->response->setStatus(201);


//secret (required)   6Leq3gwTAAAAAIXugq0ixQxHM4ZkFEDlq0WrSDGF
//response (required) The value of 'g-recaptcha-response'.
//remoteip    The end user's ip address.


    $mail->From = 'davidlarrimore@childrenofcentralasia.org';
    $mail->FromName = 'Mailer';
    $mail->addAddress('davidlarrimore@childrenofcentralasia.org', 'Test');     // Add a recipient
    $mail->Subject = 'Aid Request Submitted';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        //echo 'Message could not be sent.';
        $app->response->write('Mailer Error: ' . $mail->ErrorInfo);
    } else {
        $app->response->write('Message has been sent');
    }

});


$app->run();






