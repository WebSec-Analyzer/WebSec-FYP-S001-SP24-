<?php
// Include PHPMailer
// require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");

$host = 'localhost';
$db = 'websa';
$user = 'root';
$pass = '';

// Database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Helper function to send JSON responses
function sendJsResponse($status, $message, $data = [])
{
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

function sendResponse($status, $message, $redirectUrl = '', $data = '')
{
    if ($status) {
        // Redirect to the URL if provided
        if ($redirectUrl) {
            header("Location: http://localhost:80/WebSA/$redirectUrl");
            // echo"<script>localStorage.setItem('user', $data); window.location.href='http://localhost:80/WebSA/$redirectUrl';</script>";
            exit;
        } else {
            // Provide a success message with an optional URL if needed
            echo "<script>window.location.href='http://localhost:80/WebSA/$redirectUrl';</script>";
            exit;
        }
    } else {
        // In case of failure, you can redirect or show an error message
        echo "<script>alert('$message'); window.location.href='http://localhost:80/WebSA/$redirectUrl';</script>";
        exit;
    }
}


// Process the API request
$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

// if ($method === 'POST' && $endpoint === 'signin') {
//     // Sign-in API
//     $email = $_POST['email'] ?? '';
//     $password = $_POST['password'] ?? '';

//     if (!$email || !$password) {
//         sendResponse(false, 'Email and password are required');
//     }

//     // Check user credentials
//     $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->execute([$email]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($user && password_verify($password, $user['password'])) {
//         $stmt = $pdo->prepare("UPDATE users SET isLogin = 1 WHERE email = ?");
//         $stmt->execute([$email]);
//         sendResponse(true, 'Sign-in successful', 'analyze.php', $email);
//     } else {
//         sendResponse(false, 'Invalid email or password');
//     }

if ($method === 'POST' && $endpoint === 'signin') {
    // Sign-in API (REST format)
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';


    if (!$email || !$password) {
        sendJsResponse(false, 'Email and password are required');
    }

    // Check user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $stmt = $pdo->prepare("UPDATE users SET isLogin = 1 WHERE email = ?");
        $stmt->execute([$email]);
        sendJsResponse(true, 'Sign-in successful', ['user' => $user]);
    } else {
        sendJsResponse(false, 'Invalid email or password');
    }

} elseif ($method === 'POST' && $endpoint === 'signout') {
    // Sign-out API
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';

    if (!$email) {
        sendResponse(false, 'Email is required');
    }

    $stmt = $pdo->prepare("UPDATE users SET isLogin = 0 WHERE email = ?");
    $stmt->execute([$email]);
    sendResponse(true, 'Sign-out successful');

    // } elseif ($method === 'POST' && $endpoint === 'eventAccess') {
//     // Event Access API
//     $email = $_POST['email'] ?? '';

    //     if (!$email) {
//         sendResponse(false, 'Email is required');
//     }

    //     $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->execute([$email]);
//     $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if (!$user) {
//         sendResponse(false, 'User not found');
//     }

    //     if (!$user['isLogin']) {
//         sendResponse(false, 'User must be logged in to access events');
//     }

    //     if ($user['isPaid']) {
//         sendResponse(true, 'Access granted', ['remainingAccess' => 'Unlimited']);
//     } elseif ($user['eventCount'] < 3) {
//         $stmt = $pdo->prepare("UPDATE users SET eventCount = eventCount + 1 WHERE email = ?");
//         $stmt->execute([$email]);
//         sendResponse(true, 'Access granted', ['remainingAccess' => 3 - $user['eventCount'] - 1]);
//     } else {
//         sendResponse(false, 'Daily limit reached for free users');
//     }

    // } 
} elseif ($method === 'POST' && $endpoint === 'eventAccess') {
    // Event Access API
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';

    if (!$email) {
        sendJsResponse(false, 'Email is required');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        sendJsResponse(false, 'User not found');
    }

    if (!$user['isLogin']) {
        sendJsResponse(false, 'User must be logged in to access events');
    }

    $currentTime = new DateTime();
    $lastAccess = new DateTime($user['lastAccess']);
    $interval = $lastAccess->diff($currentTime);

    if ($interval->days >= 1) {
        // If last access was more than 24 hours ago, reset the event count to 0
        $stmt = $pdo->prepare("UPDATE users SET eventCount = 0, lastAccess = ? WHERE email = ?");
        $stmt->execute([$currentTime->format('Y-m-d H:i:s'), $email]);
        $user['eventCount'] = 0;
    }

    if ($user['isPaid']) {
        sendJsResponse(true, 'Access granted', ['eventCount' => 'Unlimited']);
    } elseif ($user['eventCount'] < 3) {
        $stmt = $pdo->prepare("UPDATE users SET eventCount = eventCount + 1, lastAccess = ? WHERE email = ?");
        $stmt->execute([$currentTime->format('Y-m-d H:i:s'), $email]);
        sendJSResponse(true, 'Access granted', ['eventCount' => $user['eventCount']]);
    } else {
        sendJsResponse(false, 'Daily limit reached for free users');
    }
}


