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
    <title>Debit Card Payment Portal</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="debit.css"> 
</head>

<body>
    
    <div class="wrapper">
        <div class="payment">
          <div class="payment-logo">
            <p>p</p>
          </div>
          
          
          <h2>Payment Gateway</h2>
          <div class="form">
            <div class="card space icon-relative">
              <label class="label">Sender's Account Number:</label>
              <input type="text" class="input" placeholder="Sender's account no." required>
              <i class="far fa-credit-card"></i>
            </div>
            <div class="card space icon-relative">
              <label class="label">Receiver's Account Number:</label>
              <input type="text" class="input" data-mask="0000 0000 0000 0000" placeholder="Receiver's account no." required>
              <i class="far fa-credit-card"></i>
            </div>
            <div class="card-grp space">
              <div class="card-item icon-relative">
                <label class="label">Expiry date:</label>
                <input type="text" name="expiry-data" class="input"  placeholder="00 / 00" required>
                <i class="far fa-calendar-alt"></i>
              </div>
              <div class="card-item icon-relative">
                <label class="label">CVV:</label>
                <input type="text" class="input" data-mask="000" placeholder="000" required>
                <i class="fas fa-lock"></i>
              </div>
            </div>
            <div class="card-item icon-relative">
              <label class="label">Amount:</label>
              <input type="number" class="input" placeholder="₹" required>
            </div>
              
            <div class="btn" onclick="payNow()">
              Pay
            </div> 
            
          </div>
        </div>
      </div>
</body>
<script>
  function payNow(){
    alert('Amount transferred SUCCESSFULLY!!');
  }
</script>
</html>
