<?php
  $name = $_POST['name'];
  $subject = $_POST['subject'];
  $visitor_email = $_POST['email'];
  $message = $_POST['message'];
  $checkBox = $_POST['sendToMe'];

  $email_from = 'SCM-BRAGANCA@ProblemasNoModulo.com';

  // Insert the email that will receive the incoming message from the contact form
  $to = 'Email to be inserted';

  $email_subject = "$subject";

  $email_body = "User Name: $name\n\n".
                "Subject: $subject\n\n".
                "User Email: $visitor_email\n\n".
                "User Message: $message\n\n".

  $headers = "From: $email_from \r\n";

  $headers .= "Reply-To: $visitor_email \r\n";

  if(!empty($checkBox)){
    mail($to,$email_subject,$email_body,$headers);
    mail($visitor_email,$email_subject,$email_body,$headers);
  }
  else{
    mail($to,$email_subject,$email_body,$headers);
  }

  headers("Location: contacto.php");

?>
