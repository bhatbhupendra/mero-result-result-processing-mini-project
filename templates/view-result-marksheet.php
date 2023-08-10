<?php
    require_once "config.php";                                   ///embed PHP code from another file            
    require_once "core/load.php";                                   ///embed PHP code from another file  
    
    session_start();            //starting session

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $terminal = trim($_POST["terminal"]);  
        $class = trim($_POST["class"]);
        $reg_no = (int)trim($_POST["reg_no"]);

        $data = $marksheetClassObject->getStudentInfo($reg_no,$class,$terminal);
        $marksData = $marksheetClassObject->getStudentMarks($reg_no,$class,$terminal);
        $calclation = $marksheetClassObject->calculate($marksData);
        $PARatio = $marksheetClassObject->getPassFail($userClassObject->getCurrentYear());

    }
?>



<head>
    <link rel="stylesheet" href="assets/css/marksheet.css">
</head>


<?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['result-submit'])){ ?>
    <div class="marksheet">
        <div class="marksheet-container">
            <div class="marksheet-title">
                <div class="marksheet-schoolLogo">
                    <img src="assets/images/school.jpg" alt="logo">
                </div>
                <div class="marksheet-schoolName">
                    <span>"Knowledge is the power."</span>
                    <h1>Parbandha Academy</h1>
                    <span>Sanepa, Lalitput</span>
                    <h3> <u>First Termainal Exam Marksheet</u></h3>
                </div>
                <div class="marksheet-softwareName">
                    <img src="assets/images/smart.jpg" alt="logo2">
                </div>
            </div><hr>
            <div class="marksheet-info">
                <div class="marksheet-infoLeft">
                    <label>Student's Name: <?php echo $data['first_name'] ." " .$data['last_name'] ?></label>
                    <label>Father's Name: <?php echo $data['father_name'] ?></label>
                    <label>Reg No:<?php echo $data['reg_no'] ?></label>
                    <label>Academic year:<?php
                                            $yearString = (string)$reg_no;
                                            $yearString = preg_split('//', $yearString , -1, PREG_SPLIT_NO_EMPTY);
                                            echo  $yearString[0].$yearString[1].$yearString[2].$yearString[3];
                                        ?></label>
                </div>
                <div class="marksheet-infoRight">
                    <label>Class: <?php echo $class ?> </label>
                    <label>Result No:8943</label>
                    <label>DOB:<?php echo $data['dob'] ?></label>
                    <label>Language: Nepali</label>
                </div>
            </div><hr>
            <div class="marksheet-result">
                <div class="marksheet-result-wrapper">
                    <table class="marksheet-result-table">
                        <tr>
                            <th>
                                S.N
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>
                                Full mark
                            </th>
                            <th>
                                Pass mark
                            </th>
                            <th>
                                Obtained mark
                            </th>
                        </tr>
                        
                        
                        <?php $SN = 1 ?>
                        <?php foreach($marksData as $row){ ?>
                            <tr>
                                <td><?php echo $SN ?></td>
                                <td><?php echo $row['subject_name'] ?></td>
                                <td>100</td>
                                <td>40</td>
                                <td>
                                    <?php 
                                        if($row['mark']>=40){
                                            echo $row['mark'];
                                        }else{
                                            echo "{$row['mark']} <sup style='color: red ;'>*</sup>";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php $SN += 1 ?>
                        <?php } ?>

                        <tr>
                            <td colspan="5">Total Mark Obtained :<?php echo $calclation['totalObtainMark'] ?> out of <?php echo $calclation['totalFullMark'] ?></td>
                        </tr>
                    </table>
                </div>
            </div><hr>
            <div class="marksheet-per">
                <div class="marksheet-per-wrapper">
                    <span>Percentage: <?php echo $calclation['percentage'] ?>%</span>
                    <span>Grade: <?php echo $calclation['grade'] ?></span>
                    <span>GPA: <?php echo $calclation['gpa'] ?></span>
                </div>
            </div><hr>
            <div class="marksheet-note"> 
                Disclaimer: Not for Offical Purpose.
            </div>
        </div>
    </div>

    <div class="marksheet-print-seciton">
            <div class="marksheet-print">
                <button class="print-button" id="print-button" type="button" id="print">Print</button>
            </div>
    </div>

<?php } ?>
