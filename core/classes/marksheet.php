<?php
    class Marksheet extends student{
        protected $conn;
        function __construct($conn){
            $this->conn = $conn;
        }

        function getStudentInfo($reg_no,$class,$terminal){
            $sql = "SELECT * FROM student s, marks m, subject sb WHERE s.reg_no=m.reg_no && m.subject_id = sb.subject_id 
                && s.reg_no=$reg_no
                && m.terminal='$terminal'
                && m.class='$class'
                ";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                $row=mysqli_fetch_assoc($result);
                return $row;
            }else{
                $_SESSION['error']='No Data Found??';
                header("location:view-result.php");
            }
        }


        function getStudentMarks($reg_no,$class,$terminal){
            $sql = "SELECT * FROM student s, marks m, subject sb WHERE s.reg_no=m.reg_no && m.subject_id = sb.subject_id 
                && s.reg_no=$reg_no
                && m.terminal='$terminal'
                && m.class='$class'
                ";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                $marksData = array();
                while($row=mysqli_fetch_assoc($result)){
                    array_push($marksData,$row);
                }
                return $marksData;
            }else{
                // $error = "No Data Found??";
                $_SESSION['error']='No Data Found??';
                header("location:view-result.php");
            }
        }

        function calculate($marksData){
            $totalObtainMark=0;
            $totalFullMark=0;
            $percentage=0;
            $grade=0;
            $totalSubject=0;
            $gpa=0;

            foreach($marksData as $row){
                $totalObtainMark+=$row['mark'];
                $totalFullMark+=100;
                $totalSubject++;
            }
            $percentage = ($totalObtainMark/$totalFullMark)*100;
            $gpa = $percentage/25;

            if(3.6 < $gpa && $gpa <= 4.0 ){
                $grade="A+";
            }else if(3.2 < $gpa && $gpa <= 3.6){
                $grade="A";
            }else if(2.8 < $gpa && $gpa <= 3.2){
                $grade="B+";  
            }else if(2.4 < $gpa && $gpa <= 2.8){
                $grade="B";  
            }else if(2.0 < $gpa && $gpa <= 2.4){
                $grade="C+";    
            }else if(1.6 < $gpa && $gpa <= 2.0){
                $grade="C";  
            }else if(0.8 < $gpa && $gpa <= 1.6){
                $grade="D";  
            }else if(0 < $gpa && $gpa <= 0.8){
                $grade="E";  
            }else{
                $grade="N";
            }

            return array(
                "totalFullMark"=>$totalFullMark,
                "totalObtainMark"=>$totalObtainMark,
                "percentage"=>$percentage,
                "grade"=>$grade,
                "totalSubject"=>$totalSubject,
                "gpa"=>$gpa,
            );

        }

        function countTerminal(){
            $sql = "SELECT COUNT(DISTINCT terminal) as count FROM marks;";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $totalTerm = (int)$row['count'];
            if($totalTerm==1){
                return array('First');
            }else if($totalTerm==2){
                return array('First','Second');
            }else if($totalTerm==3){
                return array('First','Second','Third');
            }else{
                return array('First','Second','Third','Final');
            }
        }

        function calculateRank($reg_no,$terminal){
            $yearString = (string)$reg_no;
            $yearString = preg_split('//', $yearString , -1, PREG_SPLIT_NO_EMPTY);
            $class =  (int)$yearString[4].$yearString[5];
            $year =  (int)$yearString[0].$yearString[1].$yearString[2].$yearString[3];

            $my_mark = $this::calculate($this::getStudentMarks($reg_no,$class,$terminal))['totalObtainMark'];
            $my_rank = 1;

            $temp_regno = (int) $year.$class.'00';
            for($i=0;$i<parent::getTotalStudentInClass($year,$class);$i++){
                // $marksData = $this::getStudentMarks($temp_regno,$class,$terminal);
                // $calclation = $this::calculate($marksData);
                //$other_mark = $calclation['totalObtainMark'];
                //in short
                $other_mark = $this::calculate($this::getStudentMarks($temp_regno,$class,$terminal))['totalObtainMark'];
                
                //we supposed the mark of individual mark is unique
                //this can be fixed by using flag with rank = rank- flag and flag = flag++ of two mark or comparision are same
                
                if($my_mark<$other_mark){
                    $my_rank++; //increase the rank
                }

                //increment bcze to get next regno of student of same class
                $temp_regno++;
            }
            return $my_rank;
        }

        function getPassFail($date){
            //get the year
            $greaterThen = (int)$date."0000";//20790000
            $lessThen = (int)$date."9999";//20799999
            
            $sql = "SELECT reg_no from student where reg_no >= $greaterThen and reg_no < $lessThen ";
            // echo $sql;

            $result = mysqli_query($this->conn,$sql);
            $studentRegNos = array();
            $total=0;
            while($row=mysqli_fetch_assoc($result)){
                array_push($studentRegNos,$row);
                $total++;
            }
            // var_dump($studentRegNos);

            $first=0;$second=0;$third=0;$final=0;$preboard=0;$ut=0;
            $terminals = array('first','second','third','final','preboard','ut');

            foreach($studentRegNos as $RegNo){
                foreach($terminals as $terminal){
                    $sql = "SELECT * from marks where reg_no={$RegNo["reg_no"]} && terminal='{$terminal}'";
                    $result = mysqli_query($this->conn,$sql);

                    $firstFlag=0;$secondFlag=0;$thirdFlag=0;$finalFlag=0;$preboardFlag=0;$utFlag=0;
                    while($mark=mysqli_fetch_assoc($result)){
                        if($mark['mark']<40 && $terminal=="first"){
                            $firstFlag=1;
                        }else if($mark['mark']<40 && $terminal=="second"){
                            $secondFlag=1;
                        }else if($mark['mark']<40 && $terminal=="third"){
                            $thirdFlag=1;
                        }else if($mark['mark']<40 && $terminal=="final"){
                            $finalFlag=1;
                        }else if($mark['mark']<40 && $terminal=="preboard"){
                            $preboardFlag=1;
                        }else if($mark['mark']<40 && $terminal=="ut"){
                            $utFlag=1;
                        }else{
                            $error = "Somethin wents wrong!!";
                        }
                        
                        // echo "<pre>";
                        // var_dump($mark);
                    }
                    $first+=$firstFlag;
                    $second+=$secondFlag;
                    $third+=$thirdFlag;
                    $final+=$finalFlag;
                    $preboard+=$preboardFlag;
                    $ut+=$utFlag;
                }
            }
            return array(
                "first"=>$first,
                "second"=>$second,
                "third"=>$third,
                "final"=>$final,
                "totalFail"=>$final,
                "total"=>$total,
            );

        }

        function getYearPassFail(){
            $yearData =array();//declare

            $sql = "SELECT DISTINCT reg_no FROM student WHERE reg_no like '____0000' ORDER by reg_no ASC";
            $result = mysqli_query($this->conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                $reg_no = (int)$row['reg_no'];
                $year = preg_split('//', $reg_no , -1, PREG_SPLIT_NO_EMPTY);
                $year =  (int)$year[0].$year[1].$year[2].$year[3];

                $data = $this::getPassFail($year);
                $yearData += array("$year"=>$data);
            }
            return $yearData;
        }

        function sendMail($reg_no){
            session_start();
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
            $body = "Hi, This is auto generate Mail Just to let you Know Result is out at http://localhost/mini/view-result.php";
            $headers = "From: bhatt.bhupendra.76@gmail.com";    //From: bhatt.bhupendra.76@gmail.com
            
            if (mail($to_email, $subject, $body, $headers)) {
                $_SESSION['error'] = "MailSendTo $to_email!!";
                header("location:dashboard.php");
            } else {
                $_SESSION['error'] = "Failed to Send Mail!!";
                header("location:dashboard.php");
            }
        }

        function sendMails(){
            $sql = "SELECT reg_no FROM student";
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                while($row = mysqli_fetch_assoc($result)){
                    $reg_no = (int)$row['reg_no'];
                    // $data = $this::sendMail($reg_no);
                }
                $_SESSION['error'] = "Mail send to all students!!";
                header("location:dashboard.php");
            }else{
                $_SESSION['error'] = "Student Dosent Exixt For Email!!";
                header("location:dashboard.php");
            } 
        }
        
    }
?>