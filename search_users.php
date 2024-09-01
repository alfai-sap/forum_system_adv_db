<?php session_start();
    require_once 'functions.php';

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <link rel="stylesheet" href="./css/search_users.css">
</head>

<body>
        
    <ul class = "navbar">

        <form class = "nav" action="" method="GET">

            <input class = "search" type="text" id="search" name="query" placeholder="Enter username or Email...">

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
                        <a href="user_profile.php">

                            <div class = "left-nav">
                                <?php 

                                    $username = $_SESSION['username'];
                                    $user = getUserByUsername($username);
                                    
                                    if (!empty($user['ProfilePic'])): 
                                ?>
                                    <img class = "login_user_pic" src="<?php echo $user['ProfilePic']; ?>">
                                <?php else: ?>

                                    <img class = "login_user_pic" src="default_pic.svg" >
                                <?php endif; ?>

                                <?php echo '<h3 class = "username-nav">Welcome,  <b>' . $_SESSION['username'] . '</b>!</h3>';?>
                            </div>
                        </a>
                
                    </li>

                    <li>
                        <a href = "index.php">
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
                        <a href="search_users.php">
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

                    <li>
                        <a href="logout.php">
                            <div class = "left-nav">
                                <img class = "icons" src = "logout.svg">
                                <p class = "label_nav">Logout</p>
                            </div>
                        </a>
                    </li>
                </ul><br>

    <div class="container">

        <br>
        <br>
        <br>
        <br>
        
        <?php
        // Check if the search query is set
        if (isset($_GET['query'])) {
            $query = $_GET['query'];

            
            // Establish database connection
            $host = 'localhost';
            $dbname = 'wshare_db_new';
            $username = 'root';
            $password = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare and execute the SQL query
                $statement = $pdo->prepare("SELECT Users.Username, Users.Email, UserProfiles.ProfilePic FROM Users LEFT JOIN UserProfiles ON Users.UserID = UserProfiles.UserID WHERE Users.Username LIKE :query OR Users.Email LIKE :query");
                $statement->execute(['query' => "%$query%"]);

                // Fetch results
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                // Display search results
                foreach ($results as $result) {

                    echo '<div class="search-result"><a class = "view_profile" href="view_user.php?username=' . urlencode($result['Username']) . '">';

                        echo '<div class = "prof_uname">';

                            if ($result['ProfilePic']) {
                                echo '<img class ="prof_pic" src="' . $result['ProfilePic'] . '">';
                            } else {
                                echo '<img class ="prof_pic" src="default_pic.svg">';
                            }
                            // Display username
                            echo '<div class = "uname_email">';

                                echo '<p style = "margin-left:10px;"><b>' . $result['Username'] . '<b></p>';
                                echo "<p class = 'wmsu_email' style = 'margin:10px; color:#007bff; font-size: small; opacity: 80%;'>" . $result['Email'] . "</p>";

                            echo '</div>';

                        echo '</div>';
                    
                    echo '</a></div>';
                }

            } catch (PDOException $e) {
                // Handle connection errors
                echo "Connection failed: " . $e->getMessage();
            }
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
</body>
</html>

