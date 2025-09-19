<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        die("Username and password are required.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Admin registered successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Registration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f0f2f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.container {
    max-width: 400px;
    margin: 80px auto;
    padding: 30px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #0d6efd;
}
input {
    border-radius: 8px;
}
button {
    border-radius: 8px;
    background: #0d6efd;
    color: #fff;
    font-weight: bold;
    transition: 0.3s;
}
button:hover {
    background: #0b5ed7;
}
</style>
</head>
<body>
<div class="container">
    <h2>Admin Registration</h2>
    <form method="post">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Admin Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="w-100 btn btn-primary">Register Admin</button> <br>
        <a href="admin_login.php"> <button >Admin Login</button></a>
    </form>
</div>
</body>
</html>

