<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 12/3/16
 * Time: 10:29 AM
 */
?>
<?php
include "bpmanager/pages/includes/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$response = json_encode(array("code"=>0, "content" => "Error system", "err_param" => ''));

if($_POST)
{
    $_POST = array_map("strip_tags", $_POST);
    extract($_POST);

    if(strlen($name)<2)
        $response = json_encode(array("code"=>0, "content" => "Error name", "err_param" => 'name'));
    elseif(strlen($email)<4 || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $response = json_encode(array("code"=>0, "content" => "Error email", "err_param" => 'email'));
    elseif(strlen($subject)<4)
        $response = json_encode(array("code"=>0, "content" => "Error subject", "err_param" => 'subject'));
    elseif(strlen($message)<4)
        $response = json_encode(array("code"=>0, "content" => "Error message", "err_param" => 'message'));
    else
    {
        //Create a new PHPMailer instance
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'no-reply@erasmusplus.org.az';                 // SMTP username
            $mail->Password = '123456ep!';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('no-reply@erasmusplus.org.az', 'Erasmusplus contact');
            $mail->addAddress('office@erasmusplus.org.az', 'Erasmusplus');     // Add a recipient
            $mail->addReplyTo($email, $name);

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;

            $message = $lang9." : ".$name."<br />
                    ".$lang10." : ".$email."<br />
                    ".$lang11." : ".$subject."<br />
                    ".$lang12." : ".$message."<br /><br />";

            $mail->Body    = $message;

            $mail->send();
            $response = json_encode(array("code"=>1, "content" => "Success", "err_param" => ''));
        } catch (Exception $e) {
            $response = json_encode(array("code"=>-1, "content" => "Try again", "err_param" => ''));
        }
    }
}

echo $response;
?>
