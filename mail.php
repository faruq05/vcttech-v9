<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $applicantName = isset($_POST['applicant_name']) ? htmlspecialchars($_POST['applicant_name']) : '';
    $email1 = isset($_POST['email1']) ? htmlspecialchars($_POST['email1']) : '';
    $email2 = isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : '';
    $address = isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '';
    
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
    $wlLogo_name = isset($_POST['wlLogo_name']) ? htmlspecialchars($_POST['wlLogo_name']) : '';
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
    $to = "info@gmsakibur.com"; // Replace with the appropriate email address
    $subject = "New Form Design Request Submission";

    // Email body
   $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; padding: 20px;">';
    $message .= '<h2 style="color: #333; margin-bottom: 20px;">New Form Purchase Form Submission</h2>';
    $message .= '<table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; font-size: 14px;">';
    $message .= '<tr><td style="background-color: #f4f4f4; width: 20%; border: 1px solid #ddd;"><strong>Applicant Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $applicantName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email 1:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $email1 . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email 2:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $email2 . '</td></tr>';
    $message .= '<tr><td style="background-color:#f4f4f4; border: 1px solid #ddd;"><strong>Address:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $address . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoStyle . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Color:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoColor . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $logoComment . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Propose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlPropose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Pages:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlPage . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlComment . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_style . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Color:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_color . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_name . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_link . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website + Logo Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $wlLogo_comment . '</td></tr>';
    
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Propose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websitePropose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Pages:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websitePages . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Link:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteLink . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Website Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $websiteComment . '</td></tr>';
    
    
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureName . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Title:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureTitle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Profile:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureProfile . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Logo:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureLogo . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email Signature Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailSignatureComment . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Title:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationTitle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Software:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationSoftware . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Style:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationStyle . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Slides:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationSlides . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Presentation Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $presentationComment . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationName . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Date:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationDate . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Info:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationInfo . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Design:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationDesign . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Invitation Comment:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $invitationComment . '</td></tr>';
$message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Other Comments:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $otherComment . '</td></tr>';

    $message .= '</table>';

    // Email headers
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= 'From: Your Name <your_email@example.com>' . "\r\n";
    $headers .= 'Reply-To: ' . $email1 . "\r\n";

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        // Mail sent
        $response = array('type' => 'success', 'message' => 'Your message has been sent successfully.');
        echo json_encode($response);
    } else {
        // Mail not sent
        $response = array('type' => 'error', 'message' => 'Oops! There was a problem sending your message. Please try again later.');
        echo json_encode($response);
    }
}
?>
