<?php
    class Student extends users{
        protected $conn;
        function __construct($conn){
            $this->conn = $conn;
        }
        function uploadCSV($fileLoc,$table,$class){

            //this function is used by usort for sorting by name 
            function cmp($a =array(), $b=array()){	
                $x = strtoupper($a[0].$a[1]);
                $y = strtoupper($b[0].$b[1]);
                return strcmp($x, $y);
            }
            //end

            $handle=fopen($fileLoc,"r");
            $i=0;
            $studentData = array();

            while(($data=fgetcsv($handle,1000,","))!==false){
                if($i==0){
                    $attribute=$data;
                }else{
                    array_push($studentData,$data);
                }
                $i++;
            }
            //ad to bs start--- libary to get current nepali year
            include_once "library/nepali-date.php";
            $y = date('Y', time()); //Getting Year
            $m = date('m', time()); //Getting Month
            $d = date('d', time()); //Getting Day
            $date = new nepali_date;
            $date = $date->get_nepali_date($y, $m, $d);
            $reg="";
            $reg = $date['y'];
            $reg = $reg.$class."00";
            $reg = (int)$reg;


            //ad to bs end

            //insert the data to table logic
            
            usort($studentData,"cmp");
            foreach($studentData as $row){
                $columns = implode(',', array_values($attribute)).',reg_no';
                $values =' " '. implode(' "," ',array_values($row)).' " ' . ',"'.$reg.'"';
                // $columns = $columns .',Reg';         //adding extra attrubute - reg no
                // $values = $values . ',"'.$reg.'"';
                $sql = "INSERT INTO {$table}({$columns})VALUES({$values})";
                $query = mysqli_query($this->conn,$sql);
                // print_r($sql);
                // print_r("<br>");
                $reg++;
            }

            //creating action
            parent::setAction("Student of Class $class is Uploaded!!");
            //backuping
            $this::backupCSV($fileLoc,$class);

            //the message student is uploaded
            if($class==00){
                $_SESSION['error']="Class Nursary Student Uploaded!!";
            }else{
                $_SESSION['error']="Class $class Student Uploaded!!";
            }
        }
        function searchStudent($search){
            $class = "____".$search."__";
            $sql = "SELECT * FROM student WHERE reg_no = '$search' or first_name LIKE '%$search%' or last_name LIKE '%$search%' or reg_no LIKE '$class' ";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                $students = array();
                while($row=mysqli_fetch_assoc($result)){
                    array_push($students,$row);
                }
                return $students;
            }else{
                // $error = "No Data Found??";
                $_SESSION['error']='No Student Data Found??';
                header("location:dashboard.php");
            }
        }

        function getTotalStudent(){
            $sql = "SELECT * FROM student";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                return mysqli_num_rows($result);
            }else{
                return 0;
            }
        }

        function getGraduate(){
            include_once "library/nepali-date.php";
            $date = new nepali_date;
            $date = $date->get_nepali_date(date('Y', time()), date('m', time()), date('d', time()));
            $reg = $date['y'];  //for getting current starting reg no
            $reg = $reg."1000";  //for getting current starting reg no
            $currentStartingRegNo = (int)$reg;  //so that we can get only those student that are less than this one
            $sql = "SELECT * FROM student WHERE reg_no < $currentStartingRegNo and reg_no LIKE '____10__'";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                return mysqli_num_rows($result);
            }else{
                return 0;
            }
        }

        function backupCSV($tmp_name,$class){
            move_uploaded_file($tmp_name,"backup/student/".$class.".csv");
        }

        function getProfile($reg_no){
            $sql = "SELECT * FROM student WHERE reg_no = $reg_no";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)==1){//if there is any record
                return mysqli_fetch_assoc($result);
            }else{
                $_SESSION['error']="The Student Profile doesn't Exist!!";
                header("location: dashboard.php");
            }
        }

        function getTotalStudentInClass($year,$class){
            $temp = (int)$year.$class."00";
            $temp2 = (int)$year.$class."99";   
            $sql="SELECT count(reg_no) as count from student where reg_no >= $temp and reg_no < $temp2 ";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return (int)$row['count'];
        }
    }

?>