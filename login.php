<?php
session_start();
require 'config.php';  // Veritabanı bağlantısı için gerekli dosya

// Kullanıcı giriş yapmışsa doğrudan ana sayfaya yönlendir
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Veritabanı sorgusu
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Kullanıcı doğrulama ve şifre kontrolü
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;  // Oturum açıldı
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Kullanıcı adı veya şifre hatalı";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
</head>
<body>
<h2>Giriş Yap</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form action="login.php" method="POST">
    <label for="username">Kullanıcı Adı:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Şifre:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Giriş Yap</button>
</form>
</body>
</html>

