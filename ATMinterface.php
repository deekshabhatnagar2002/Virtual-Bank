<?php
    session_start();

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
    <title>ATM interface</title>

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="ATMinterfaceCSS.css">
</head>

<body>
    <div id="atmMachine">
        <!-- ENTER DEBIT CARD DISPLAY  -->
        <div id="atmEnterDebitCard">
            <div>
                <span id="debitCardMsg">Insert your debit card.</span>
            </div>
        </div>


        <!-- ENTER YOUR ATM PIN -->
        <div id="atmPinEnterDisplay">
            <span>ENTER YOUR ATM PIN</span>
            <textarea name="" id="atmPin" cols="20" rows="1"></textarea>
        </div>


        <!-- OPTIONS AFTER ENTERING THE THE ATM PIN -->
        <div id="atmDisplay">
            <div id="menu">
                <div class="atmMenu" onclick="checkBalanceWindow()">Check Balance</div>
                <div class="atmMenu" onclick="withdrawWindow()">Withdraw</div>
                <div class="atmMenu" onclick="changePINWindow()">Change PIN</div>
            </div>
        </div>


        <!-- MONEY WITHDRAW INTERFACE  -->
        <div id="atmWithdrawDisplay">
            <span>Withdraw limit 30000</span>
            <textarea name="" id="withdrawAmount" cols="20" rows="1"></textarea>
        </div>


        <!-- CHECK BALANCE INTERFACE  -->
        <div id="atmCheckBalanceDisplay">
            <span>Available balance: </span>
            <span id="availableBal" style="color: green;"></span>
        </div>


        <!-- CHANGE PIN INTERFACE  -->
        <div id="atmChangePINDisplay">
            <textarea name="prevPIN" id="previousPIN" cols="20" rows="1" placeholder="Previous PIN"></textarea>
            <textarea name="nPIN" id="newPIN" cols="20" rows="1" placeholder="New PIN"></textarea>
            <textarea name="cnfPIN" id="confirmPIN" cols="20" rows="1" placeholder="Confirm PIN"></textarea>
        </div>


        <!-- CANCEL ANIMATION INTERFACE  -->
        <div id="atmCancelDisplay">
            <img src="Cancel.png" alt="">
            <span style="margin: 1rem;">Transaction CANCELLED</span>
        </div>


        <!-- DEBIT CARD INDICATOR -->
        <div id="debitCardStatus">
            <span>Debit Card Status:</span>

            <!-- CIRCULAR BUTTON  -->
            <span id="indicatorButton"></span>

            <!-- CARD INSERTION PLACE AND ARROW INDICATOR  -->
            <div id="cardInstruction">
                <span id="cardIndicatorButton" onclick="insertCard()">
                </span>

                <span id="upwardArrow">
                    <img src="upwardArrowRed.png" alt="">
                </span>
            </div>
        </div>


        <!-- KEYPAD INTERFACE -->
        <div id="atmButtons">
            <div id="buttonLine">
                <div class="button" onclick="readNumber1()" id="1">1</div>
                <div class="button" onclick="readNumber2()" id="2">2</div>
                <div class="button" onclick="readNumber3()" id="3">3</div>
                <div class="button" id="cancel" onclick="cancelWindow()">Cancel</div>
            </div>
            <div id="buttonLine">
                <div class="button" onclick="readNumber4()" id="4">4</div>
                <div class="button" onclick="readNumber5()" id="5">5</div>
                <div class="button" onclick="readNumber6()" id="6">6</div>
                <div class="button" onclick="clearNumber()" id="clear">Clear</div>
            </div>
            <div id="buttonLine">
                <div class="button" onclick="readNumber7()" id="7">7</div>
                <div class="button" onclick="readNumber8()" id="8">8</div>
                <div class="button" onclick="readNumber9()" id="9">9</div>
                <div class="button" onclick="enterPressed()" id="enter">Enter</div>
            </div>
            <div id="buttonLine">
                <div class="button"></div>
                <div class="button" onclick="readNumber0()" id="0">0</div>
                <div class="button" id="backSpace" onclick="backSpaceNumber()"><img src="BackSpace.png" alt=""
                        style="height: 2rem;"></div>
                <div class="button" onclick="previousWindow()">Prev</div>
            </div>
        </div>
    </div>
