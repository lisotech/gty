<?php
require_once '../config.php';
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Admin Login</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container checkout-container" style="margin-top:100px;">
        <h2>Admin Login</h2>
        <?php if($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Username</label><input type="text" name="username" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
