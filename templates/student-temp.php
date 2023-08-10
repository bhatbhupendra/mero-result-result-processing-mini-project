<?php
    require_once "core/load.php";
    $msg=".";
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $fileLoc= $_FILES['csvfile']['tmp_name'];
        $class = trim($_POST["class"]);
        $studentClassObject->uploadCSV($fileLoc,"student",$class);
        $msg = "File Uploaded!!";
    }

?>


<div class="student-wrapper">
    <div class="form-wrapper">
        <h4>Upload Student Detail</h4>
        <form action="student.php" method="post" id="student-upload-form" enctype="multipart/form-data" >
            <label for="class">Choose Class</label>
            <select name="class" id="class" required>
                <option></option>
                <option value="00">Nursary</option>
                <option value="01">One</option>
                <option value="02">Two</option>
                <option value="03">Three</option>
                <option value="04">Four</option>
                <option value="05">Five</option>
                <option value="06">Six</option>
                <option value="07">Seven</option>
                <option value="08">Eight</option>
                <option value="09">Nine</option>
                <option value="10">Ten</option>
            </select>
            
            <div id="clickable-area" class="clickable-area">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <input type="file" name="csvfile" required="required" id="student-upload-form-input" hidden>
                <input type="submit" id="student-upload-submit" value="upload" hidden>
            </div>
        </form>
        <span class="student-upload-msg"><?php echo $msg; ?></span>
    </div>
</div>