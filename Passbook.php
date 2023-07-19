<?php
    session_start();

    if(!$_SESSION['Name']){
        header('location: login.php');
    }
?>

<?php
    include "dbcon.php";
    $query1="SELECT * from `banking`.`{$_SESSION['userID']}transaction`;";
    $result=mysqli_query($con, $query1);
    $rowCount=$result->num_rows;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passbook</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tinos&display=swap" rel="stylesheet">

    <style>
        #heading{
            color: red;
            font-family: 'Tinos', serif;
            font-size: 1.5rem;
            text-decoration: underline blue;
            /* text-shadow: 1px 1px #ffa8a8; */
            text-underline-offset: 1.2rem;
            margin-bottom: 3rem;
        }
        #passBook{
            width: 70%;
            margin: auto;
            border: 2px solid black;
        }
        #passBook table{
            text-align: center;
            margin: auto;
            width: 100%;
            font-family: 'Roboto Slab', serif;
            background: linear-gradient(to top right, white, #00b8ff47,white,#00b8ff47,white)
        }
        #passBook table tr th, #passBook table tr td{
            text-align: center;
            margin: 2px 5px;
        }

        #passBook table tr th{
            color: white;
            background-color: #0080ff;
            border: 2px solid rgb(0, 38, 255);
        }
        #details{
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <div style="text-align: center;" id='heading'>
        Your transactions' list
    </div>
    <div id='details'>
        <span id="name"></span>
        <span id="acNo"></span>
    </div>
    <div id="passBook">
        <table id='entries'>
            <tr>
                <th>S No.</th>
                <th>Transfer To</th>
                <th>Transfer From</th>
                <th>Mode</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Balance</th>
            </tr>
        </table>
    </div>
</body>

<?php
if ($rowCount > 0) {
    $count=1;
    while($row = $result->fetch_assoc()) {
        echo "
        <script>
        name='{$_SESSION['Name']}';
        name=name.toUpperCase();
        console.log(name);
        accNo='{$_SESSION['accNo']}';
        document.getElementById('name').innerHTML='Name: '+name;
        document.getElementById('acNo').innerHTML='Account Number: '+accNo;
        function addEntries(){
            document.getElementById('entries').insertRow
            let table = document.getElementById('entries');
            let row = table.insertRow({$count});
            let cell0 = row.insertCell(0);
            let cell1 = row.insertCell(1);
            let cell2 = row.insertCell(2);
            let cell3 = row.insertCell(3);
            let cell4 = row.insertCell(4);
            let cell5 = row.insertCell(5);
            let cell6 = row.insertCell(6);
            cell0.innerHTML = '{$row["Sno"]}';
            cell1.innerHTML = '{$row["Transfer_to"]}';
            cell2.innerHTML = '{$row["Transfer_from"]}';
            cell3.innerHTML = '{$row["Mode"]}';
            cell4.innerHTML = '{$row["Date"]}';
            cell5.innerHTML = '{$row["Amount"]}';
            cell6.innerHTML = '{$row["Bal"]}';
        }
        addEntries();
        </script>
        ";
        $count=$count+1;
    }
  } else {
    echo "No transactions yet";
  }
  $con->close();
?>

</html>