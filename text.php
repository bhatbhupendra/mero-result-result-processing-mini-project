<?php
    // $to_email = "bhupendra420110bhat@gmail.com";
    // $subject = "Simple Email Test via PHP";
    // $body = "Hi, This is test email send by PHP Script";
    // $headers = "From: bhatt.bhupendra.76@gmail.com";

    // if (mail($to_email, $subject, $body, $headers)) {
    //     echo "Email successfully sent to $to_email...";
    // } else {
    //     echo "Email sending failed...";
    // }


    session_start();

    require_once "config.php";                                   ///embed PHP code from another file            
    require_once "core/load.php";                               ///embed PHP code from another file      

    if(isset($_GET['mail-reg-no'])){
        $reg_no = (int)trim($_GET["reg_no"]);
        $sql = "SELECT * FROM student WHERE reg_no = $reg_no";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>=1){//if there is any record
            $row=mysqli_fetch_assoc($result);
        }else{
            $_SESSION['error'] = "Student Dosent Exixt For Email!!";
            header("location:dashboard.php");
        } 
        $to_email = "{$row['email']}";
        $subject = "Result is Out!!!";
        $body = "Hi, This is auto generate Mail Just to let you Know Result is out";
        $headers = "From: bhatt.bhupendra.76@gmail.com";    //From: bhatt.bhupendra.76@gmail.com
        
        if (mail($to_email, $subject, $body, $headers)) {
            $_SESSION['error'] = "MailSendTo $to_email!!";
            // header("location:dashboard.php");
        } else {
            $_SESSION['error'] = "Failed to Send Mail!!";
            // header("location:dashboard.php");
        
        }
    }else{
        $_SESSION['error'] = "No GET Exist!!";
        header("location:dashboard.php");
        
    }
    
?>