// Sign-up API
// elseif ($method === 'POST' && $endpoint === 'signup') {
//     // Receive user input
//     $email = $_POST['email'] ?? '';
//     $password = $_POST['password'] ?? '';
//     $confirmPassword = $_POST['confirmPassword'] ?? '';  // Added for confirmation field
//     $isPaid = isset($_POST['isPaid']) && $_POST['isPaid'] == 'on' ? 1 : 0;  // Check if checkbox is checked

//     // Validate inputs
//     if (!$email || !$password) {
//         sendResponse(false, 'Email and password are required', 'login.html');
//     }

//     // Check if email already exists
//     $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
//     $stmt->execute([$email]);
//     $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($existingUser) {
//         sendResponse(false, 'Email already exists', 'login.html');
//     }


//     // Hash the password
//     $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

//     // Insert new user into the database
//     $stmt = $pdo->prepare("INSERT INTO users (email, password, isLogin, isPaid, eventCount) VALUES (?, ?, ?, ?, ?)");
//     $result = $stmt->execute([$email, $hashedPassword, 0, $isPaid, 0]);

//     if ($result) {
//         sendResponse(true, 'Sign-up successful', 'login.html');
//     } else {
//         sendResponse(false, 'Sign-up failed', 'login.html');
//     }
// } 

