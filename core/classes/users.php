<?php
class Users{
    protected $conn;
    function __construct($conn){
        $this->conn = $conn;
    }

    function checkEmail($email){
        $sql = "SELECT email FROM users WHERE email = '{$email}'";
        $query = mysqli_query($this->conn, $sql);
        if(mysqli_num_rows($query)>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function createUser($first_name,$last_name,$email,$hashed_password){
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('{$first_name}','{$last_name}', '{$email}', '{$hashed_password}')";
        $query = mysqli_query($this->conn,$sql);
        if($query){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function getAction(){
        $sql = "SELECT * FROM action order by time desc";
        $result = mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>=1){//if there is any record
            return $result;
        }else{
            $_SESSION['error'] = "No Recent Action Found!!";
        } 
    }
    
    function setAction($msg){
        $op_by = $_SESSION['user_id'];
        $sql = "INSERT INTO action(msg,op_by) VALUE('$msg',$op_by)";
        $result = mysqli_query($this->conn,$sql);
    }

    function getCurrentYear(){
        include_once "library/nepali-date.php";
        $date = new nepali_date;
        $date = $date->get_nepali_date(date('Y', time()), date('m', time()), date('d', time()));
        $thisYear = (int)$date['y'];
        return $thisYear;
    }


}
?>
