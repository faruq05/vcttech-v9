<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $applicantName = isset($_POST['applicant_name']) ? htmlspecialchars($_POST['applicant_name']) : '';
    $companyName = isset($_POST['company_name']) ? htmlspecialchars($_POST['company_name']) : '';
    $domainName = isset($_POST['domain_name']) ? htmlspecialchars($_POST['domain_name']) : '';
    $ownerName = isset($_POST['owner_name']) ? htmlspecialchars($_POST['owner_name']) : '';
    $businessPurpose = isset($_POST['business_purpose']) ? htmlspecialchars($_POST['business_purpose']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
    $hostingRequiredRadio = isset($_POST['hostingRequiredRadio']) ? htmlspecialchars($_POST['hostingRequiredRadio']) : '';
    $emails = isset($_POST['email']) ? $_POST['email'] : array(); // Array of emails
    $comments = isset($_POST['comments']) ? htmlspecialchars($_POST['comments']) : '';

    // Handle multiple email inputs
    if (!empty($emails)) {
        $emailList = implode(", ", array_map('htmlspecialchars', $emails)); // Sanitize and concatenate emails
    } else {
        $emailList = ''; // No emails provided
    }

    // Handle multiple file attachments
    $fileNames = isset($_FILES['attachment']) ? $_FILES['attachment'] : array();
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
    $to = "support@vecttech.com";
    $subject = "New Domain Form Submission";

    // Email body
    $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; padding: 20px;">';
    $message .= '<h2 style="color: #333; margin-bottom: 20px;">New Domain Purchase Form Submission</h2>';
    $message .= '<table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; font-size: 14px;">';
    $message .= '<tr><td style="background-color: #f4f4f4; width: 20%; border: 1px solid #ddd;"><strong>Applicant Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $applicantName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Company Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $companyName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Domain Name:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $domainName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Domain Owner:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $ownerName . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Business Purpose:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $businessPurpose . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Phone:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $phone . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Address:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $address . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Email:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $emailList . '</td></tr>';
    $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Comments:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">' . $comments . '</td></tr>';

    // Add hosting required logic
    if ($hostingRequiredRadio == 'yes') {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Hosting Required:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">Yes</td></tr>';
    } else {
        $message .= '<tr><td style="background-color: #f4f4f4; border: 1px solid #ddd;"><strong>Hosting Required:</strong></td><td style="border: 1px solid #ddd; padding-left: 10px;">No</td></tr>';
    }

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
            echo "Form submitted successfully!";
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
            echo "Form submitted successfully!";
        } else {
            echo "Failed to submit form. Please try again later.";
        }
    }
} else {
    echo "Invalid request.";
}
?>