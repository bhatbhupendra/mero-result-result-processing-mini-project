<?php
    session_start();
    require_once "config.php";                                   ///embed PHP code from another file            
    require_once "core/load.php";                               ///embed PHP code from another file      

    if(isset($_GET['send-mails'])){
        $marksheetClassObject->sendMails();//calling sendMails function which send email to all
    }else{
        $_SESSION['error'] = "No GET Exist!!";
        header("location:dashboard.php");
        
    }
?>