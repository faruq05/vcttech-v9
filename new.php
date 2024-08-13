<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $applicantName = isset($_POST['applicant_name']) ? htmlspecialchars($_POST['applicant_name']) : '';
    $email1 = isset($_POST['email1']) ? htmlspecialchars($_POST['email1']) : '';
    $email2 = isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : '';
    $address = isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '';
    $designRequest = isset($_POST['designRequest']) ? htmlspecialchars($_POST['designRequest']) : '';
    $logo_style = isset($_POST['logo-style']) ? htmlspecialchars($_POST['logo-style']) : '';


    // Handle multiple email inputs
    if (!empty($emails)) {
        $emailList = implode(", ", array_map('htmlspecialchars', $emails)); // Sanitize and concatenate emails
    } else {
        $emailList = ''; // No emails provided
    }

    // Handle multiple link inputs
    if (!empty($links)) {
        $linkList = implode(", ", array_map('htmlspecialchars', $links)); // Sanitize and concatenate links
    } else {
        $linkList = ''; // No links provided
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
    $to = "support@vecttech.com"; // Replace with the appropriate email address
    $subject = "New Form Design Request Submission";

    // Email body
    $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; padding: 20px;">';
    $message .= '<h2 style="color: #333; margin-bottom: 20px;">New Form Purchase Form Submission</h2>';
    $message .= '<table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; font-size: 14px;">';
    $message .= '<tr><td style="background-color: #f4f4f4; width: 20%; border: 1px solid #ddd;"><strong>Applicant Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $applicantName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Company Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $companyName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Domain Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $domainName . '</td></tr>';
    $message .= '<tr><td style="background-color:#f4f4f4; border: 1px solid #ddd;"><strong>Domain Owner:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $ownerName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Business Purpose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $businessPurpose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Phone:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $phone . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Address:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $address . '</td></tr>';

    // Add design request label to the email
    $designRequestLabel = '';
    switch ($designRequest) {
        case 'LogoOnly':
            $designRequestLabel = 'Logo Only';
            break;
        case 'WebsiteLogo':
            $designRequestLabel = 'Website + Logo';
            break;
        case 'WebsiteOnly':
            $designRequestLabel = 'Website Only';
            break;
        case 'EmailSignature':
            $designRequestLabel = 'Email Signature';
            break;
        case 'Presentation':
            $designRequestLabel = 'Presentation';
            break;
        case 'Invitation':
            $designRequestLabel = 'Invitation';
            break;
        case 'Others':
            $designRequestLabel = 'Other';
            break;
    }
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Design Request:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $designRequestLabel . '</td></tr>';

    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Other Request:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $otherRequest . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Emails:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailList . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Similar Websites:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $linkList . '</td></tr>';

    // Add website sections
     $websiteSectionsString = implode(", ", $websiteSections);
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Sections:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteSectionsString . '</td></tr>';
    
    // Add Other Pages
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Other Sections:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $otherMorePages . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Comments:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $comments . '</td></tr>';
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
            $email_from = "support@vecttech.com"; // Replace with your email address
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
            $email_from = "support@vecttech.com"; // Replace with your email address
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