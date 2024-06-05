<?php 
       require 'function.php';

       $akun = query("SELECT * FROM akun");
     
       if( isset($_POST["submit"]) ) {
         if( tambah_akun($_POST) > 0){
             echo "
                 <script>
                     alert('Data berhasil ditambahkan!');
                     document.location.href = 'login.php';
                 </script>
             ";
         } else {
             echo "
             <script>
             alert('Data gagal ditambahkan!');
             document.location.href = 'register.php';
             </script>
             ";
         }
       
       }
?>
<!DOCTYPE html>
<html>
<head>
     <title>Register</title>
     <link rel="website icon" type="jpg"  href="logo.jpg">
     <link rel="stylesheet" type="text/css" href="register.css">
</head>

<body>
     <div class="login">
          <h2 class="login-header">
               <img src="logo.jpg"
                    class="logo" />
               <br><br>
               Register Skuybor Accounting Information System
          </h2>

          <div class="login-container">
               <div style="color: red; margin-bottom: 15px">
            </div>
     <form method="POST" action="" onsubmit="return validateForm()">
     <label>Email</label><br/>
     <input type="text" name="email" id="email" placeholder="email" /><br /><br />
     <label>Username</label><br />
    <input type="text" name="username" id="username" placeholder="Username" /><br /><br />
    <label>Password</label><br />
    <input type="password" name="password" id="password" placeholder="Password" /><br /><br />
    <input type="submit" name="submit" value="Submit" /><br>
</form>
<a href="login.php" align="center">Sudah Punya Akun? Login Disini</a>
     </div>
     </div>
     <script>
    function validateForm() {
        const email = document.getElementById("email");
        const username = document.getElementById("username");
        const password = document.getElementById("password");

        if (email.value === "") {
            alert("Email wajib diisi!");
            email.focus();
            return false;
        }

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