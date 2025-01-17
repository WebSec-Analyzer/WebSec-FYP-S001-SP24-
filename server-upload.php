<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if a file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        // Move the uploaded file to a desired folder
        $uploadDir = 'uploads/';
        $destFilePath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destFilePath)) {
            // Send the file via email
            $to = 'owaisaliarshad@gmail.com';
            $subject = 'File Uploaded';
            $message = 'A new file has been uploaded.';

            // Headers for email
            $headers = "From: no-reply@example.com\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

            // Email body
            $body = "--boundary\r\n";
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
            $body .= $message . "\r\n\r\n";

            // Attachment
            $fileContent = chunk_split(base64_encode(file_get_contents($destFilePath)));
            $body .= "--boundary\r\n";
            $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= $fileContent . "\r\n";
            $body .= "--boundary--";

            // Send the email
            if (mail($to, $subject, $body, $headers)) {
                echo json_encode(['status' => 'success', 'message' => 'File uploaded and email sent']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or error in file upload']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
