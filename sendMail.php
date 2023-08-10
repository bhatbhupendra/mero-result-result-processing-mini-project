<?php
    session_start();
    require_once "config.php";                                   ///embed PHP code from another file            
    require_once "core/load.php";                               ///embed PHP code from another file      

    if(isset($_GET['mail-reg-no'])){
        $reg_no = (int)trim($_GET["mail-reg-no"]);
        $marksheetClassObject->sendMail($reg_no);//calling sendMail function which get email and call bult in mail function
    }else{
        $_SESSION['error'] = "No GET Exist!!";
        header("location:dashboard.php");
        
    }
?>