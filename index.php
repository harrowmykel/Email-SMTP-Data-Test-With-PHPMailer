<?php 
/*PHPMAILER*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require __DIR__.'/phpmailer/src/Exception.php';
require __DIR__.'/phpmailer/src/PHPMailer.php';
require __DIR__.'/phpmailer/src/SMTP.php';
$mail = new PHPMailer();
$mail->isSMTP();

function getPost($name){
    if(!isset($_POST[$name])){
        return '';
    }
    return $_POST[$name];
}

if(!isset($_POST['mail_send'])){
    $_POST['from-email'] = 'sender@gmail.com';
    $_POST['to-email'] = 'test@gmail.com';
    $_POST['username'] = 'user';
    $_POST['password'] = '********';
    $_POST['port'] = '587';
    $_POST['security'] = 'tls';
    $_POST['host'] = 'smtp.google.com';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TEST EMAIL SMTP</title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-2 col-12"></div>
            <div class="col-md-8 col-12 py-5">
                <h3>TEST SMTP</h3>
                <p class="text-muted">Use this to test your SMTP Connection Data</p>


                <?php

                if(isset($_POST['mail_send'])){
                    //remove debug
                    $mail->SMTPDebug = 1;
                    $mail->Host = getPost('host');
                    $mail->SMTPAuth = true;
                    $mail->Username = getPost('username'); 
                    $mail->Password = getPost('password'); 
                    $mail->SMTPSecure = getPost('security');
                    $mail->Port = getPost('port');
                    $mail->setFrom(getPost('from-email'), 'Sender');
                    $mail->addReplyTo(getPost('from-email'), 'Sender');
                    $mail->addAddress(getPost('to-email'), 'Recipient'); 
                    $mail->Subject = 'Test Email via SMTP using PHPMailer';
                    $mail->isHTML(true);
                    $mailContent = "<h1>Send HTML Email using SMTP in PHP</h1>
                    <p>This is a test email I’m sending using SMTP mail server with PHPMailer.</p>";
                    $mail->Body = $mailContent;


                    if($mail->send()){
                        ?>
                        <div class="alert alert-success"> Message has been sent </div>
                        <?php
                    }else{
                        ?>
                        <div class="alert alert-warning">
                            Message could not be sent. <br/> Mailer Error:
                            <?php echo $mail->ErrorInfo; ?>
                        </div>
                        <?php
                    }

                }
                ?>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">


                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">Username</span>
                        <input type="text" class="form-control" placeholder="Username" name="username" value="<?= getPost('username'); ?>">
                    </div>


                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">Password</span>
                        <input type="text" class="form-control" placeholder="Password" name="password" value="<?= getPost('password'); ?>">
                    </div>

                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">Host</span>
                        <input type="text" class="form-control" placeholder="HOST" name="host" value="<?= getPost('host'); ?>">
                    </div>


                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">Port</span>
                        <input type="text" class="form-control" placeholder="Port" name="port" value="<?= getPost('port'); ?>">
                    </div>


                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">Security</span>
                        <select class="form-select" name="security">
                            <option value="tls" <?= getPost('security') == 'tls'?'selected':''; ?> >TLS</option>
                            <option value="ssl" <?= getPost('security') == 'ssl'?'selected':''; ?>>SSL</option>
                        </select>
                        <!-- <input type="text" class="form-control" placeholder="Security" name="security" value="<?= getPost('security'); ?>"> -->
                    </div>

                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">From E-Mail</span>
                        <input type="text" class="form-control" placeholder="From Email" name="from-email" value="<?= getPost('from-email'); ?>">
                    </div>


                    <div class="input-group-bl mb-3">
                        <span class="input-placeholder">To E-Mail</span>
                        <input type="text" class="form-control" placeholder="To Email" name="to-email" value="<?= getPost('to-email'); ?>">
                    </div>


                    <input class="btn btn-sm btn-success" type="submit" name="mail_send" value=" Send Test Email">
                </form>

            </div>
            <div class="col-md-2 col-12"></div>
        </div>
    </div>

</body>
</html>