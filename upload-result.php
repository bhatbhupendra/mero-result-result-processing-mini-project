<?php
    require_once "config.php";

    session_start();
    
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true){              
        header("location: result.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://kit.fontawesome.com/118a820504.js" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="dashboard-container">
        <?php include "templates/nav-temp.php"; ?>
        <div class="dashboard-body-area">
            <?php include "templates/link-menu-temp.php"; ?>
            <div class="working-section">
                <?php include "templates/upload-result-temp.php"; ?>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_SESSION["error"])){ 
            $errorData = $_SESSION['error'];
            unset($_SESSION['error']);
            echo "<div class='error-txt'> $errorData </div>";
        }
    ?>

<script src="assets/js/result-upload-file.js"></script>
</body>
</html>