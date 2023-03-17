<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$connect = mysqli_connect('localhost', 'admin', '12345', 'formulario');

$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$message = isset( $_POST['message'] ) ? $_POST['message'] : '';

$email_error = '';
$message_error = '';

if (count($_POST))
{ 
    $errors = 0;

    if ($_POST['email'] == '')
    {
        $email_error = 'Please enter an email address';
        $errors ++;
    }

    if ($_POST['message'] == '')
    {
        $message_error = 'Please enter a message';
        $errors ++;
    }

    if ($errors == 0)
    {

        $query = 'INSERT INTO contacto (
                email,
                mensaje
            ) VALUES (
                "'.addslashes($_POST['email']).'",
                "'.addslashes($_POST['message']).'"
            )';
        mysqli_query($connect, $query);



        $mail = new PHPMailer();
        try{
        
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'bc7e5e699c184c';
        $mail->Password = '3a8b17d95a14a6';
        
        $mail->setFrom('miguemenangel@gmail.com');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject ='contacto desde el formulario';
        $mail->Body    = $message ;
        
        $mail->send();
        echo'El mensaje ha sido enviado';
        }catch(Exception $e) {
            echo'el mensaje no se a podido enviar',$mail->ErrorInfo;
        }
        header('Location: thankyou.html');
        die();


    }
}

?>
<!doctype html>
<html>
    <head>
        <title>PHP Contact Form</title>
    </head>
    <body>
    
        <h1>PHP Contact Form</h1>

        <form method="post" action="">
        
            Email Address:
            <br>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php echo $email_error; ?>

            <br><br>

            Message:
            <br>
            <textarea name="message"><?php echo $message; ?></textarea>
            <?php echo $message_error; ?>

            <br><br>

            <input type="submit" value="Submit">
        
        </form>
    
    </body>
</html>