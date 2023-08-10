<?php
    include_once("core/load.php");

    //getting the current year
    include_once "library/nepali-date.php";
    $date = new nepali_date;
    $date = $date->get_nepali_date(date('Y', time()), date('m', time()), date('d', time()));
    $thisYear = (int)$date['y'];

    $pfData = $marksheetClassObject->getPassFail($thisYear);//getting current year pass & fail
    $yearPFData = $marksheetClassObject->getYearPassFail();//getting all year pass & fail

    //for bargraph start

    $labels = "";
    $data = "";

    //for labels
    $keys = array_keys($yearPFData);

    foreach($keys as $key){
        $labels .= "'".(string)$key."',";
    }

    //for data

    foreach($yearPFData as $row){
        $data .= (string)($row['total']-$row['totalFail']).",";
    }

    //for bargraph end

    
    $actionData = $userClassObject->getAction();
?>

<?php
    //for the search
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $search = trim($_POST['sByData']);
        $students = $studentClassObject->searchStudent($search);
    }
?>
<div class="dashboard-wrapper">
    <div class="dashboard-title">
        <h3>Admin Dashboard</h3>
    </div>
    <div class="graphics">
        <div class="graphics-count">
            <div class="count-student">
                <i class="fa-solid fa-children"></i>
                <span>Total Students</span>
                <span><?php echo $studentClassObject->getTotalStudent() ?></span>
            </div>
            <div class="count-graduate">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Graduate Students</span>
                <span><?php echo $studentClassObject->getGraduate() ?></span>
            </div>
        </div>
        <div class="graphics-graph">
            <canvas id="graph-bar"></canvas>
        </div>
        <div class="graphics-pfratio">
            <div class="pf-toggle">
                <i class="fa-solid fa-1" id="first"></i>
                <i class="fa-solid fa-2" id="second"></i>
                <i class="fa-solid fa-3" id="third"></i>
                <i class="fa-solid fa-4" id="final"></i>
            </div>
            <canvas id="pfratio-canvas"></canvas>
        </div>
        <div class="graphics-notification">
            <h5>Recent Actions</h5>
            <div class="notification-body">
                <div class="notification-content">
                    <ol>
                        <?php if($actionData!=null){ ?>
                            <?php foreach($actionData as $row){ ?>
                                <li>
                                    <i class="fa-solid fa-caret-right"></i>
                                    <?php echo $row["msg"] ?>
                                    <span style="background-color: #3e6d9c; color:white;font-size:12px;padding:3px;border-radius:4px;" ><?php echo $row["time"] ?></span>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="search">
        <div class="search-title">
            <h3>Search Student</h3>
        </div>
        <div class="search-form">
            <form action="" method="post">
                <div class="sByData">
                    <input type="text" id="sByData" name="sByData" placeholder="Search">
                </div>
                <div class="submit">
                    <input type="submit" id="search" name="Search" value="Search">
                </div>
                <button class="view-button" type="button">
                    <a href="register.php">Add Admin</a>
                </button>
                <button class="send-mail-all" type="button">
                    <a href="sendMails.php?send-mails=yes">Send Mail to All Students</a>
                </button>
            </form>
        </div>
        <div class="search-result">
            <table>
                <tr>
                    <th>Sn</th>
                    <th>Reg_no</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>gender</th>
                    <!-- <th>DOB</th> -->
                    <th>Father Name</th>
                    <th>email</th>
                    <th>Action</th>
                </tr>


                <?php if(!($_SERVER['REQUEST_METHOD'] == "POST")){ ?>
                    <?php $search = ""; ?>
                    <?php //error_reporting(0)?>
                    <?php $students = $studentClassObject->searchStudent($search); ?>

                    <?php $SN = 1 ?>
                    <?php foreach($students as $row){ ?>
                        <tr>
                            <td><?php echo $SN ?></td>
                            <td><?php echo $row['reg_no'] ?></td>
                            <td><?php echo $row['first_name'] ?></td>
                            <td><?php echo $row['last_name'] ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <!-- <td><?php //echo $row['dob'] ?></td> -->
                            <td><?php echo $row['father_name'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td style="display:flex;" >
                                <button class="view-button" type="button">
                                    <a href="profile.php?user-id=<?php echo $row['reg_no'] ?>">View Profile</a>
                                </button>
                                <button class="view-button" style="margin-left:5px;"  type="button">
                                    <a href="sendMail.php?mail-reg-no=<?php echo $row['reg_no'] ?>">Send Mail</a>
                                </button>
                            </td>
                        </tr>
                        <?php $SN += 1 ?>
                    <?php } ?>
                <?php } ?>


                <?php if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>
                    <?php $search = trim($_POST['sByData']); ?>
                    <?php $students = $studentClassObject->searchStudent($search); ?>

                    <?php $SN = 1 ?>
                    <?php foreach($students as $row){ ?>
                        <tr>
                            <td><?php echo $SN ?></td>
                            <td><?php echo $row['reg_no'] ?></td>
                            <td><?php echo $row['first_name'] ?></td>
                            <td><?php echo $row['last_name'] ?></td>
                            <td><?php echo $row['gender'] ?></td>
                            <!-- <td><?php //echo $row['dob'] ?></td> -->
                            <td><?php echo $row['father_name'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td style="display:flex;" >
                                <button class="view-button" type="button">
                                    <a href="profile.php?user-id=<?php echo $row['reg_no'] ?>">View Profile</a>
                                </button>
                                <button class="view-button" style="margin-left:5px;"  type="button">
                                    <a href="sendMail.php?mail-reg-no=<?php echo $row['reg_no'] ?>">Send Mail</a>
                                </button>
                            </td>
                        </tr>
                        <?php $SN += 1 ?>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<script>
    //start donout

    function drawDoughnut(p,f){
        const data = {
            labels: [
                'Pass',
                'Fail',
                ],
                datasets: [{
                    label: 'Pass/Fail Ratio',
                    data: [p, f],
                    backgroundColor: [
                    'rgb(54, 162, 235)',    
                    'rgb(255, 99, 132)',
                    ],
                    hoverOffset: 4
                }]
        };
    
        const config = {
            type: 'doughnut',
            data: data,
        };
    
        var myChartPie = new Chart(
            document.getElementById('pfratio-canvas'),
            config
        );
        return myChartPie; //returning for destroing 
    }
    //onload defailt donout
    let pass = <?php echo$pfData["total"] - $pfData["first"] ?>;
    let fail = <?php echo $pfData["first"] ?>;
    var myChartPie = drawDoughnut(pass,fail);


    document.getElementById("first").addEventListener("click", ()=>{
        myChartPie.destroy();
        pass = <?php echo$pfData["total"] - $pfData["first"] ?>;
        fail = <?php echo $pfData["first"] ?>;
        myChartPie = drawDoughnut(pass,fail);
    } );
    
    document.getElementById("second").addEventListener("click", ()=>{
        myChartPie.destroy();
        pass = <?php echo$pfData["total"] - $pfData["second"] ?>;
        fail = <?php echo $pfData["second"] ?>;
        myChartPie = drawDoughnut(pass,fail);
    } );

    document.getElementById("third").addEventListener("click", ()=>{
        myChartPie.destroy();
        pass = <?php echo$pfData["total"] - $pfData["third"] ?>;
        fail = <?php echo $pfData["third"] ?>;
        myChartPie = drawDoughnut(pass,fail);
    } );

    document.getElementById("final").addEventListener("click", ()=>{
        myChartPie.destroy();
        pass = <?php echo$pfData["total"] - $pfData["final"] ?>;
        fail = <?php echo $pfData["final"] ?>;
        myChartPie = drawDoughnut(pass,fail);
    } );

    
    //end donout
    const dataBar = {
        labels: [ <?php echo $labels ?> ],
        datasets: [{
            label: 'Pass Student by Year',
            // data: [30, 50, 10,80,50],
            data: [<?php echo $data ?>],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(54, 162, 25)',
            'rgb(162, 12, 235)',
            'rgb(54, 163, 235)',
            'rgb(54, 12, 162)',
            ],
            hoverOffset: 4
        }]
    };

    const configBar = {
        type: 'line',
        data: dataBar,
    };

    var myChartbar = new Chart(
        document.getElementById('graph-bar'),
        configBar
    );

</script>