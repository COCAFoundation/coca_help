<?php
// Routes

/*****************
*     ROUTES     *
*****************/
$app->get('/', function ($request, $response, $args) {
    $language = $request->getParam('language');
    if (empty($language)) {
        $language = '';
    }

    return $response->withRedirect('./home#/Language/'.$language);
});

$app->get('/home', function ($request, $response, $args) {
    return $this->renderer->render($response, 'home.phtml');
});

$app->post('/api/send_email', function ($request, $response, $args) {
    $this->logger->addInfo('Sending Email');
    //Create book
    $settings = $this->get('settings')['mail'];

    $organization_address = $request->getParam('organization_address');
    $to_email_address = $request->getParam('email');
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $organization_name = $request->getParam('organization_name');
    $other_assistance = $request->getParam('other_assistance');
    $phone = $request->getParam('phone');
    $project_cost_estimate = $request->getParam('project_cost_estimate');
    $project_description = $request->getParam('project_description');
    $project_end_date = $request->getParam('project_end_date');
    $project_expected_results = $request->getParam('project_expected_results');
    $project_grant_amount_requested = $request->getParam('project_grant_amount_requested');
    $project_name = $request->getParam('project_name');
    $project_objectives = $request->getParam('project_objectives');
    $project_other_assistance = $request->getParam('project_other_assistance');
    $project_plan = $request->getParam('project_plan');
    $project_start_date = $request->getParam('project_start_date');
    $organization_website = $request->getParam('organization_website');

    if (empty($organization_address)) {
        $organization_address = '';
    }
    if (empty($to_email_address)) {
        $to_email_address = '';
    }
    if (empty($first_name)) {
        $first_name = '';
    }
    if (empty($last_name)) {
        $last_name = '';
    }
    if (empty($organization_name)) {
        $organization_name = '';
    }
    if (empty($other_assistance)) {
        $other_assistance = '';
    }
    if (empty($phone)) {
        $phone = '';
    }
    if (empty($project_cost_estimate)) {
        $project_cost_estimate = '';
    }
    if (empty($project_description)) {
        $project_description = '';
    }
    if (empty($project_end_date)) {
        $project_end_date = '';
    }
    if (empty($project_expected_results)) {
        $project_expected_results = '';
    }
    if (empty($project_grant_amount_requested)) {
        $project_grant_amount_requested = '';
    }
    if (empty($project_name)) {
        $project_name = '';
    }
    if (empty($project_objectives)) {
        $project_objectives = '';
    }
    if (empty($project_other_assistance)) {
        $project_other_assistance = '';
    }
    if (empty($project_start_date)) {
        $project_start_date = '';
    }
    if (empty($organization_website)) {
        $organization_website = '';
    }

    //secret (required)   6Leq3gwTAAAAAIXugq0ixQxHM4ZkFEDlq0WrSDGF
    //response (required) The value of 'g-recaptcha-response'.
    //remoteip    The end user's ip address.

    /****************
    * EMAIL TO COCA *
    *****************/
    $status = 200;
    $result = '';
    $this->mail->setFrom($settings['from_email'], 'COCA Support');
    $this->mail->addAddress($settings['coca_support_email'], 'COCA Team');     // Add a recipient
    $this->mail->Subject = 'New Aid Request Application: '.$project_name;
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $this->mail->Body = '<html>
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
                                              Organization Name: '.$organization_name.'<br/>
                                              Address: '.$organization_address.'<br/>
                                              Website: '.$organization_website.'<br/>
                                          </p>
                                          <h3>Contact Information</h3>
                                          <p>
                                              First Name: '.$first_name.'<br/>
                                              Last Name: '.$last_name.'<br/>
                                              Phone Number: '.$phone.'<br/>
                                              Email: '.$to_email_address.'<br/>
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

    if (!$this->mail->send()) {
        //echo 'Message could not be sent.';
        $result = array('error' => 'Mailer Error: '.$this->mail->ErrorInfo);
        $status = 201;
        $this->logger->addInfo('Error sending email: '.$this->mail->ErrorInfo);
    } else {
        $result = array('error' => null, 'data' => 'success');
        $status = 200;
    }

   /*******************
    * EMAIL TO PERSON *
    *******************/
    $this->mail->ClearAddresses();
    $this->mail->setFrom($settings['from_email'], 'COCA Support');
    $this->mail->addAddress($to_email_address, $first_name.' '.$last_name);
    $this->mail->Subject = 'Confirmation for COCA Aid Request Application: '.$project_name;
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $this->mail->Body = '<html>
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
                                            Organization Name: '.$organization_name.'<br/>
                                            Address: '.$organization_address.'<br/>
                                            Website: '.$organization_website.'<br/>
                                        </p>
                                        <h3>Contact Information</h3>
                                        <p>
                                            First Name: '.$first_name.'<br/>
                                            Last Name: '.$last_name.'<br/>
                                            Phone Number: '.$phone.'<br/>
                                            Email: '.$to_email_address.'<br/>
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

    if (!$this->mail->send()) {
        //echo 'Message could not be sent.';
        $result = array('error' => 'Mailer Error: '.$this->mail->ErrorInfo);
        $status = 201;
        $this->logger->addInfo('Error sending email: '.$this->mail->ErrorInfo);
    } else {
        $result = array('error' => null, 'data' => 'success');
        $status = 200;
    }

    return $response->withStatus($status)->withHeader('Content-Type', 'application/json')->write(json_encode($result));
});
