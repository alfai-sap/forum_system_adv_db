<?php
require_once 'functions.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Check if username is provided in the URL parameter
if (!isset($_GET['username'])) {
    header('Location: index.php');
    exit;
}

// Get the username from the URL parameter
$username = $_GET['username'];

// Get user profile information
$user = getUserByUsername($username);

// Get posts created by the user
$user_posts = getUserPosts($username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user['Username']; ?>'s Profile</title>
    <link rel="stylesheet" href="./css/left-navbar.css">
    <link rel="stylesheet" href="./css/view_user.css">
</head>
<body>


        

<div class="container">

    <a class = "backButton" id ="backButton"><div class = "back" style = "display:flex; margin-bottom:30px;">
            
            <img class = "icons" src = "signoff.svg">
            <p class = "back-label" style="padding-top: 15px;color:#007bff">Back</p>
        
    </div></a>

    <h1>Profile</h1>
        <?php
            if ($user['ProfilePic']) {
                                echo '<div class = "photo" >';
                                echo '<img class = "profile_pic" src="' . $user['ProfilePic'] . '">';
                                echo '</div>';
                            } else {
                                echo '<div class = "photo" >';
                                echo '<img class = "profile_pic" src="default_pic.svg">';
                                echo '</div>';
                            }
        ?>

    <p class = "username"><b><?php echo $user['Username']; ?></b></p>

    <p class = "email"><b><?php echo $user['Email']; ?></b></p>
    
    <br>
    <h3>Bio</h3>
        <p class = "bio" id="bio"><?php echo htmlspecialchars($user['Bio']); ?></p>
    <br>
    <br>
    <h3 style="text-align:left;"><?php echo $user['Username']; ?>'s Posts</h3>

    <ul>
        <?php 
            if($user_posts){
                
                foreach ($user_posts as $post){

                    echo'    <li>';   
                    echo'        <div class="view-post">';
                    echo'           <b>'.$post['Title'].'</b>';
                    echo'           <form action="view_post.php" method="GET">   
                                        <input type="hidden" name="id" value="'.$post['PostID'].'">
                                        <button class = "non-nav-icon" type="submit"><img class = "non-nav-icon-img" src="view.svg"></button>
                                    </form>';
                    echo'        </div>';
                    echo'    </li>';
                }

            } else {
                echo'<p class = "no-post-yet" style = "color: #007bff; margin: 20px; text-align:center;"><b>No post yet.<b></p>';
            }
        ?>
        
    </ul>
    
    
    
    <br>
</div>


<script>
    // JavaScript to handle back button functionality
    document.getElementById('backButton').addEventListener('click', function() {
        // Go back in browser history
        window.history.back();
    });
</script>
</body>
</html>
