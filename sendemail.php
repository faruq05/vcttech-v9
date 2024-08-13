<?php
if($_POST['email'] === '' || $_POST['comments'] === '' || $_POST['first_name'] === '' || $_POST['subject'] === '' ) {
  echo "Missing Information";
  die;
}
if(isset($_POST['email'])) {

// Debes editar las próximas dos líneas de código de acuerdo con tus preferencias
$email_to = "info@vecttech.com";
$email_from = $_POST['email'];
$email_subject = "Contact from Vecttech.com";
$comments = "registered user";
$first_name = "empty";
$subject_form = "empty";

// Aquí se deberían validar los datos ingresados por el usuario
if(!isset($_POST['email'])) {

echo "<b>An error occurred and the form has not been sent. </b><br />";
die();
}

if(isset($_POST['comments'])){
    $comments = $_POST['comments'];
}
if(isset($_POST['first_name'])){
    $first_name = $_POST['first_name'];
}
if(isset($_POST['subject'])){
    $subject_form = $_POST['subject'];
}

$email_message = "Details of the contact form::\n\n";
$email_message .= "Name: " . $first_name . "\n";
$email_message .= "subject: " . $subject_form . "\n";
$email_message .= "E-mail: " . $_POST['email'] . "\n";
$email_message .= "Comments: " . $comments . "\n\n";

// Ahora se envía el e-mail usando la función mail() de PHP
$headers = 'From: '.$email_to."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);

// Send email confirmation

    $headers = "From: " . $email_to . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $messages = '<html xmlns="http://www.w3.org/1999/xhtml">

      <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>Confirmation Email</title>
       <style type="text/css">
       body {margin: 0; padding: 0; min-width: 100%!important;}
       img {height: auto;}
       .content {width: 100%; max-width: 600px;}
       .header {padding: 40px 30px 20px 30px;}
       .innerpadding {padding: 30px 30px 30px 30px;}
       .borderbottom {border-bottom: 1px solid #f2eeed;}
       .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
       .h2, .bodycopy {color: #153643; font-family: sans-serif;}
       .h1 {color: #ffffff; font-size: 33px; line-height: 38px; font-weight: bold; font-family: sans-serif;}
       .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
       .bodycopy {font-size: 16px; line-height: 22px; padding-top: 15px;}
       .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
       .button a {color: #ffffff; text-decoration: none;}
       .footer {padding: 20px 30px 15px 30px;}
       .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
       .footercopy a {color: #ffffff; text-decoration: underline;}

       @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
       body[yahoo] .hide {display: none!important;}
       body[yahoo] .buttonwrapper {background-color: transparent!important;}
       body[yahoo] .button {padding: 0px!important;}
       body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
       body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
       }

       /*@media only screen and (min-device-width: 601px) {
         .content {width: 600px !important;}
         .col425 {width: 425px!important;}
         .col380 {width: 380px!important;}
         }*/

       </style>
      </head>

      <body yahoo bgcolor="#f6f8f1">
      <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td>
         <!--[if (gte mso 9)|(IE)]>
           <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
             <tr>
               <td>
         <![endif]-->
         <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
           <tr>
             <td bgcolor="#ffffff" class="header">
               <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
               </table>
               <!--[if (gte mso 9)|(IE)]>
                 <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
                   <tr>
                     <td>
               <![endif]-->
               <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">
                 <tr>
                   <td height="70">
                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td class="h1" style="padding: 0 0 0 3px;">
                             <img src="http://VecTTech.com/img/logo_vecttech_black_tech.png" style="padding-bottom: 35px; width:200px;">
                         </td>
                       </tr>
                       <tr>
                         <td>
                           <hr color=#00BE94 />
                         </td>
                       </tr>
                     </table>
                   </td>
                 </tr>
               </table>
               <!--[if (gte mso 9)|(IE)]>
                     </td>
                   </tr>
               </table>
               <![endif]-->
             </td>
           </tr>
           <tr>
             <td class="innerpadding borderbottom">
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td class="h2">
                     Contact Confirmation.
                   </td>
                 </tr>
                 <tr>
                   <td class="bodycopy">
                     Dear '. $first_name .' <br>
                     <br>Thank you! We have received your message and would like to thank you for writing to us. We will reply by email as soon as possible.
                   </td>
                 </tr>
               </table>
             </td>
           </tr>
           <tr>
             <td class="innerpadding borderbottom">

             </td>
           </tr>
           <tr>

           </tr>
         </table>
         <!--[if (gte mso 9)|(IE)]>
               </td>
             </tr>
         </table>
         <![endif]-->
         </td>
       </tr>
      </table>

      <!--analytics-->
      <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
      </body>
      </html>';

	$subjectEmailFrom = 'Confirmation '.$email_to;

    @mail($email_from, $subjectEmailFrom, $messages , $headers);

echo "Completed";
}
?>
