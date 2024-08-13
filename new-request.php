<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $applicantName = isset($_POST['applicant_name']) ? htmlspecialchars($_POST['applicant_name']) : '';
    $address = isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '';
    $emails = isset($_POST['email']) ? $_POST['email'] : array(); // Array of emails
    $logoStyle = isset($_POST['logo_style']) ? htmlspecialchars($_POST['logo_style']) : '';
    $logoColor = isset($_POST['logo_color']) ? htmlspecialchars($_POST['logo_color']) : '';
    $logoName = isset($_POST['logo_name']) ? htmlspecialchars($_POST['logo_name']) : '';
    $logoLink = isset($_POST['logo_link']) ? htmlspecialchars($_POST['logo_link']) : '';
    $logoComment = isset($_POST['logo_comment']) ? htmlspecialchars($_POST['logo_comment']) : '';
    
    $wlName = isset($_POST['wl_name']) ? htmlspecialchars($_POST['wl_name']) : '';
    $wlPropose = isset($_POST['wl_propose']) ? htmlspecialchars($_POST['wl_propose']) : '';
    $wlPage = isset($_POST['wl_pages']) ? htmlspecialchars($_POST['wl_pages']) : '';
    $wlLink = isset($_POST['wl_link']) ? htmlspecialchars($_POST['wl_link']) : '';
    $wlComment = isset($_POST['wl_comment']) ? htmlspecialchars($_POST['wl_comment']) : '';
    $wlLogo_style = isset($_POST['wlLogo_style']) ? htmlspecialchars($_POST['wlLogo_style']) : '';
    $wlLogo_color = isset($_POST['wlLogo_color']) ? htmlspecialchars($_POST['wlLogo_color']) : '';
    $wlLogo_link = isset($_POST['wlLogo_link']) ? htmlspecialchars($_POST['wlLogo_link']) : '';
    $wlLogo_comment = isset($_POST['wlLogo_comment']) ? htmlspecialchars($_POST['wlLogo_comment']) : '';
    
    $websiteName = isset($_POST['website_name']) ? htmlspecialchars($_POST['website_name']) : '';
    $websitePropose = isset($_POST['website_propose']) ? htmlspecialchars($_POST['website_propose']) : '';
    $websitePages = isset($_POST['website_pages']) ? htmlspecialchars($_POST['website_pages']) : '';
    $websiteLink = isset($_POST['website_link']) ? htmlspecialchars($_POST['website_link']) : '';
    $websiteComment = isset($_POST['website_comment']) ? htmlspecialchars($_POST['website_comment']) : '';
    
    $emailSignatureName = isset($_POST['emailSignature_name']) ? htmlspecialchars($_POST['emailSignature_name']) : '';
    $emailSignatureTitle = isset($_POST['emailSignature_title']) ? htmlspecialchars($_POST['emailSignature_title']) : '';
    $emailSignatureProfile = isset($_POST['emailSignature_profile']) ? htmlspecialchars($_POST['emailSignature_profile']) : '';
    $emailSignatureLogo = isset($_POST['emailSignature_logo']) ? htmlspecialchars($_POST['emailSignature_logo']) : '';
    $emailSignatureComment = isset($_POST['emailSignature_comment']) ? htmlspecialchars($_POST['emailSignature_comment']) : '';
    
    $presentationTitle = isset($_POST['presentation_topic']) ? htmlspecialchars($_POST['presentation_topic']) : '';
    $presentationSoftware = isset($_POST['presentation_software']) ? htmlspecialchars($_POST['presentation_software']) : '';
    $presentationStyle = isset($_POST['presentation_style']) ? htmlspecialchars($_POST['presentation_style']) : '';
    $presentationSlides = isset($_POST['presentation_slides']) ? htmlspecialchars($_POST['presentation_slides']) : '';
    $presentationComment = isset($_POST['presentation_comment']) ? htmlspecialchars($_POST['presentation_comment']) : '';
    
    $invitationName = isset($_POST['invitation_name']) ? htmlspecialchars($_POST['invitation_name']) : '';
    $invitationDate = isset($_POST['invitation_date']) ? htmlspecialchars($_POST['invitation_date']) : '';
    $invitationInfo = isset($_POST['invitation_info']) ? htmlspecialchars($_POST['invitation_info']) : '';
    $invitationDesign = isset($_POST['invitation_design']) ? htmlspecialchars($_POST['invitation_design']) : '';
    $invitationComment = isset($_POST['invitation_comment']) ? htmlspecialchars($_POST['invitation_comment']) : '';
    
    $otherComment = isset($_POST['other_comment']) ? htmlspecialchars($_POST['other_comment']) : '';
    
    $designRequest = isset($_POST['designRequest']) ? htmlspecialchars($_POST['designRequest']) : '';

    // Handle multiple email inputs
    if (!empty($emails)) {
        $emailList = implode(", ", array_map('htmlspecialchars', $emails)); // Sanitize and concatenate emails
    } else {
        $emailList = ''; // No emails provided
    }

    // Handle multiple file attachments
    $fileNames = isset($_FILES['attachment2']) ? $_FILES['attachment2'] : array();
    $fileList = '';
    if (!empty($fileNames)) {
        foreach ($fileNames['name'] as $index => $fileName) {
            if (!empty($fileName)) {
                $fileTmpName = $fileNames['tmp_name'][$index];
                $fileType = $fileNames['type'][$index];
                $fileSize = $fileNames['size'][$index];

                // Read the file content
                $fileContent = file_get_contents($fileTmpName);
                $fileContent = chunk_split(base64_encode($fileContent));

                // Email content with attachment
                $email_content = "--boundary\r\n";
                $email_content .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
                $email_content .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
                $email_content .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $email_content .= $fileContent . "\r\n";

                if (!empty($fileList)) {
                    $fileList .= "\r\n";
                }
                $fileList .= $email_content;
            }
        }
    }

    // Email content
    $to = "test@gmsakibur.com"; // Replace with the appropriate email address
    $subject = "New Form Design Request Submission";

    // Email body
    $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; padding: 20px;">';
    $message .= '<h2 style="color: #333; margin-bottom: 20px;">New Form Purchase Form Submission</h2>';
    $message .= '<table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; font-size: 14px;">';
   
   $message .= '<tr><td style="background-color: #f4f4f4; width: 20%; border: 1px solid #ddd;"><strong>Applicant Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $applicantName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Emails:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailList . '</td></tr>';
    $message .= '<tr><td style="background-color:#f4f4f4; border: 1px solid #ddd;"><strong>Address:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $address . '</td></tr>';
    
    
    if ($designRequest == 'LogoOnly') {
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Logo</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoStyle . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Color:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoColor . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoComment . '</td></tr>';
} elseif ($designRequest == 'WebsiteLogo') {
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Website + Logo</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Propose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlPropose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Pages:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlPage . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlComment . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_style . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Color:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_color . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_link . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_comment . '</td></tr>';
} elseif ($designRequest == 'WebsiteOnly') {
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Website Only</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Propose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websitePropose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Pages:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websitePages . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteComment . '</td></tr>';
} elseif ($designRequest == 'EmailSignature') {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Email Signature</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureName . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Title:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureTitle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Profile:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureProfile . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Logo:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureLogo . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureComment . '</td></tr>';
} elseif ($designRequest == 'Presentation') {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Presentation</td></tr>';
  $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Title:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationTitle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Software:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationSoftware . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationStyle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Slides:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationSlides . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationComment . '</td></tr>';
} elseif ($designRequest == 'Invitation') {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Invitation</td></tr>';
   $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationName . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Date:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationDate . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Info:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationInfo . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Design:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationDesign . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationComment . '</td></tr>';
} elseif ($designRequest == 'Others') {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request Type:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Other</td></tr>';
  $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Other Comments:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $otherComment . '</td></tr>';
}
    

    $message .= '</td></tr>';

    $message .= '</table>';
    $message .= '</div>';
    $message .= '</body></html>';

    // Headers for the email
    $headers = "From: " . implode(", ", $emails) . "\r\n";
    $headers .= "Reply-To: $emailList\r\n"; // Use the concatenated emails
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

    // Send email with attachments
    if (!empty($fileList)) {
        $email_content = "--boundary\r\n";
        $email_content .= "Content-Type: text/html; charset=UTF-8\r\n";
        $email_content .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $email_content .= "$message\r\n";
        $email_content .= "--boundary\r\n";
        $email_content .=$fileList;
        $email_content .= "--boundary--\r\n";

        if (mail($to, $subject, $email_content, $headers)) {
            // Send confirmation email to all inputed email addresses
            $email_from = "test@gmsakibur.com"; // Replace with your email address
            $email_to = $emails; // Get the email address(es) from the form input
            $first_name = $applicantName; // Get the first name from the form input

            // Check if $email_to is an array (i.e., multiple email addresses)
            if (is_array($email_to)) {
                $email_to = implode(", ", $email_to); // Concatenate the email addresses with a comma separator
            }

            $headers = "From: " . $email_from . "\r\n";
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
                .header {padding:40px 30px 20px 30px;}
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
                    .content {width: 600px !important;}.col425 {width: 425px!important;}
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
                                        Design Request Confirmation.
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

            @mail($email_to, $subjectEmailFrom, $messages , $headers);
        } else {
            echo "Failed to submit form. Please try again later.";
        }
    } else {
        // Send email without attachments
        $email_content = "--boundary\r\n";
        $email_content .= "Content-Type: text/html; charset=UTF-8\r\n";
        $email_content .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $email_content .= "$message\r\n";
        $email_content .= "--boundary--\r\n";

        if (mail($to, $subject,$email_content, $headers)) {
            // Send confirmation email to all inputed email addresses
            $email_from = "test@gmsakibur.com"; // Replace with your email address
            $email_to = $emails; // Get the email address(es) from the form input
            $first_name = $applicantName; // Get the first name from the form input

            // Check if $email_to is an array (i.e., multiple email addresses)
            if (is_array($email_to)) {
                $email_to = implode(", ", $email_to); // Concatenate the email addresses with a comma separator
            }

            $headers = "From: " . $email_from . "\r\n";$headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $messages = '<html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Confirmation Email</title>
                <style type="text/css">
                body {margin: 0; padding: 0; min-width: 100%!important;}
                img {height: auto;}
                .content {width: 100%; max-width: 600px;}
                .header {padding:40px 30px 20px 30px;}
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
                    .content {width: 600px !important;}.col425 {width: 425px!important;}
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
                                        Design Request Confirmation.
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

            @mail($email_to, $subjectEmailFrom, $messages , $headers);
        } else {
            echo "Failed to submit form. Please try again later.";
        }
    }
} else {
    echo "Invalid request.";
}
?>