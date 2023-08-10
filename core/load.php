<!-- init.php -->
<!-- This initialize/load the classes -->

<?php
    include 'classes/users.php';
    include 'classes/student.php';
    include 'classes/result.php';
    include 'classes/marksheet.php';

    $userClassObject = new Users($conn);
    $studentClassObject = new Student($conn);
    $resultClassObject = new Result($conn);
    $marksheetClassObject = new Marksheet($conn);
?>