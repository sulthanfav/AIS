<?php
session_start();

if (isset($_SESSION['username'])) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="icon" type="image/jpeg" href="logo.jpg">
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <div class="login">
        <h2 class="login-header">
            <img src="logo.jpg" class="logo" /><br><br>
            Skuybor Accounting Information System
        </h2>

        <div class="login-container">
            <div style="color: red; margin-bottom: 15px" class="message">
                <?php
                if (isset($_COOKIE["message"])) {
                    echo $_COOKIE["message"];
                }
                ?>
            </div>
            <form method="post" action="proses_login.php" onsubmit="return validateForm()">
                <label>Username</label><br />
                <input type="text" name="username" id="username" placeholder="Username" /><br /><br />
                <label>Password</label><br />
                <input type="password" name="password" id="password" placeholder="Password" /><br /><br />
                <input type="submit" name="login" value="Login" /><br>
                <input type="reset" name="cancel" value="Batal" />
                <a href="register.php" align="center">Belum Punya Akun? Register Disini</a>
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            const username = document.getElementById("username");
            const password = document.getElementById("password");

            if (username.value === "") {
                alert("Username wajib diisi!");
                username.focus();
                return false;
            }

            if (password.value === "") {
                alert("Password wajib diisi!");
                password.focus();
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
