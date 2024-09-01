<?php
require_once 'functions.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>You're Not signed up.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/index.css">
    </head>
    <body>

    <ul class="navbar">

                    <form class = "nav" action="" method="GET">

                        <input class = "search" type="text" id="search" name="search" placeholder="search a topic...">

                        <input type="submit" class = "search-btn" value="Search">

                    </form>

                </ul>

                <ul class = "logo-navbar">
                    <li>
                                <button id ="logo-nav" class="logo-nav" ><img class = "toggle-icon" src = "menu.svg"></button> 
                    </li>

                    <li>
                        <a href = "index.php">
                            <div class="logo-nav">
                                <p class = "logo-label-nav">Wshare</p>
                            </div>
                        </a>
                    </li>

                </ul>
                
                <ul class="left-navbar" id="left-navbar">
                    
                    <ul class = "logo-navbar-in-left">
                        <li>
                                    <button id ="logo-left-nav" class="logo-nav" ><img class = "toggle-icon" src = "menu.svg"></button> 
                        </li>

                        <li>
                            <a href = "index.php">
                                <div class="logo-nav">
                                    <p class = "logo-label-nav">Wshare</p>
                                </div>
                            </a>
                        </li>

                    </ul>
                        

                    <li>
                        <a href="#">

                            <div class = "left-nav">

                                <img class = "login_user_pic" src="default_pic.svg" >
                                <h3 class = "username-nav">Welcome,  <b>Guest</b>!</h3>
                            </div>
                        </a>
                
                    </li>

                    <li>
                        <a href = "#">
                            <div class = "left-nav">
                                <img class = "icons" src = "homepage.svg">
                                <p class = "label_nav">Home</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <div class = "left-nav">
                                <img class = "icons" src = "chats2.svg">
                                <p class = "label_nav">Chats</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <div class = "left-nav">
                                <img class = "icons" src = "searchpeople.svg">
                                <p class = "label_nav">Search a User</p>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="#">
                            <div class = "left-nav">
                                <img class = "icons" src = "twopeople.svg">
                                <p class = "label_nav">Network</p>
                            </div>
                        </a>
                    </li>

                </ul><br>

    <div class="container">

    <?php

        //if hindi nakalogin ito maglabas
        echo '<div class = "welcome_container" style = "width: 1000px;">';
        
        echo '<p class = "welcome" style = "margin:150px; color: #007bff; font-size: large;"><a href="login.php">Login</a> or <a href="signup.php"> Sign Up</a> now to join your fellow crimsons in interesting discussions.</p>';
        
        echo '</div>';

        echo '<div class="dropdown">

                        <button class="dropbtn">Sort post by</button>

                        <div class="dropdown-content">

                            <a href="?sort=time">Newest</a>
                            <a href="?sort=date">Oldest</a>
                            <a href="?sort=comments">Most Popular</a>
                            <a href="?sort=Bpts">Highest Brilliant Points</a>

                        </div>

                </div><br><br>';

                
                
                

                // Display ng mga posts or search result
                if(isset($_GET['search']) && !empty($_GET['search'])) 
                
                    {
                        // Search for posts sa database gamit ang searchPosts function
                        $search = $_GET['search'];
                        
                        $posts = searchPosts($search);
                        
                        echo '<h3 class = "search_results">Search Results</h3>';
                    
                    } 
                
                else 
                
                    {
                        // Display recent posts 
                        
                        $posts = getRecentPosts();

                        
                    }



                    
                    if(isset($_GET['sort'])) {

                        $sort = $_GET['sort'];
                        switch($sort) {
                            case 'time':
                                $posts = getPostsSortedByTime();
                                break;
                            case 'date':
                                $posts = getPostsSortedByDate();
                                break;
                            case 'comments':
                                $posts = getPostsSortedByComments();
                                break;
                            case 'Bpts';
                                $posts = getPostsSortedByBPTS();
                                break;
                            default:
                                $posts = getRecentPosts();
                                break;
                        }
                    }    

                if ($posts)
                
                {   
                    
                    
                    foreach ($posts as $post)
                    
                    {
                        
                        echo '<div class = "post-container">';

                            echo '<div class="post">';

                                $userProfile = getUserProfileById($post['UserID']);
                                $profilePic = $userProfile['ProfilePic'];
                               

                                echo '<div class = "pic_user">';

                                    //profile pict
                                    if (!empty($profilePic)) {
                                        echo '<img class ="author_pic" src="' . $profilePic . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">';
                                    } else {
                                        echo '<img class = "author_pic" src="default_pic.svg" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">';
                                    }

                                    //username title content timestamp etc

                                    echo '<div class = "user_post_info">';
                                    
                                        echo '<p class = "post_username"><a class = "post_uname" href = "#">' . $post['Username'] . '</a></p>';
                                        echo '<p class = "post_time">posted at: ' . $post['CreatedAt'] . '</p>';
                                        
                                    
                                    echo '</div>';
                                
                                
                                echo '</div>';

                                

                                
                                
                                echo '<hr/>';
                                echo '<h3 class = "post_title">' . $post['Title'] . '</h3>';
                                echo '<hr/>';

                                echo '<p class = "post_content">' . $post['Content'] . '</p>';
                                

                                echo '<div class = "lik">';

                                    echo '<form class = "like" action="#">';

                                        echo '<input type="hidden" name="postID" value="' . $post['PostID'] . '" >';

                                        echo '<button type="submit" class="like-btn" name="like"><img class = "bulb" src ="bulb.svg"></button>';

                                    echo '</form>';

                                    echo '<span class="like-count">' . getLikeCount($post['PostID']) . '</span>';

                                    $num_comm = countComments($post['PostID']);

                                    echo '<button class ="like-btn"><img class = "bulb" src = "comment.svg"></button>';

                                    echo '<span class = "like-count"> '. $num_comm .'</span>';
                                    
                                    echo '<button class = "like-btn"><a href="#"><img class = "bulb" src = "view.svg"></a></button>';
                                    echo '<span class = "like-count">see thread</span>';

                                echo '</div>';

                                
                                    
                                

                            echo '</div>';

                                                
                        echo '</div>';
                    }

                } 
                
                else 
                
                {

                    echo '<h4 style = "color: #007bff; text-align:center; paddng-top:200px;padding-bottom:200px;">No topic yet... you may start the topic by posting.</h4>';

                }

    ?>

    </div>

    <script>
        document.getElementById('logo-nav').addEventListener('click', function() {
            var element = document.getElementById('left-navbar');
                if (element.style.display === 'none') {
                        element.style.display = 'block';
                        
                } else {
                        element.style.display = 'none';
                }
            }
        );                    
    </script>

    <script>
        document.getElementById('logo-left-nav').addEventListener('click', function() {
            var element = document.getElementById('left-navbar');
                if (element.style.display === 'none') {
                        element.style.display = 'block';
                        
                } else {
                        element.style.display = 'none';
                }
            }
        );                    
    </script>

    <script>
        document.getElementById('comm_label').addEventListener('click', function() {
            var element = document.getElementById('comments');
                if (element.style.display === 'none') {
                        element.style.display = 'block';
                        
                } else {
                        element.style.display = 'none';
                }
            }
        );                    
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./javascripts/index.js"></script>
    
    </body>

</html>