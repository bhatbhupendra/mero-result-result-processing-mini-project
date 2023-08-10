<?php
    require_once "../config.php";                                   ///embed PHP code from another file            
    require_once "../core/load.php";                               ///embed PHP code from another file            
    $error = "";

    if (isset($_GET['reg_no']) && isset($_GET['class']) && isset($_GET['terminal'])){
        $terminal = trim($_GET["terminal"]);  
        $class = trim($_GET["class"]);
        $reg_no = (int)trim($_GET["reg_no"]);
    }
?>



<head>
    <link rel="stylesheet" href="assets/css/marksheet.css">
</head>

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
                <?php $data = $marksheetClassObject->getStudentInfo($reg_no,$class,$terminal) ?>
                <label>Student's Name: <?php echo $data['first_name'] ." " .$data['last_name'] ?></label>
                <label>Father's Name: <?php echo $data['father_name'] ?></label>
                <label>Reg No:<?php echo $data['reg_no'] ?></label>
                <label>Academic year:<?php echo "todo" ?></label>
            </div>
            <div class="marksheet-infoRight">
                <label>Class: <?php echo "todo" ?> </label>
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
                    <?php $marksData = $marksheetClassObject->getStudentMarks($reg_no,$class,$terminal)?>
                    
                    <?php $SN = 1 ?>
                    <?php foreach($marksData as $row){ ?>
                        <tr>
                            <td><?php echo $SN ?></td>
                            <td><?php echo $row['subject_name'] ?></td>
                            <td>100</td>
                            <td>40</td>
                            <td><?php echo $row['mark'] ?></td>
                        </tr>
                        <?php $SN += 1 ?>
                    <?php } ?>

                    <tr>
                        <td colspan="5">Total Mark Obtained :450 out of 500</td>
                    </tr>
                </table>
            </div>
        </div><hr>
        <div class="marksheet-per">
            <div class="marksheet-per-wrapper">
                <span>Percentage: 90%</span>
                <span>Grade: A</span>
            </div>
        </div><hr>
        <div class="marksheet-note"> 
            Disclaimer: Not for Offical Purpose. 
        </div>
    </div>
</div>
