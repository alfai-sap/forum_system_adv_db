<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Wshare</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login_process.php" method="POST">
            <input type="text" id="username" name="username" placeholder="username..." required><br><br>
            <input type="password" id="password" name="password" placeholder="password..." required><br><br>
            <input class="btn" type="submit" value="Login">
        </form>
        
        <p class="create">not signed in? <a href="signup.php">create an account</a></p>
        <p class="create">I forgot my <a href="login.php">password</a></p>
        <p class="create">back to <a href="../wshare landing page/landing page (FINAL).php">main page</a></p>
    </div>
</body>
</html>