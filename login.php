<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash);
        $stmt->fetch();
        if (password_verify($_POST['password'], $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $_POST['username'];
            header("Location: chat.php");
            exit;
        }
    }
    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                        <p class="mt-3 mb-0 text-center">
                            Don't have an account? <a href="register.php">Register here</a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
