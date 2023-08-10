<?php
    class Result extends users{
        protected $conn;
        function __construct($conn){
            $this->conn = $conn;
        }
        function getSubjectId($subjects = array()){
            //this function retun subject id if there is registered subject
            //if new subject is encountored then it register new subject
            //and finally returns the arrey of subject id
            $subject_id = array();
            array_shift($subjects);//removing its attrubute ie reg_no
            for($i=0; $i < count($subjects); $i++){
                $sql = "SELECT subject_id as sub_id from subject where subject_name='$subjects[$i]'";
                $result = mysqli_query($this->conn,$sql);
                if($row=mysqli_fetch_assoc($result)){//fetch and get id
                    $subject_id[$i] = $row['sub_id'];
                }else{//create and get id
                    $sql = "INSERT INTO subject(subject_name)VALUES('$subjects[$i]')";
                    mysqli_query($this->conn,$sql);
                    $sql = "SELECT subject_id as sub_id from subject where subject_name='$subjects[$i]'";
                    $result = mysqli_query($this->conn,$sql);
                    $row=mysqli_fetch_assoc($result);
                    $subject_id[$i] = $row['sub_id'];
                }
            }
            return $subject_id;
        }


        function uploadCSV($fileLoc,$table,$class,$terminal){
            //checking the mark smaller then 100
            //return true if there is valid mark ie less then 100
            //return false if there is mark greter then 100
            $isValid = $this::checkMarkIsValid($fileLoc);
            $dupCount = 0;

            if($isValid){
                $handle=fopen($fileLoc,"r");
                $i=0;
                while(($row=fgetcsv($handle,1000,","))!==false){
                    if($i==0){
                        $attribute=$row;
                        $subs_ids = array();
                        $subs_ids = $this->getSubjectId($attribute);
                    }else{
                        //checking and avoiding the insertion of the duplicate mark of student
                        //for each student
                        //In variavle $row we have the result data from 
                        //we check if there is already the data for student
                        $isAlready = $this::avoidInsertCsvData($row,$terminal);//this return true of data already in db(same,duplicate)

                        if(!$isAlready){
                            $regno = $row[0];
                            for($i=0;$i<count($subs_ids);$i++){
                                $subject_id = $subs_ids[$i];
                                $class = (int)$class;
                                $mark = $row[$i+1];
                                $sql="INSERT INTO marks(reg_no,class,subject_id,terminal,mark) VALUES($regno,$class,$subject_id,'$terminal',$mark) ";
                                // echo "<pre>";
                                // echo $sql;
                                $query = mysqli_query($this->conn,$sql);
                            }        
                        }else{
                            $dupCount +=1;
                        }
                    }
                    $i++;
                }

                //creating action
                parent::setAction("Mark C/T $class/$terminal is Uploaded!!");
                
                //backuping
                $this::backupCSV($fileLoc,$class);
                
                //this is not error msg "File is Uploded"
                $_SESSION['error'] = "File Uploaded Sucessefully!!";;
                
                //printing error
                if($dupCount > 0){
                    $_SESSION['error'] = "$dupCount Duplicate Skiped!!";
                }

            }else{
                // this is error 
                //
                $_SESSION['error'] = "Mark in CSV is't Valid..Check!!";
            }
        }

        // this finction escape insertion if the mark of particular student is already inserted
        function avoidInsertCsvData($markData,$terminal){
            $sql = "SELECT * FROM marks where reg_no = {$markData['0']} and terminal = '$terminal' "; //arrey $markData index 0 has reg_no
            $result = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($result)>=1){//if there is any record
                return true;
            }else{
                return false;
            }
        }


        function backupCSV($tmp_name,$class){
            move_uploaded_file($tmp_name,"backup/mark/".$class.".csv");
        }

        function checkMarkIsValid($fileLoc){
            $handle=fopen($fileLoc,"r");
            $i=0;
            while(($row=fgetcsv($handle,1000,","))!==false){
                if($i==0){
                    $attribute=$row;
                    $subs_ids = $this->getSubjectId($attribute);
                }else{
                    for($j=0;$j<count($subs_ids);$j++){
                        $mark = $row[$j+1];
                        if($mark > 100){
                            return false;
                        }
                    }        
                }
                $i++;
            }
            return true;
        }
    }

?>