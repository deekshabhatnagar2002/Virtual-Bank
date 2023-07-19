<?php 
    session_start();
    include "dbcon.php";
    if(!$_SESSION['Name']){
        header('location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DebitCard</title>

    <style>
        #container{
            display: flex;
            justify-content: space-around;
            
        }
        .card{
            border: 3px solid black;
            height: 350px;
            width: 600px;
            border-radius: 20px;
            padding: 10px;
            /* background-color: rgb(95, 95, 255); */
            background: linear-gradient(to top right, white, rgb(95, 95, 255), white);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        #magneticStrip{
            height: 50px;
            width: 600px;
            background-color: black;
            margin-bottom: 50px;
        }
        #cvvStrip{
            height: 20px;
            width: 300px;
            border: 2px solid black;
            display: inline-block;
            background-color: white;
        }
        #dcNo, #date, #name{
            color: white;
        }
        .cardContent{
            font-size: 2rem;
            margin: 5px 1px;
        }
        img{
            height: 50px;
        }
        #cvv{
            background-color: white;
            padding: 2px;
        }
    </style>

</head>
<body>
    <div id="container">
        <div class="card" id="front">
            <div id="bname" class="cardContent">
                <img src="bankLogo.png" alt=""><strong>Virtual Bank: Your Banking Buddy</strong>
            </div>
            <div>
                <img src="dcChip.png" alt="">
            </div>
            <div>
                <span id="dcNo" class="cardContent">9854 7515 6254 3256</span>
            </div>
            <div class="cardContent">
                Valid thru <span id="date">15/03/2022</span>
            </div>
            <div class="cardContent">
                <strong><span id="name">Anthony Edward Stark</span></strong>
            </div>
            <div class="cardContent">
                <img src="masterCard.png" alt="" style="margin-left: 450px;">
            </div>
        </div>
        <div class="card" id="back">
            <div id="magneticStrip">

            </div>
            <div style="margin-bottom: 90px;">
                <div id="cvvStrip" class="cardContent"></div>
                <span id="cvv" class="cardContent">354</span>
            </div>
            <div>
                <div style="color: white;">
                    A debit card is a payment card that makes payments by deducting money directly from a consumer's checking account, rather than on loan from a bank.
                </div>
            </div>
        </div>
    </div>
</body>
<?php
$debitQuery="SELECT * from `banking`.`debitcard` where `AccountNo`={$_SESSION['accNo']};";
$debitRows=mysqli_query($con,$debitQuery);
$userDebitdata=mysqli_fetch_assoc($debitRows);
$cvv=$userDebitdata['CVV'];
$dcNo=$userDebitdata['DebitCardNo'];
$validity=$userDebitdata['Validity'];
echo "
<script>
    let dcNum='{$dcNo}';
    let dcDate='{$validity}';
    let dcName='{$_SESSION['Name']}';
    let dcCVV='{$cvv}';
    document.getElementById('dcNo').innerHTML=dcNum;
    document.getElementById('date').innerHTML=dcDate;
    document.getElementById('name').innerHTML=dcName;
    document.getElementById('cvv').innerHTML=dcCVV;


</script>
";
?>
</html>