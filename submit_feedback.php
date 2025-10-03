<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Enable error logging for debugging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_log("=== Feedback Submission Started ===");
error_log("POST data: " . print_r($_POST, true));
error_log("Session data: " . print_r($_SESSION, true));

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    error_log("Error: User not logged in");
    echo json_encode([
        'success' => false, 
        'message' => 'Please sign in to submit feedback.'
    ]);
    exit;
}

try {
    $db = get_db();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    $user_id = $_SESSION['user_id'];

    // Get and sanitize form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    $festival_id = !empty($_POST['festival_id']) ? (int)$_POST['festival_id'] : null;

    error_log("Processing feedback - User ID: $user_id, Name: $name, Email: $email, Festival ID: " . ($festival_id ?: 'NULL'));

    // Validation
    if (empty($name)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Name is required.'
        ]);
        exit;
    }

    if (empty($email)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Email is required.'
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid email format.'
        ]);
        exit;
    }

    if (empty($message)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Message is required.'
        ]);
        exit;
    }

    if (strlen($message) < 10) {
        echo json_encode([
            'success' => false, 
            'message' => 'Message must be at least 10 characters long.'
        ]);
        exit;
    }

    if (strlen($message) > 5000) {
        echo json_encode([
            'success' => false, 
            'message' => 'Message is too long (maximum 5000 characters).'
        ]);
        exit;
    }

    $stmt = $db->prepare("
        INSERT INTO feedback (festival_id, username, email, message, user_id, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $db->error);
    }

    $stmt->bind_param("isssi", $festival_id, $name, $email, $message, $user_id);

    if ($stmt->execute()) {
        $feedback_id = $stmt->insert_id;
        error_log("Feedback submitted successfully. Feedback ID: $feedback_id");
        
        echo json_encode([
            'success' => true, 
            'message' => 'Thank you for your feedback! We appreciate your input and will get back to you soon.',
            'feedback_id' => $feedback_id
        ]);
    } else {
        throw new Exception('Failed to insert feedback: ' . $stmt->error);
    }

    $stmt->close();
    $db->close();

} catch (Exception $e) {
    error_log("Feedback submission error: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    
    echo json_encode([
        'success' => false, 
        'message' => 'An error occurred while submitting your feedback. Please try again later.',
        'debug_error' => $e->getMessage() // Remove this in production
    ]);
}
?>