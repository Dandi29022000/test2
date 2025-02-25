<?php
    require 'db.php';
    header('Content-Type: application/json');
    ob_start(); // Bersihkan output buffer

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    // Validation
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }

    if (!empty($errors)) {
        ob_end_clean(); // Hapus output sebelum JSON
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    // Save to database
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password_hash);
    
    if ($stmt->execute()) {
        ob_end_clean(); // Hapus output sebelum JSON
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        ob_end_clean(); // Hapus output sebelum JSON
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }

    $stmt->close();
    $conn->close();
    exit;
?>