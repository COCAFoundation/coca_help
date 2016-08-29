<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/vendor/autoload.php';
require 'vendor/autoload.php';



/**************
* CONFIG FILE *
***************/
$config_array = parse_ini_file("config/config.ini");
date_default_timezone_set('UTC');


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


$mail->isHTML(true);                                  // Set email format to HTML


$app = new \Slim\App(array(
    'mode' => 'development'
));

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('templates/');
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger("APP_NAME");
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    //$logger->pushHandler(new Monolog\Handler\StreamHandler("app.log", Monolog\Logger::DEBUG));
    $logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG)); // <<< uses a stream

    return $logger;
};



$app->get('/', function ($request, $response, $args) {
  $config_array = parse_ini_file("config/config.ini");
  $campaignStartDateString = strtotime($config_array['campaign_start_date']);
  $campaignStartDate = date('Y-m-d',$campaignStartDateString);

  $campaignEndDateString = strtotime($config_array['campaign_end_date']);
  $campaignEndDate = date('Y-m-d',$campaignEndDateString);

  $todaysDate = date('Y-m-d');

  $this->logger->addInfo("Start Date: ".$campaignStartDate);
  $this->logger->addInfo("End Date: ".$campaignEndDate);
  $this->logger->addInfo("Todays Date: ".$todaysDate);

  //$newformat = date('Y-m-d',$time);

  if ($todaysDate > $campaignEndDate){
    return $this->view->render($response, 'closeout.php', []);
  }elseif ($todaysDate > $campaignStartDate) {
    return $this->view->render($response, 'track.php', []);
  }else {
    return $this->view->render($response, 'prepare.php', []);
  }

});

$app->post('/', function ($request, $response, $args) {
  $app->response->redirect('/', 303);
});




$app->run();
