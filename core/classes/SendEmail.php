<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require './vendor/phpmailer/PHPMailer/src/Exception.php';
// require './vendor/phpmailer/PHPMailer/src/PHPMailer.php';
// require './vendor/phpmailer/PHPMailer/src/SMTP.php';
require './vendor/autoload.php';

class SendEmail {
    private $email;
    private $host = 'sandbox.smtp.mailtrap.io';
    private $username = '5********c1a9b';// your mailtrap username
    private $password = 'e********558e2';// your mailtrap password
    private $port = 2525;
    private $fromEmail = 'gibran321@hotmail.com';
    private $fromName = 'Gibran Kashour';
    private $toEmail;
    private $toName;
    private $subject;
    private $body;

    public function __construct($toEmail, $toName, $subject, $body)
    {
        $this->email     = new PHPMailer(true);
        $this->toEmail   = $toEmail;
        $this->toName    = $toName;
        $this->subject   = $subject;
        $this->body      = $body;
    }

    function send() {
        //Server settings
        // $this->email->SMTPDebug = SMTP::DEBUG_SERVER;         //Enable verbose debug output
        $this->email->isSMTP();                               //Send using SMTP
        $this->email->Host       = $this->host;               //Set the SMTP server to send through
        $this->email->SMTPAuth   = true;                             //Enable SMTP authentication
        $this->email->Username   = $this->username;                     //SMTP username
        $this->email->Password   = $this->password;                    //SMTP password
        // $this->email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
        $this->email->Port       = $this->port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $this->email->setFrom($this->fromEmail, $this->fromName);
        $this->email->addAddress($this->toEmail, $this->toName);     //Add a recipient
        // $this->email->addAddress('ellen@example.com');               //Name is optional
        // $this->email->addReplyTo('info@example.com', 'Information');
        // $this->email->addCC('cc@example.com');
        // $this->email->addBCC('bcc@example.com');

        //Attachments
        // $this->email->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $this->email->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $this->email->isHTML(true);                                  //Set email format to HTML
        $this->email->Subject = $this->subject;
        $this->email->Body    = $this->body;
        // $this->email->AltBody = 'This is the body in plain text for non-HTML mail clients';

        try{
            $this->email->send();
            return true;
        }catch (Exception $e){
            return false;
        }
    }
}
?>