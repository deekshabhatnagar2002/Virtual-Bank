<?php
    session_start();

    if(!$_SESSION['Name']){
        header('location: login.php');
    }
?>

<?php
$insert=false;

if(isset($_POST['rsWords'])){
    include "dbcon.php";
    if(!$con)
    {
        die("Connection to the server failed due to ".mysqli_connect_error());
    }

    $deposit=$_POST['depositAmt'];
    $recipient=$_POST['accNo'];
    $date=$_POST['dt'];

    $userquery="SELECT * from `banking`.`users` where `AccountNo`='$recipient';";

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
        $recepient_data=mysqli_fetch_assoc($query);
        $recepientBal=$recepient_data['Balance'];
        $recepientUserID=$recepient_data['UserID'];
        $recepientBal=(int)$recepientBal+(int)$deposit;

        $record2="INSERT INTO `banking`.`{$recepientUserID}transaction` (`Transfer_to`, `Transfer_from`, `Mode`, `Date`, `Amount`, `Bal`) VALUES ('SELF', 'SELF', 'Deposit', '{$date}', '{$deposit}', '{$recepientBal}');";

        $update2="UPDATE `banking`.`users` SET `Balance` = '{$recepientBal}' WHERE `banking`.`users`.`UserID` = '{$recepientUserID}';";

        

        if($con->query($record2) == true && $con->query($update2) == true){
            echo "<script>alert('Money deposited SUCCESSFULLY!!');</script>";
        }
        else{
            echo "<script>alert('Money could not be deposited.')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Deposit</title>
    <link rel="stylesheet" href="MoneyDeposit.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <h1 class="main-heading">Money Deposit Form</h1>
    <div class="form">
        <form action="MoneyDeposit.php" method="POST">
            <div class="table-start">
                <div class="first-block">
                    <div class="paycash">
                        <div class="pay-in">
                            <h6>PAY-IN SLIP</h6>
                        </div>
                        <div class="cash-transfer">
                            <h6>CASH/TRANSFER</h6>
                        </div>
                    </div>
                    <div class="logobname">
                        <div class="logo"></div>
                        <div class="bname">
                            <h2 class="sub-heading">Your Bank Buddy</h2>
                        </div>
                    </div>
                    <div class="branch">
                        <input type="text" name="" id="Branch">
                        <label for="Branch">BRANCH</label>
                    </div>
                </div>
                <div class="second-block">
                    <div class="account-type">
                        <label for="" class="atype">TYPE OF ACCOUNT</label>
                        <label for="sb">SB</label>
                        <input type="checkbox" name="" id="sb">
                        <label for="ca">/CA</label>
                        <input type="checkbox" name="" id="cs">
                        <label for="rd">/RD</label>
                        <input type="checkbox" name="" id="rd">
                        <label for="cc">/CC</label>
                        <input type="checkbox" name="" id="cc">
                        <label for="tl">/TL</label>
                        <input type="checkbox" name="" id="tl">
                    </div>
                </div>
                <div class="third-block">
                    <div class="accdate">
                        <div class="accno">
                            <label for="Account">Account No.</label>
                            <input type="number" name="accNo" id="Account">
                        </div>
                        <div class="date">
                            <label for="Date" class="Date">Date:</label>
                            <input type="date" name="dt" id="Date">
                        </div>
                    </div>
                </div>
                <div class="fourth-block">
                    <div class="credit">
                        <label for="credit-account">For the credit of Bank Account of</label>
                        <input type="text" name="" id="credit-account">
                    </div>
                </div>
                <div class="fifth-block">
                        <table style="width: 90%;" id="table">
                            <tr>
                                <th style="width: 20%;">Notes</th>
                                <th style="width: 20%;">No.</th>
                                <th style="width: 25%;" class="rs">Rupees</th>
                                <th style="width: 25%;" class="p">Paise</th>
                            </tr>
                            <tr>
                                <td class="note">2000 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td> 
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">500 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">200 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">100 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">50 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">20 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">10 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td class="note">5 X</td>
                                <td><input type="number" name="" id="" class="numNotes" onchange="valueOfRs()"></td>
                                <td class="rupee"></td>
                                <td class="paises"></td>
                            </tr>
                            <tr>
                                <td style="border: none;" class="no-border"></td>
                                <td>Total</td>
                                <td id="" name=""><input type="number" name="depositAmt" id="total1" class="numNotes"></td>
                                <td id="total2">0</td>
                            </tr>
                        </table>

                </div>
                <div class="sixth-block">
                    <div class="rupees">
                        <label for="rupees-words">Rupees (in words)</label>
                        <input type="text" name="rsWords" id="rupees-words">
                    </div>
                </div>
                <div class="dp">
                    <!-- <a href="#deposit">Deposit</a> -->
                    <button style= "margin: 20px; padding: 15px; border-radius: 30px; width: 170px;font-size: 25px; /* font-weight:25px  */background-color: red; cursor: pointer;" type="submit">Deposit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        for(let i=0;i<8;i++){
            document.getElementsByClassName('numNotes')[i].defaultValue=0;
            document.getElementsByClassName('paises')[i].innerHTML=0;
        }

        function valueOfRs(){
            let noteArr=[2000,500,200,100,50,20,10,5];
            let sum=0;
            for(let i=0;i<8;i++){
                document.getElementsByClassName('rupee')[i].innerHTML= noteArr[i]*document.getElementsByClassName('numNotes')[i].value;
                sum=sum+noteArr[i]*document.getElementsByClassName('numNotes')[i].value;
            }
            document.getElementById('total1').value=sum;
        }
        valueOfRs();
    </script>
</body>
</html>