<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(120deg, #0d6efd, #6c63ff);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #fff;
}
.container {
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    background: rgba(255,255,255,0.95);
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: #333;
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
.error {
    color: red;
    margin-top: 10px;
    text-align: center;
}
</style>
</head>
<body>
<div class="container">
    <h2>Admin Login</h2>
    <form method="post">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="w-100 btn btn-primary">Login</button>
        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    </form>
</div>
<p>if you are not admin do not regist or login already admin <a href="admin_register.php">regist</a> <br> 
<a href="homepage.html"> 
Home</a></p>
</body>
</html>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
