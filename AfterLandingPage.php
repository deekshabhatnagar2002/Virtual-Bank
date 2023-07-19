<?php 
    session_start();

    if(!$_SESSION['Name']){
        header('location: login.php');
    }
?>

<?php
include "dbcon.php";

if(isset($_POST['query'])){
    $issue=$_POST['query'];
    $pno=$_POST['pno'];
    $dt=$_POST['dt'];
    $time=$_POST['time'];

    $issueQuery="INSERT INTO `banking`.`userquery` (`issue`, `PNo`, `date`, `time`) VALUES ('{$issue}', '{$pno}', '{$dt}', '{$time}')";
    $execIssue=mysqli_query($con, $issueQuery);
    if($execIssue == true){
        echo "<script>alert('Issue reported SUCCESSFULLY!');</script>";
    }
    else{
        echo "<script>alert('Issue could not be reported!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AfterLandingPage</title>
    <link rel="stylesheet" href="AfterLandingPageMediaQueries.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Goldman&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab:wght@300&display=swap" rel="stylesheet">
    
</head>
<body>
    <section id="heading">
        <div>
            <h1>Your Banking Buddy</h1>
        </div>
    </section>
    <nav>
        <div id="logo"> <img src="BankLogo.png" alt=""></div>
        <div id="navigation">
            <ul>
                <li class="navbtn"><a href="#accountSummary">My Accounts and Profile</a></li>
                <li class="navbtn"><a href="transfer.php" target="_blank">Online Transfer</a></li>
                <li class="navbtn"><a href="MoneyDeposit.php" target="_blank">Deposit</a></li>
                <li class="navbtn"><a href="#ContactUs">Request/ Contact Us</a></li>
                <li class="navbtn"><a href="./ATMinterface.php" target="_blank">ATM Interface</a></li>
                <li class="navbtn"><a href="./debit.php" target="_blank">Debit Card Payment</a></li>
                <li class="navbtn"><a href="./loan.php" target="_blank">Loans Information</a></li>
                <li class="navbtn"><a href="./Insurance.php" target="_blank">Insurance Information</a></li>
            </ul>
        </div>
        <div id="logOut"> 
            <div id="logoutButton" style="margin: 2px;">
                <img src="Logout.png" alt="" onmouseenter="changeColor()" onmouseout="originalColor()"> 
                <p style="color: red; margin: 1px;" id="LOGOUT"><strong>Logout</strong></p>
            </div>
        </div>
    </nav>
    <div id="container"> 
        <div id="content">
            <section id="loginTime">
                <span>Login Date and Time: </span>
                <?php echo"<span id='DateAndTime'>{$_SESSION['loginTime']}</span>";?>
            </section>
            <section id="welcome">
                <span>Welcome&nbsp;</span>
                <?php echo"<span id='userName'>{$_SESSION['Name']}<span>"?>
                <?php echo"<span id='userEmail'>, {$_SESSION['email']}<span>"?>
            </section>
            <section id="accountSummary">
                <div class="sectionHeading">
                    <h1>Accounts and Profile/ Account Summary</h1>
                </div>
                <!-- <div id="accHeading">
                    <h1>Accounts and Profile/ Account Summary</h1>
                </div> -->
                <div style="width: 600px; margin: auto;">
                    <table>
                        <tr>
                            <th>Account Number/ Name</th>
                            <th>Branch</th>
                            <th>Available Balance</th>
                            <th>Transaction</th>
                        </tr>
                        <tr>
                            <td><?php echo"<span id='AccountNumber'>{$_SESSION['accNo']}<span>" ?></td>
                            <td><?php echo"<span id='branch'>{$_SESSION['branch']}<span>" ?></td>
                            <td><span id="checkBal" onclick="viewBal()">Click here for balance</span></td>
                            <td><span id="prevTran"><a href="Passbook.php">View your transactions</a></span></td>
                        </tr>
                    </table>
                </div>
            </section>
            <section id="offers">
                <span id="bankOffers"><img src="./BankOffers/BankOffer1.png" alt=""></span>
            </section>
            <section id="debitCard">
                <div class="sectionHeading">
                    <h1>Debit Card</h1>
                </div>
                <p id="dcDetails">
                    A debit card is a payment card that makes payments by deducting money directly from a consumer's checking account, rather than on loan from a bank. To view your debit card click on the card: <a href="DebitCardPage.php" target="_blank"><img src="Debit_Card.png" alt="" id="dcImage"></a>
                </p>
            </section>
            <section id="ContactUs">
                <h1>Contact Us</h1>
                <form action="AfterLandingPage.php" method="post">
                    <div id="box">
                        <p>Issue: </p>
                        <p></p><textarea name="query" id="" cols="50" rows="7" id="issue"></textarea></p>
                        <p>Phone Number: <input type="tel" name="pno" id=""></p>
                        <p>Call timing preference:</p> 
                        <p>Date: <input type="date" name="dt" id="contactDate"></p>
                        <p id="callTime">Time: <textarea name="time" id="" cols="30" rows="1"></textarea></p>
                        <p>
                            <button type="submit">Submit</button>
                        </p>
                    </div>
                </form>
            </section>
        </div>
        
    </div>
    <footer id="suggestion" ><marquee behavior="" direction="">This page can be best viewed on a screen of (1920*1080) px</marquee></footer>
</body>
    <?php
        include "dbcon.php";
        $senderquery="SELECT * from `banking`.`users` where `AccountNo`='{$_SESSION['accNo']}';";
        $query1=mysqli_query($con, $senderquery);
        
        $sender_data=mysqli_fetch_assoc($query1);
        $senderBal=$sender_data['Balance'];

        echo "<script>document.getElementById('checkBal').innerText='₹ {$senderBal}';</script>";
    ?>
    <?php echo '
<script>

    function changeColor(){
        document.getElementById("logoutButton").innerHTML=`<a href="logout.php"><img src="Logout1.png" alt="" onmouseout="originalColor()" id="logout"> <p style="color:white; margin: 1px;">Logout</p></a>`;
    }
    function originalColor(){
        document.getElementById("logoutButton").innerHTML=`<img src="Logout.png" alt="" onmouseover="changeColor()" id="logout"> <p style="color:red; margin: 1px;">Logout</p>`;
    }


    let x=1;
    function offersSlideShow(){
        document.getElementById("bankOffers").innerHTML=`<img src="./BankOffers/BankOffer${x}.png" alt="">`;
        x++;
        if(x>4){
            x=1;
        }
    }
    setInterval(offersSlideShow,1500);

</script>
';
?>
</html>