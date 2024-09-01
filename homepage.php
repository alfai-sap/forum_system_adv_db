<?php
session_start();
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wshare Home</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <!-- Navigation Bar -->
    <ul class="navbar">
        <form class="nav" action="" method="GET">
            <input class="search" type="text" id="search" name="search" placeholder="search a topic...">
            <input type="submit" class="search-btn" value="Search">
        </form>
    </ul>

    <!-- Logo Navigation Bar -->
    <ul class="logo-navbar">

        <li><button id="logo-nav" class="logo-nav"><img class="toggle-icon" src="menu.svg"></button></li>

        <li>
            <a href="index.php">
                <div class="logo-nav">
                    <p class="logo-label-nav">Wshare</p>
                </div>
            </a>
        </li>

    </ul>

    <!-- Left Navigation Bar -->
    <ul class="left-navbar" id="left-navbar">

        <ul class="logo-navbar-in-left">

            <li><button id="logo-left-nav" class="logo-nav"><img class="toggle-icon" src="menu.svg"></button></li>

            <li>
                <a href="index.php">
                    <div class="logo-nav">
                        <p class="logo-label-nav">Wshare</p>
                    </div>
                </a>
            </li>

        </ul>

        <li>
            <a href="user_profile.php">

                <div class="left-nav">
                    <?php
                    // Get user information from the session variable after login
                    $username = $_SESSION['username'];
                    $user = getUserByUsername($username);

                    if (!empty($user['ProfilePic'])):
                    ?>
                        <img class="login_user_pic" src="<?php echo $user['ProfilePic']; ?>">
                    <?php else: ?>
                        <img class="login_user_pic" src="default_pic.svg">
                    <?php endif; ?>

                    <h3 class="username-nav">Welcome, <b><?php echo $_SESSION['username']; ?></b>!</h3>
                </div>
            </a>

        </li>

        <li>
            <a href="index.php">

                <div class="left-nav">
                    <img class="icons" src="homepage.svg">
                    <p class="label_nav">Home</p>
                </div>

            </a>
        </li>

        <li>
            <a href="#">

                <div class="left-nav">
                    <img class="icons" src="chats2.svg">
                    <p class="label_nav">Chats</p>
                </div>

            </a>
        </li>

        <li>
            <a href="search_users.php">

                <div class="left-nav">
                    <img class="icons" src="searchpeople.svg">
                    <p class="label_nav">Search a User</p>
                </div>

            </a>
        </li>

        <li>
            <a href="#">

                <div class="left-nav">
                    <img class="icons" src="twopeople.svg">
                    <p class="label_nav">Network</p>
                </div>

            </a>
        </li>

        <li>
            <a href="logout.php">

                <div class="left-nav">
                    <img class="icons" src="logout.svg">
                    <p class="label_nav">Logout</p>
                </div>

            </a>
        </li>
    </ul><br>

    <!-- Main Content -->
    <div class="container">

        <?php if (isset($_SESSION['username'])): ?>

            <!-- Create Post Form -->
            <div class="post-form">

                <label class="create-label">Create A Post</label>

                <form id="post-form" action="create_post_process.php" method="POST">
                    <input class="post-title-in" type="text" id="title" name="title" placeholder="Title..." required>
                    <textarea class="post-content-in" id="content" name="content" placeholder="What am I thinking?..." required></textarea>
                    <input type="submit" class="post-postbtn-in" value="Post">
                </form>

            </div>

            <!-- Sort Dropdown -->
            <div class="dropdown">

                <button class="dropbtn">Sort post by</button>

                <div class="dropdown-content">
                    <a href="?sort=time">Newest</a>
                    <a href="?sort=date">Oldest</a>
                    <a href="?sort=comments">Most Popular</a>
                    <a href="?sort=Bpts">Highest Brilliant Points</a>
                </div>

            </div><br><br>

            <!-- Display Posts -->
            <?php

            if (isset($_GET['search']) && !empty($_GET['search'])) 
            {
                $search = $_GET['search'];
                $posts = searchPosts($search);
                echo '<h3 class="search_results">Search Results</h3>';
            } 
            else 
            {
                $posts = getRecentPosts();
            }


            if (isset($_GET['sort'])) 
            {
                $sort = $_GET['sort'];
                switch ($sort) 
                {
                    case 'time':
                        $posts = getPostsSortedByTime();
                        break;
                    case 'date':
                        $posts = getPostsSortedByDate();
                        break;
                    case 'comments':
                        $posts = getPostsSortedByComments();
                        break;
                    case 'Bpts':
                        $posts = getPostsSortedByBPTS();
                        break;
                    default:
                        $posts = getRecentPosts();
                        break;
                }
            }

            if ($posts):

                foreach ($posts as $post):

                    $userProfile = getUserProfileById($post['UserID']);
                    $profilePic = $userProfile['ProfilePic'];

            ?>
                    <div class="post-container">

                        <div class="post">

                            <div class="pic_user">

                                <?php if (!empty($profilePic)): ?>
                                    <img class="author_pic" src="<?php echo $profilePic; ?>" alt="Profile Picture">
                                <?php else: ?>
                                    <img class="author_pic" src="default_pic.svg" alt="Profile Picture">
                                <?php endif; ?>

                                <div class="user_post_info">

                                    <p class="post_username"><a class="post_uname" href="view_user.php?username=<?php echo urlencode($post['Username']); ?>"><?php echo $post['Username']; ?></a></p>
                                    <p class="post_time">posted at: <?php echo $post['CreatedAt']; ?></p>

                                </div>

                            </div>

                            <hr/>
                            <h3 class="post_title"><?php echo $post['Title']; ?></h3>
                            <hr/>

                            <p class="post_content"><?php echo $post['Content']; ?></p>

                            <div class="lik">

                                <form class="like" action="like_post.php" method="POST">
                                    <input type="hidden" name="postID" value="<?php echo $post['PostID']; ?>">
                                    <button type="submit" class="like-btn" name="like"><img class="bulb" src="bulb.svg"></button>
                                </form>

                                <span class="like-count"><?php echo getLikeCount($post['PostID']); ?></span>

                                <button class="like-btn"><img class="bulb" src="comment.svg"></button>

                                <span class="like-count"><?php echo countComments($post['PostID']); ?></span>

                                <button class="like-btn"><a href="view_post.php?id=<?php echo $post['PostID']; ?>"><img class="bulb" src="view.svg"></a></button>

                                <span class="like-count">see thread</span>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <h4 style="color: #007bff; text-align:center; padding-top:200px; padding-bottom:200px;">No topic yet... you may start the topic by posting.</h4>

            <?php endif; ?>

        <?php else: ?>

            <?php
                header('Location: guest.php');
                exit;
            ?>

        <?php endif; ?>

    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('logo-nav').addEventListener('click', function() {
            var element = document.getElementById('left-navbar');
            element.style.display = (element.style.display === 'none') ? 'block' : 'none';
        });

        document.getElementById('logo-left-nav').addEventListener('click', function() {
            var element = document.getElementById('left-navbar');
            element.style.display = (element.style.display === 'none') ? 'block' : 'none';
        });

        document.getElementById('comm_label').addEventListener('click', function() {
            var element = document.getElementById('comments');
            element.style.display = (element.style.display === 'none') ? 'block' : 'none';
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./javascripts/index.js"></script>

</body>

</html>
