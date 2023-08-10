<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="assets/css/view-result.css">
    <link rel="stylesheet" href="templates/assets/css/marksheet.css">
</head>
<body>

    <!-- the nav of view result -->
        <div class="nav">
            <div class="logo">
                <h4>Smart Result</h4>
            </div>
            <div class="user_detail">
                <div class="email">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="logout"><a href="login.php">Admin Login</a></div>
            </div>
        </div>
    <!-- the search form -->

    <div class="search-form">
        <div class="search-form-wrapper">
            <div class="form-title">
                <h4> <u> Fill & View Result</u></h4>
            </div>
            <form action="view-result.php" method='post'>
                <div class="wrapper-terminal">
                    <label for="terminal">Enter Terminal</label>
                    <select name="terminal" id="terminal" required>
                        <option></option>
                        <option value="first">First Terminal</option>
                        <option value="second">Second Terminal</option>
                        <option value="third">Third Terminal</option>
                        <option value="final">Final Terminal</option>
                        <option value="preboard">Pre Board</option>
                        <option value="ut">UT</option>
                    </select>
                    <span>Eg : Final Terminal</span>
                </div>

                <div class="wrapper-class">
                    <label for="class">Enter Standard</label>
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
                    <span>Eg : Five</span>
                    
                </div>

                <div class="wrapper-reg_no">
                    <label for="terminal">Enter Reg No:-</label>
                    <input name="reg_no" id="reg_no" type="number" required>
                    <span>Eg : 20970504 YearClassRollNO</span>
                </div>

                <div class="wrapper-submit">
                    <input type="submit" class="result-submit" name="result-submit">
                </div>
            </form>
        </div>
    </div>

    <!-- including marksheet and same is used for printing -->
    <?php include 'templates/view-result-marksheet.php' ?>

    <?php 
        if(isset($_SESSION["error"])){ 
            $errorData = $_SESSION['error'];
            unset($_SESSION['error']);
            echo "<div class='error-txt'> $errorData </div>";
        }
    ?>



<script>
    const printBtn = document.getElementById("print-button");
    printBtn.addEventListener("click",()=>{
        <?php $url = 'templates/print-marksheet.php?reg_no='.$reg_no.'&class='.$class.'&terminal='.$terminal; ?>
        var nw = window.open("<?php echo $url ?>","_blank","width=900,height=600")
        setTimeout(function(){
			nw.print()
			setTimeout(function(){
				nw.close()
			},100)
		},100)
    });

</script>    
</body>
</html>