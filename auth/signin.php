<?php
session_start();
require_once '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

$username = trim($input['username'] ?? '');
$password = $input['password'] ?? '';

// Validation
if (empty($username)) {
    echo json_encode(['success' => false, 'message' => 'Username is required']);
    exit;
}

if (empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Password is required']);
    exit;
}

try {
    $db = get_db();
    
    // Get user by username or email
    $stmt = $db->prepare("SELECT user_id, username, email, password_hash, first_name, last_name FROM users WHERE (username = ? OR email = ?) AND is_active = 1");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Verify password
    if (!password_verify($password, $user['password_hash'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        exit;
    }
    
    // Combine first and last name
    $full_name = trim($user['first_name'] . ' ' . $user['last_name']);
    
    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['full_name'] = $full_name;
    $_SESSION['logged_in'] = true;
    
    echo json_encode([
        'success' => true, 
        'message' => 'Sign in successful!',
        'user' => [
            'id' => $user['user_id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'full_name' => $full_name
        ]
    ]);
    
} catch (Exception $e) {
    error_log("Signin error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>
