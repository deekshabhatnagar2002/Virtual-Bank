<?php
    session_start();

    if(!$_SESSION['Name']){
        header('location: login.php');
    }
?>

<?php
$insert=false;

if(isset($_POST['amt'])){
    include "dbcon.php";
    if(!$con)
    {
        die("Connection to the server failed due to ".mysqli_connect_error());
    }

    $sendAmt=$_POST['amt'];
    $recepientName=$_POST['recName'];
    $recepientBranch=$_POST['recBranch'];
    $accountNo=$_POST['acNo'];
    $date=date("Y-m-d");
    $pass=$_POST['pswd'];

    $userquery="SELECT * from `banking`.`users` where `AccountNo`='$accountNo';";

    $query=mysqli_query($con, $userquery);

    $usercount= mysqli_num_rows($query);

    if($usercount==0){
        echo "
        <script>
        alert('Mentioned account number does not exit.');
        </script>
        ";
    }
    else{
        $senderquery="SELECT * from `banking`.`users` where `AccountNo`='{$_SESSION['accNo']}';";
        $query1=mysqli_query($con, $senderquery);
        
        $sender_data=mysqli_fetch_assoc($query1);
        if($pass===$sender_data['Password']){
            $recepient_data=mysqli_fetch_assoc($query);

            $senderBal=$sender_data['Balance'];
            $recepientBal=$recepient_data['Balance'];

            if((int)$sendAmt<=(int)$senderBal){
                $senderUserID=$sender_data['UserID'];
                $recepientUserID=$recepient_data['UserID'];
                $senderBal=(int)$senderBal-(int)$sendAmt;
                $recepientBal=(int)$recepientBal+(int)$sendAmt;

                $record1="INSERT INTO `banking`.`{$senderUserID}transaction` (`Transfer_to`, `Transfer_from`, `Mode`, `Date`, `Amount`, `Bal`) VALUES ('{$accountNo}', 'SELF', 'Online Transfer', '{$date}', '{$sendAmt}', '{$senderBal}');";

                $record2="INSERT INTO `banking`.`{$recepientUserID}transaction` (`Transfer_to`, `Transfer_from`, `Mode`, `Date`, `Amount`, `Bal`) VALUES ('SELF', '{$_SESSION['accNo']}', 'Online Transfer', '{$date}', '{$sendAmt}', '{$recepientBal}');";

                $update1="UPDATE `banking`.`users` SET `Balance` = '{$senderBal}' WHERE `banking`.`users`.`UserID` = '{$senderUserID}';";

                $update2="UPDATE `banking`.`users` SET `Balance` = '{$recepientBal}' WHERE `banking`.`users`.`UserID` = '{$recepientUserID}';";

                $status1=$con->query($record1);
                $status2=$con->query($record2);
                $status3=$con->query($update1);
                $status4=$con->query($update2);

                if($status1 == true && $status2 == true && $status3 == true && $status4 == true){
                    echo "<script>alert('Transaction performed SUCCESSFULLY!!');</script>";
                }
                else{
                    echo "<script>alert('The transaction could not be completed.');</script>";
                }
            }
            else{
                echo "<script>alert('Incorrect password!!');</script>";
            }

        }
        else{
            echo "<script>alert('Insufficient balance.')</>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Online Transfer</title>
      <link rel="stylesheet" href="transfer.css">
   </head>
   <body>
      <nav>
         <label class="logo">Online Transfer</label>
         <ul>
            <li>
               <a href="AfterLandingPage.php">Home</a>
            </li>
            <li>
               <a href="loan.php">Loans</a>
                        <li><a href="Insurance.php">Insurances</a></li>
                        <li><a href="Passbook.php">Transaction History</a></li>
                        <li><a href="ATMinterface.php">ATM</a></li>
        </ul>
    </li>
      </nav>
   <div class="container">

    <form  id="form" action="transfer.php" method="post">

        <div class="row">

            <div class="col">

                <h3 class="title">Sender's Details</h3>

                <div class="inputBox">
                    <span>Sender's Name :</span>
                    <input type="text" id="name" disabled>
                </div>
                <div class="inputBox">
                    <span>Branch Name :</span>
                    <input type="text" id="bname" disabled>
                </div>
                <div class="inputBox">
                    <span>Account Number :</span>
                    <input type="text" id="ac" disabled>
                </div>
                <div class="inputBox">
                    <span>Amount :</span>
                    <input type="text" placeholder="Rs" id="amount" name='amt' required>
                </div>
            </div>

            <div class="col">

                <h3 class="title">Reciever's Details</h3>
                <div class="inputBox" required>
                    <span>Reciever's Name :</span>
                    <input type="text" id="name2" name="recName">
                </div>
                <div class="inputBox">
                    <span>Branch Name :</span>
                    <input type="text" id="bname2" name="recBranch" required>
                </div>
                <div class="inputBox">
                    <span>Account Number :</span>
                    <input type="text" id="AC2" name="acNo" required>
                </div>
                <div class="inputBox">
                    <span>Password :</span>
                    <input type="password" id="" name="pswd" required>
                </div>
            </div>
    
        </div>

        <input id="submit" type="submit" value="proceed to checkout" class="submit-btn">

    </form>

</div>
    <?php
        echo "<script>
        document.getElementById('name').value='{$_SESSION['Name']}';
        </script>";
        echo "<script>
        document.getElementById('bname').value='{$_SESSION['branch']}';
        </script>";
        echo "<script>
        document.getElementById('ac').value='{$_SESSION['accNo']}';
        </script>";
    ?>

   </body>
</html>