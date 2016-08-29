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
$config_array = parse_ini_file("config.ini");


/****************
* LOGGING SETUP *
****************/
$log = new Logger('app');
#$log->pushHandler(new StreamHandler('lresptofunrun.log', Logger::WARNING));

// add records to the log
#$log->warning('Foo');
#$log->error('Bar');


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


$app = new \Slim\App;

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('templates/');
};


$app->get('/', function ($request, $response, $args) {
  return $this->view->render($response, 'index.php', []);
});

$app->post('/', function ($request, $response, $args) {
  return $this->view->render($response, 'index.php', [
        'name' => $args['name']
    ]);
});




$app->run();
