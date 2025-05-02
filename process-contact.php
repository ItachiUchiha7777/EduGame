<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduplay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $name = $conn->real_escape_string(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = $conn->real_escape_string(trim($_POST['subject'] ?? ''));
    $message = $conn->real_escape_string(trim($_POST['message'] ?? ''));
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Check for empty fields
    if (empty($name) || !$email || empty($subject) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields correctly.']);
        exit;
    }
    
    // Prepare and execute SQL
    $stmt = $conn->prepare("
        INSERT INTO contact_submissions 
        (name, email, subject, message, ip_address) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit;
    }
    
    $stmt->bind_param("sssss", $name, $email, $subject, $message, $ip_address);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Optional: Send email notification
        // mail('contact@eduplay.com', "New Contact: $subject", $message, "From: $email");
        
        echo json_encode(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save your message. Please try again.']);
    }
    
    $stmt->close();
    $conn->close();
    exit;
}

// If not a POST request
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
exit;
?>