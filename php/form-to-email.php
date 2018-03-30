<?php

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate submission form is filled out correctly
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are required.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Email value not accepted.";
    exit;
}

$email_from = "$visitor_email";//<== updating email to visitor's email
$email_subject = "New Form submission";
$email_body = "You have received a new message from $name.\n\n". "Here is the message:\n $message\n\n". "$name's email: $visitor_email\n\n".
    
$to = "jeffnhorner@outlook.com";//<== What email address the submission is being sent
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";

//Sending the email
mail($to,$email_subject,$email_body,$headers);

//Email sent; redirecting to thank-you page
header('Location: thank-you.html');


// Function to validate against any bad email/spammer attempts
function IsInjected($str){
  $injections = array(
              '(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";

  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 