</body>

<?php
    include "dbcon.php";

    $query="SELECT * from `banking`.`users` where `AccountNo`={$_SESSION['accNo']};";
    $debitQuery="SELECT * from `banking`.`debitcard` where `AccountNo`={$_SESSION['accNo']};";
    $rows=mysqli_query($con,$query);
    $debitRows=mysqli_query($con,$debitQuery);

    $user_data=mysqli_fetch_assoc($rows);
    $userDebitdata=mysqli_fetch_assoc($debitRows);

    $atmPIN=$userDebitdata['PIN'];
    $bal=$user_data['Balance'];
    echo "
<script>
    let workingWindow = '';
    let debitCardNo={$userDebitdata['DebitCardNo']};
    let atmPIN={$atmPIN};
    let balance={$user_data['Balance']};
    let allowAccess = false;
    let changePin = '';
    let amount = document.getElementById('withdrawAmount').textContent;
    let pin = document.getElementById('atmPin').textContent;

    function initialCondition() {
        enterDebitCardWindow();
        document.getElementById('cardIndicatorButton').style.borderColor = 'red';
        document.getElementById('cardIndicatorButton').style.background = 'linear-gradient(to top right, white, rgb(255, 73, 73), white)';

        document.getElementById('indicatorButton').style.borderColor = 'red';
        document.getElementById('indicatorButton').style.background = 'linear-gradient(to top right, white, rgb(255, 73, 73), white)';
        document.getElementById('atmPin').innerText = '';
        document.getElementById('upwardArrow').style.display = 'block';
        document.getElementById('previousPIN').innerText = '';
        document.getElementById('newPIN').innerText = '';
        document.getElementById('confirmPIN').innerText = '';
        pin='';
    }
    function enterDebitCardWindow() {
        document.getElementById('atmEnterDebitCard').style.display = 'flex';
        document.getElementById('atmPinEnterDisplay').style.display = 'none';
        document.getElementById('atmDisplay').style.display = 'none';
        document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
        document.getElementById('atmChangePINDisplay').style.display = 'none';
        document.getElementById('atmWithdrawDisplay').style.display = 'none';
        document.getElementById('atmCancelDisplay').style.display = 'none';
        workingWindow = '';
    }
    function enterAtmPinWindow() {
        document.getElementById('atmEnterDebitCard').style.display = 'none';
        document.getElementById('atmPinEnterDisplay').style.display = 'flex';
        document.getElementById('atmDisplay').style.display = 'none';
        document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
        document.getElementById('atmChangePINDisplay').style.display = 'none';
        document.getElementById('atmWithdrawDisplay').style.display = 'none';
        document.getElementById('atmCancelDisplay').style.display = 'none';
        workingWindow = 'atmEnterPinDisplay';
        // previousWindow();
    }
    function withdrawWindow() {
        document.getElementById('atmEnterDebitCard').style.display = 'none';
        document.getElementById('atmPinEnterDisplay').style.display = 'none';
        document.getElementById('atmDisplay').style.display = 'none';
        document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
        document.getElementById('atmChangePINDisplay').style.display = 'none';
        document.getElementById('atmWithdrawDisplay').style.display = 'flex';
        document.getElementById('atmCancelDisplay').style.display = 'none';
        workingWindow = 'atmWithdrawDisplay';
    }
    function changePINWindow() {
        document.getElementById('atmEnterDebitCard').style.display = 'none';
        document.getElementById('atmPinEnterDisplay').style.display = 'none';
        document.getElementById('atmDisplay').style.display = 'none';
        document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
        document.getElementById('atmChangePINDisplay').style.display = 'flex';
        document.getElementById('atmWithdrawDisplay').style.display = 'none';
        document.getElementById('atmCancelDisplay').style.display = 'none';
        workingWindow = 'atmChangePINDisplay';
    }
    function checkBalanceWindow() {
        document.getElementById('atmEnterDebitCard').style.display = 'none';
        document.getElementById('atmPinEnterDisplay').style.display = 'none';
        document.getElementById('atmDisplay').style.display = 'none';
        document.getElementById('atmCheckBalanceDisplay').style.display = 'flex';
        document.getElementById('atmChangePINDisplay').style.display = 'none';
        document.getElementById('atmWithdrawDisplay').style.display = 'none';
        document.getElementById('atmCancelDisplay').style.display = 'none';
        workingWindow = 'atmCheckBalanceDisplay';
        document.getElementById('availableBal').innerText = balance;
        setTimeout(initialCondition, 5000);
    }
    function previousWindow() {
        if (workingWindow == 'atmChangePINDisplay' || workingWindow == 'atmWithdrawDisplay' || allowAccess == true) {
            document.getElementById('atmEnterDebitCard').style.display = 'none';
            document.getElementById('atmPinEnterDisplay').style.display = 'none';
            document.getElementById('atmDisplay').style.display = 'flex';
            document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
            document.getElementById('atmChangePINDisplay').style.display = 'none';
            document.getElementById('atmWithdrawDisplay').style.display = 'none';
            document.getElementById('atmCancelDisplay').style.display = 'none';
            workingWindow = 'atmDisplay';
            amount = '';
            document.getElementById('previousPIN').innerText = '';
            document.getElementById('newPIN').innerText = '';
            document.getElementById('confirmPIN').innerText = '';
            changePin='';
            highlightBox();
            document.getElementById('withdrawAmount').textContent = amount;
            allowAccess = false;
        }
    }

    function cancelWindow() {
        if (workingWindow !== '') {
            document.getElementById('atmEnterDebitCard').style.display = 'none';
            document.getElementById('atmPinEnterDisplay').style.display = 'none';
            document.getElementById('atmDisplay').style.display = 'none';
            document.getElementById('atmCheckBalanceDisplay').style.display = 'none';
            document.getElementById('atmChangePINDisplay').style.display = 'none';
            document.getElementById('atmWithdrawDisplay').style.display = 'none';
            document.getElementById('atmCancelDisplay').style.display = 'flex';
            setTimeout(initialCondition, 3000);
        }
    }

    
    // console.log(amount)


    function highlightBox() {
        if (changePin.length < 4) {
            document.getElementById('previousPIN').style.border = '4px solid black';
            document.getElementById('newPIN').style.border = '2px solid black';
            document.getElementById('confirmPIN').style.border = '2px solid black';
        }
        else if (changePin.length < 8) {
            document.getElementById('previousPIN').style.border = '2px solid black';
            document.getElementById('newPIN').style.border = '4px solid black';
            document.getElementById('confirmPIN').style.border = '2px solid black';
        }
        else {
            document.getElementById('previousPIN').style.border = '2px solid black';
            document.getElementById('newPIN').style.border = '2px solid black';
            document.getElementById('confirmPIN').style.border = '4px solid black';
        }
    }

    function readNumber1() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '1';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '1';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '1';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
            highlightBox();
        }
    }
    function readNumber2() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '2';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '2';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '2';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber3() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '3';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '3';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '3';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber4() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '4';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '4';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '4';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber5() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '5';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '5';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '5';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber6() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '6';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '6';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '6';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber7() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '7';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '7';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '7';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber8() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '8';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '8';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '8';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber9() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '9';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '9';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '9';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function readNumber0() {
        if (workingWindow == 'atmWithdrawDisplay' && amount.length < 5) {
            amount = amount + '0';
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay' && pin.length < 4) {
            pin = pin + '0';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin + '0';
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function clearNumber() {
        if (workingWindow == 'atmWithdrawDisplay') {
            amount = '';
            document.getElementById('withdrawAmount').textContent = '';
        }
        if (workingWindow == 'atmEnterPinDisplay') {
            pin = '';
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            if (changePin.length <= 4) {
                changePin = '';
            }
            else if (changePin.length <= 8) {
                changePin = changePin.slice(0, 4);
            }
            else {
                changePin = changePin.slice(0, 8);
            }
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }
    function backSpaceNumber() {
        if (workingWindow == 'atmWithdrawDisplay') {
            amount = amount.slice(0, amount.length - 1);
            document.getElementById('withdrawAmount').textContent = amount;
        }
        if (workingWindow == 'atmEnterPinDisplay') {
            pin = pin.slice(0, amount.length - 1);
            document.getElementById('atmPin').textContent = pin;
        }
        if (workingWindow == 'atmChangePINDisplay') {
            changePin = changePin.slice(0, changePin.length - 1);
            document.getElementById('previousPIN').innerText = changePin.slice(0, 4);
            document.getElementById('newPIN').innerText = changePin.slice(4, 8);
            document.getElementById('confirmPIN').innerText = changePin.slice(8, 12);
        }
        highlightBox();
    }

    function enterPressed() {
        if (workingWindow == 'atmWithdrawDisplay') {
            if (amount < 30000 && amount <= balance) {
                balance = balance - amount;
                bal=balance;
                alert('Collect your cash. Thank you!')
                amount = '';
                document.getElementById('withdrawAmount').textContent = amount;
                initialCondition();
            }
            else if (amount >= 30000) {
                alert('Can not withdraw amount >= 30000 at a time.')
            }
            else {
                alert('Insufficient balance.');
            }
        }
        if (workingWindow == 'atmEnterPinDisplay') {
            if (pin == atmPIN) {
                allowAccess = true;
                pin = '';
                document.getElementById('atmPin').textContent = pin;
                previousWindow();
            }
            else {
                alert('Wrong PIN! Retry')
                pin = '';
                document.getElementById('atmPin').textContent = pin;
            }
        }
        if (workingWindow == 'atmChangePINDisplay') {
            if (changePin.length < 12) {
                alert('PIN incomplete!!');
            }
            else if (changePin.slice(0, 4) != atmPIN) {
                alert('Old PIN incorrect!! Retry!')
                changePin = '';
                document.getElementById('previousPIN').innerText = '';
                document.getElementById('newPIN').innerText = '';
                document.getElementById('confirmPIN').innerText = '';
            }
            else if (changePin.slice(4, 8) != changePin.slice(8, 12)) {
                alert('Different New PIN and Confirm PIN found!! Retry!');
                changePin = changePin.slice(0, 4);
                document.getElementById('newPIN').innerText = '';
                document.getElementById('confirmPIN').innerText = '';
            }
            else if(changePin.slice(0,4)==changePin.slice(4,8)){
                alert('New PIN and Old PIN can not be same. Retry!!');
                changePin = changePin.slice(0, 4);
                document.getElementById('newPIN').innerText = '';
                document.getElementById('confirmPIN').innerText = '';
            }
            else {
                atmPIN = changePin.slice(8, 12);
                alert('PIN changed Successfully!!');
                initialCondition();
            }
            highlightBox();
        }
    }

    function changeDebitColor() {
        clr = document.getElementById('debitCardMsg').style.color;
        if (clr === 'red') {
            document.getElementById('debitCardMsg').style.color = 'black';
        }
        else {
            document.getElementById('debitCardMsg').style.color = 'red';
        }
        setTimeout(changeDebitColor, 1000);
    }
    changeDebitColor();
    let counter=0;
    function changeIndicatorArrow() {
        if (counter==0) {
            document.getElementById('upwardArrow').innerHTML = `<img src='upwardArrowGreen.png' alt=''>`;
        }
        else {
            document.getElementById('upwardArrow').innerHTML = `<img src='upwardArrowRed.png' alt=''>`;
        }
        counter=counter+1;
        if(counter==2){
            counter=0;
        }
        setTimeout(changeIndicatorArrow, 500);
    }
    changeIndicatorArrow();

    function insertCard() {
        document.getElementById('cardIndicatorButton').style.borderColor = 'blue';
        document.getElementById('cardIndicatorButton').style.background = 'linear-gradient(to top right, white, blue, white)';

        document.getElementById('indicatorButton').style.borderColor = 'green';
        document.getElementById('indicatorButton').style.background = 'linear-gradient(to top right, white, #30ff30, white)';

        document.getElementById('upwardArrow').style.display = 'none';
        enterAtmPinWindow();
    }

</script>

";
if($atmPIN != $userDebitdata['PIN']){
    $updatePIN="UPDATE `banking`.`debitcard` SET `PIN` = {$atmPIN} WHERE `banking`.`debitcard`.`AccountNo` = {$_SESSION['accNo']};";
    mysqli_query($con,$updatePIN);
}
if($bal != $user_data['Balance']){
    $updateBal="UPDATE `banking`.`users` SET `banking`.`Balance` = {$bal} WHERE `banking`.`users`.`AccountNo` = {$_SESSION['accNo']};";
    mysqli_query($con,$updateBal);
}

?>

</html>