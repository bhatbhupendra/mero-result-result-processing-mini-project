<?php
    require_once "core/load.php";
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $fileLoc= $_FILES['csvfile']['tmp_name'];
        $class = trim($_POST["class"]);
        $terminal = trim($_POST["terminal"]);
        $resultClassObject->uploadCSV($fileLoc,"result",$class,$terminal);
    }

?>


<div class="result-wrapper">
    <div class="form-wrapper">
        <h4>Upload result Detail</h4>
        <form action="upload-result.php" method="post" id="result-upload-form" enctype="multipart/form-data" >
            <label for="class">Choose Standard</label>
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
            </select><br>

            <label for="terminal">Choose Terminal&nbsp</label>
            <select name="terminal" id="terminal" required>
                <option></option>
                <option value="first">First</option>
                <option value="second">Second</option>
                <option value="third">Third</option>
                <option value="final">Final</option>
            </select>
            
            <div id="clickable-area" class="clickable-area">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <input type="file" name="csvfile" required="required" id="result-upload-form-input" hidden>
                <input type="submit" id="result-upload-submit" value="upload" hidden>
            </div>
        </form>
    </div>
</div>