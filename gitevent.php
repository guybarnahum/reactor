<?php

// .................................................................. setup mail
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

    
function get_version( $path )
{
    $ver = file_get_contents
}
    
$mail = new PHPMailer;
// Setting up PHPMailer
$mail->IsSMTP();                                       // Set mailer to use SMTP
// Visit http://phpmailer.worxware.com/index.php?pg=tip_srvrs for more info on server settings
// For GMail    => smtp.gmail.com
//     Hotmail  => smtp.live.com
//     Yahoo    => smtp.mail.yahoo.com
//     Lycos    => smtp.mail.lycos.com
//     AOL      => smtp.aol.com
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
//This is the email that you need to set so PHPMailer will send the email from
$mail->Username = 'reactorlabs@gmail.com';             // SMTP username
$mail->Password = 'AX9ZuZ2QAX9ZuZ2Q';                  // SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;                                    // TCP port to connect to
// Add the address to send the mail to
$mail->AddAddress('reactorlabs@gmail.com');
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->IsHTML(true);                                  // Set email format to HTML
    
// config
$email = 'guy@barnahum.com'; //not required, but useful for debugging
$repos = [ 'reactor' =>[ 'path'=>'~/barnahum.com/reactor' ]];
$msg   = [];

//get repo name from post payload or manual test
    
$repo     = '';
$postdata = file_get_contents("php://input");
    
// validate data posted by git webhook
if (!empty($postdata)) {
    try{
        $data = json_decode($postdata);
        $repo = $data->repository->name ;
        $msg[] = 'Repo name: '. $repo ;
    }
    catch(Exception $e){
        $msg[] = 'Exception : ' . $e->getMessage();
        $repo  = '';
    }
}
else
// or maybe we are just in debug mode?
if (!empty ($_GET['repo'])) {
    $repo = $_GET['repo'];
    $msg[] = $repo . ' GET recieved';
}
else{
    $msg[] = 'No target repo provided';
    $msg[] = 'POST raw-data :' . $postdata;
}

if (!empty($repo)){
    //sanitize repo name for security
    $repo = escapeshellcmd($repo);
}

if (!empty($repo)){
    //check that repo name is supported
    if (!array_key_exists($repo, $repos)){
        $msg[] = ' repo name `' . $repo . '` not supported';
        $repo = null;
    }
}
    
if (!empty($repo)){
    //check that required paths are present in config
    if (empty($repos[$repo]['path']) ){
        $msg[] = 'repo path must both be set for ' . $repo;
        $repo = null;
    }
}
    
//todo, scan list of deleted files in this commit and delete them
    
//update git, deploy to directory

if (!empty($repo)){
    $msg[] = 'attempting to git pull for ' . $repo . ' from ' . $repos[$repo]['path'] ;
    $msg[] = exec('whoami;cd ' . $repos[$repo]['path'] . ';git pull' );

    $body = stripslashes( implode( "<br>", $msg ) );

    if ( stripos( $body, 'Already up-to-date' ) === false ){
        // update version.txt
        $ver = get_version( __DIR__ . '/version.txt' );
    }

    // done - send email
    
    // The sender of the form/mail
    $mail->From     = $email;
    $mail->FromName = "noreply@reactor.barnahum.com";
    $mail->Subject = '[Reactor.BarNahum.com]: gitevent ' ;
    $mail->Body = $body;
            
    if( @$mail->Send() ) {
        echo 'email sent ok<br>' . $body;
    } else {
        echo 'email failure<br><small>' . $mail->ErrorInfo . '</small><br>' . $body;
    }
}


