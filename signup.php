<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up to Wshare</title>
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>

    <div class="container">

        <h1>Sign Up</h1>

        <form action="signup_process.php" method="POST">

            <input type="text" id="username" name="username" placeholder="username..." required><br><br>
            <input type="email" id="email" name="email" placeholder="wmsu email..." pattern="[a-zA-Z]{2}(2018|2019|202\d){1}\d{5}@wmsu.edu.ph" title="Email must be in the format 'xx2024#####@wmsu.edu.ph'" required><br><br>
            <input class="pass" type="password" id="password" name="password" placeholder="password..." required>
            <button id="passwordToggle" type="button" onclick="togglePassword(event)">show</button>
            
            <div class="checkbox-container">
                <input type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                <p>I agree to the <a href="tos.php">Terms of Service</a> and <a href="pp.php">Privacy Policy</a></p>
            </div>
            
            <input class="btn" type="submit" value="Sign Up">
            
        </form>

        <p class="create">already have an account? <a href="login.php">log in</a></p>
        <p class="create">back to <a href="../wshare landing page/landing page (FINAL).php">main page</a></p>
    </div>
    
    <script>
        function togglePassword(event) {
            event.preventDefault();
            var passwordField = document.getElementById("password");
            var passwordToggle = document.getElementById("passwordToggle");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordToggle.textContent = "hide";
            } else {
                passwordField.type = "password";
                passwordToggle.textContent = "show";
            }
        }
    </script>

</body>
</html>