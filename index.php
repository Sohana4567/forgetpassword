<?php
    require('PHPMailer/PHPMailerAutoload.php');
    require('credential.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    $conn=mysqli_connect("localhost","root","","forget_password");
       if(isset($_POST['forgrt'])){
           $email = $_POST['email'];
           $select= "SELECT * FROM  `users` WHERE  email='$email'";
           $result= mysqli_query($conn,$select);
           $count= mysqli_num_rows($result);
           $data=mysqli_fetch_array($result);
           $idData = $data['id'];
           $emailData = $data['email'];
           $nameData = $data['name'];
           $url = 'http://'.$_SERVER['SERVER_NAME'].'/forgetpassword/changepass.php?id='.$idData.'&email='.$emailData;
           $output='Hi,please click this link to change your password.<br>'.$url;
           if($email==$emailData){
            $mail = new PHPMailer;

            $mail->SMTPDebug = 2;                               // Enable verbose debug output
            
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'EMAIL';                 // SMTP username
            $mail->Password = 'PASS';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                    // TCP port to connect to
            
            $mail->setFrom(EMAIL, 'Localhost');
            //$mail->addAddress('sohanagupta2@gmail.com');
            $mail->addAddress($email, '$nameData');     // Add a recipient
           // $mail->addAddress('ellen@example.com');               // Name is optional
           // $mail->addReplyTo('info@example.com', 'Information');
           // $mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            
           // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
          //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = 'Reset Password :';
            $mail->Body    = $output;
          //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
               $msg= '<div class="alert alert-success">Message has been sent</div>';
            }
           }else{
               $errMsg = '<div class="alert alert-danger">Your Email address invalid</div>';
           }
       }
    ?>
    <br><br><br><br>
    <div class="container">
       <?php if (isset($msg)){
           echo $msg;
       }?>
       <?php if (isset($errMsg)){
           echo $errMsg;
       }?>
       <form action="" method="post">
       <h1>Reset  Your  Password</h1>
           <hr>
         <div class="col-md-12" style="width: 40%">
         <div class="form-group">
         <label>Enter  Email</label>
         <input class="form-control"  type="email" name="email" placeholder="Enter Email">
         </div> 
         <div class="form-group">
           <input class="btn btn-success pull-left" type="submit" name="forgrt" value="Submit">
           <a href="login.php" class="btn btn-warning pull-right">Log In</a>
           </div>
           </div>
           </form>
          </div>   
</body>
</html>