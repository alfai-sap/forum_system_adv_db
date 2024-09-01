<?php
require_once 'functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) 

{
    // Check if the required form fields are set
    if (isset($_POST['title'], $_POST['content'])) 
    
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $username = $_SESSION['username'];

        if (createPost($title, $content, $username)) 
        
        {
            header('Location: index.php'); // Redirect to forum page after successful post creation
            exit;

        } 
        
        else 
        
        {

            echo "Error creating post.";
        }

    } 
    
    else 
    
    {

        echo "Title and content fields are required."; // Error message if form fields are missing
    }


} 

else 

{

    // Redirect to login page if user is not logged in
    header('Location: login.php');

    exit;
}

?>