elseif ($method === 'POST' && $endpoint === 'signup') {
    // Parse JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    $confirmPassword = $input['confirmPassword'] ?? ''; // Confirmation field
    $isPaid = $input['isPaid'] == true ? 1 : 0; // Checkbox value

    // Validate inputs
    if (!$email || !$password) {
        sendJsResponse(false, 'Email and password are required');
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        sendJsResponse(false, 'Email already exists');
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (email, password, isLogin, isPaid, eventCount) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([$email, $hashedPassword, 0, $isPaid, 0]);

    if ($result) {
        sendJsResponse(true, 'Sign-up successful');
    } else {
        sendJsResponse(false, 'Sign-up failed');
    }
}

// elseif ($method === 'POST' && $endpoint === 'email') {

//     require 'vendor/autoload.php'; // Include Composer's autoloader

//         $input = json_decode(file_get_contents('php://input'), true);

//         $userEmail = $input['email'] ?? '';
//         $pdfFilePath = $input['pdfFilePath'] ?? '';
//         $reciver = $input['reciver'] ??'';
    
//         if (empty($userEmail) || empty($pdfFilePath)) {
//             sendJsResponse(false, 'Email and PDF file path are required');
//         } else {
//             $stmt = $pdo->prepare("SELECT isPaid FROM users WHERE email = ?");
//         $stmt->execute([$userEmail]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
//         if (!$user) {
//             // User not found
//             sendJsResponse(false, 'User not found');
//             return;
//         }
    
//         if ($user['isPaid'] != 1) {
//             // If user is not paid, return a message to prompt them to buy a plan
//             sendJsResponse(false, 'You must purchase a paid plan to send emails');
//             return;
//         }
    
//         // If user is paid, proceed to send the email
//         $mail = new PHPMailer(true);
//         try {
//             // Server settings
//             $mail->isSMTP();
//             $mail->Host = 'smtp.gmail.com'; // SMTP server
//             $mail->SMTPAuth = true;
//             $mail->Username = 'websa146@example.com'; // SMTP username
//             $mail->Password = 'websa@123'; // SMTP password
//             $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//             $mail->Port = 465;
    
//             // Recipients
//             $mail->setFrom('websa146@gmail.com', 'Your Name');
//             $mail->addAddress($reciver); // Add the recipient's email
    
//             // Attach the PDF file
//             if (file_exists($pdfFilePath)) {
//                 $mail->addAttachment($pdfFilePath); // Attach the PDF file
//             } else {
//                 sendJsResponse(false, 'PDF file not found');
//                 return;
//             }
    
//             // Content
//             $mail->isHTML(true);
//             $mail->Subject = 'Here is your Domain Report';
//             $mail->Body    = 'This PDF is generated by Web Security Analyzer.';
    
//             // Send the email
//             $mail->send();
//             sendJsResponse(true, 'Email sent successfully');
//         } catch (Exception $e) {
//             sendJsResponse(false, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
//         }
//     }
    
        


// }

elseif ($method === 'POST' && $endpoint === 'email') {

    require 'vendor/autoload.php'; // Include Composer's autoloader

    // Check if a file was uploaded
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        sendJsResponse(false, 'File upload failed or no file provided');
        return;
    } 

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        // Move the uploaded file to a desired folder
        $uploadDir = 'uploads/';
        $destFilePath = $uploadDir . $fileName;
    }

    $userEmail = $_POST['email'] ?? '';
    $reciver = $_POST['reciver'] ?? '';
    $uploadedFile = $_FILES['file'];
    $pdfFilePath = 'uploads/' . basename($uploadedFile['name']); // Save file in 'uploads' directory

    // Validate email and file upload
    if (empty($userEmail) || empty($reciver)) {
        sendJsResponse(false, 'Email and recipient address are required');
        return;
    }

    // Ensure 'uploads' directory exists
    // if (!is_dir('uploads')) {
    //     mkdir('uploads', 0777, true);
    // }

    // Move the uploaded file to the 'uploads' directory
    if (!move_uploaded_file($fileTmpPath, $destFilePath)) {
        sendJsResponse(false, 'Failed to save uploaded file');
        return;
    }

    // Check if user is paid
    $stmt = $pdo->prepare("SELECT isPaid FROM users WHERE email = ?");
    $stmt->execute([$userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // User not found
        sendJsResponse(false, 'User not found');
        return;
    }

    if ($user['isPaid'] != 1) {
        // If user is not paid, return a message to prompt them to buy a plan
        sendJsResponse(false, 'You must purchase a paid plan to send emails');
        return;
    }

    // Send the email
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host ='smtp.gmail.com';             //'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'websa146@gmail.com'; // SMTP username
        $mail->Password = 'abbx lpgf kvkb fvwe';    //'abbx lpgf kvkb fvwe'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->SMTPOptions = [
          'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
           ],
       ];


        $message = 'This PDF is generated by Web Security Analyzer.';

           // Email settings
        $mail->setFrom('websa146@gmail.com', 'Web Security Analyzer'); // Sender's email and name
        $mail->addAddress($reciver); // Recipient's email

        // Attach the uploaded file
        $mail->addAttachment($destFilePath, $fileName); // File path and optional custom file name


        $mail->addAddress($reciver); // Add the recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Here is your Domain Report';
        $mail->Body  = "
            <p>Hello,</p>
            <p>Please find the attached domain report generated by <b>Web Security Analyzer</b>.</p>
            <p>Best regards,<br>Web Security Analyzer Team</p>";

        // Send the email
        $mail->send();
        sendJsResponse(true, 'Email sent successfully');
    } catch (Exception $e) {
        sendJsResponse(false, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    } finally {
        // Optionally, delete the uploaded file from the server
        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }
    }
}


 else {
    sendJsResponse(false, 'Invalid API endpoint or method');
}

?>


//