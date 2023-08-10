
<?php
    require_once "config.php";
    include "core/load.php";

    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true){              
        header("location: login.php");
    }


    if(isset($_GET['user-id'])){
        $reg_no = (int)$_GET['user-id'];
        $profileData = $studentClassObject->getProfile($reg_no);
    }else{
        $_SESSION['error']="The Student Profile doesn't Exist!!";
        header("location: dashboard.php");
    }


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    
</head>
<body>
    <?php include_once "templates/nav-temp.php" ?>
    <section class="student-profile">
        <div class="student-profile-wrapper">
            <div class="profile-col-1">
                <div class="profile-info">
                    <img src="assets/images/user-icon.png" alt="user">
                    <h2><?php echo $profileData['first_name'].$profileData['last_name']?></h2>
                    <h4><?php echo $profileData['reg_no']?></h4>
                </div>
            </div>
            <div class="profile-col-2">
                <div class="profile-detail">
                    <table>
                        <tr>
                            <th>Full Name</th>
                            <td><?php echo $profileData['first_name'].$profileData['last_name']?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?php echo $profileData['gender']?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php //echo $profileData['address']?>Dhangadhi-2, Kailali</td>
                        </tr>
                        <tr>
                            <th>email</th>
                            <td><?php echo $profileData['email']?></td>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td><?php echo $profileData['father_name']?>No name</td>
                        </tr>
                        <tr>
                            <th>Contact</th>
                            <td><?php //echo $profileData['contact']?>981502427</td>
                        </tr>
                    </table>
                </div>
                <div class="profile-result">
                    <?php $terminals = $marksheetClassObject->countTerminal() ?>
                    <?php foreach($terminals as $terminal){ //opening ?>
                        <?php
                            //for rank
                            $rank = $marksheetClassObject->calculateRank($reg_no,$terminal);
                            //for class
                            $yearString = preg_split('//', (string)$reg_no , -1, PREG_SPLIT_NO_EMPTY);
                            $class =  (int)$yearString[4].$yearString[5];
                            //for calculate
                            $marksData = $marksheetClassObject->getStudentMarks($reg_no,$class,$terminal);
                            $calclation = $marksheetClassObject->calculate($marksData);
                        ?>
                        <div class="result-card">
                            <div class="info">
                                <div class="term"><?php echo $terminal ?></div>
                                <div class="result">Result</div>
                            </div>
                            <div class="stats">
                                <div class="box"><?php echo "#".$rank ?></div>
                                <div class="box"><?php echo $calclation['gpa'] ?></div>
                                <div class="box"><?php echo $calclation['grade'] ?></div>
                            </div>
                        </div>
                    <?php } //closing ?>
                </div>
                <div class="backToDashboard">
                    <button class="dashboard-button" type="button">
                        <a href="dashboard.php">Back To Dashboard</a>
                    </button>
                </div>
            </div>
        </div>
    </section>
</body>
</html>