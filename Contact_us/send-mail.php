<?php
header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Read and sanitize input
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Basic validation
if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please provide a valid email address.']);
    exit;
}

// Optional: limit message length
if (strlen($message) > 5000) {
    echo json_encode(['success' => false, 'message' => 'Message is too long.']);
    exit;
}

// Prepare email
$to = 'hanifatijani13@gmail.com'; // change this
$subject = "Contact message from {$name}";
$body = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}";

// Use a fixed FROM that matches your domain to reduce spam flags
$headers = [];
$headers[] = 'From: Website Contact <no-reply@hanifwebpage.netlify.app>';
$headers[] = "Reply-To: {$email}";
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headersString = implode("\r\n", $headers);

// Try sending
$sent = @mail($to, $subject, $body, $headersString);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
} else {
    // On failure, avoid leaking server details. Log the problem for debugging.
    // error_log("Contact form: mail() failed for {$email}");
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Try again later.']);
}
