<?php
header('Content-Type: application/json');
$aResult = array();

    if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

    if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

    if( !isset($aResult['error']) ) {

        switch($_POST['functionname']) {
            case 'sendgmail':
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $aResult['result'] = sendgmail($_POST['arguments'][0], $_POST['arguments'][1]);
               }
               break;

            default:
               $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
               break;
        }

    }

    echo json_encode($aResult);

	
function sendgmail($addr, $body) {
	$config = parse_ini_file('../../catchit/email_config.ini');
	require_once("phpmailer/class.phpmailer.php");
	include("phpmailer/class.smtp.php"); 
				
	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->Username = $config['address'];
	$mail->Password = $config['password'];
	$mail->Priority    = 3;
    $mail->CharSet     = 'UTF-8';
    $mail->Encoding    = '8bit';
	$mail->Subject = 'Data from Catchit';
	$mail->ContentType = 'text/html; charset=utf-8\r\n';
    $mail->From        = $config['address'];
    $mail->FromName    = 'Catchit';
    $mail->WordWrap    = 900;
	
	$mail->AddAddress($addr);
	$mail->isHTML( FALSE );
	$mail->Body = $body;

    $mail->Send();
    $mail->SmtpClose();

    if ( $mail->IsError() ) { 
      return 'failed to send';
    }
    else {
      return 'Email has been sent';
    }
}

?>