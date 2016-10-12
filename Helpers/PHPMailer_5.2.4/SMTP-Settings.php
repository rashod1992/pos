<?PHP
$mail = new PHPMailer(true); 				// the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); 							// telling the class to use SMTP
$mail->SMTPDebug  = 1;						// enables SMTP debug information (for testing)
$mail->SMTPAuth   = false;					// enable SMTP authentication
$mail->Host       = "202.21.32.9";		// sets the SMTP server
$mail->Port       = 25;						// set the SMTP port for the GMAIL server
$mail->Username   = "";	// SMTP account username
$mail->Password   = "inFOETPpwD";			// SMTP account password
//$mail->AddBCC('kasunr@eurekasl.com', 'Kasun Rajapaksha');
?>