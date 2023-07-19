<?php
    session_start();
?>

<?php
$insert=false;
if(isset($_POST['FName'])){
    $server= "localhost";
    $username="root";
    $password="";

    $con= mysqli_connect($server,$username,$password);

    if(!$con)
    {
        die("Connection to the server failed due to ".mysqli_connect_error());
    }


    $FName = $_POST['FName'];
    $MName = $_POST['MName'];
    $LName = $_POST['LName'];
    $PNo = $_POST['PNo'];
    $EMail = $_POST['EMail'];
    $UName = $_POST['Username'];
    $Pass = $_POST['Pass'];
    $accNo=rand(100000000000,999999999999);
    $CPass=$_POST['confirmPass'];
    $bal= intval($_POST['initBal']);

    $gender=$_POST['gender'];
    $category=$_POST['category'];
    $dob=$_POST['birthdate'];
    $maritalStat=$_POST['mstatus'];
    $occupation=$_POST['occupation'];
    $address=$_POST['address'];
    $branch=$_POST['branch'];

    $userquery="SELECT * from `banking`.`users` where `UserID`='$UName';";
    $query=mysqli_query($con, $userquery);

    $usercount= mysqli_num_rows($query);

    if($usercount>0){
        echo "
        <script>
            alert('UserID already exists!');
        </script>
        ";
    }
    else{
        if($Pass === $CPass){
            $sql="INSERT INTO `banking`.`users` (`FName`, `MName`, `LName`, `PhoneNo`, `email`, `UserID`, `Password`, `AccountNo`, `Branch`, `Balance`) VALUES ('$FName', '$MName', '$LName', '$PNo', '$EMail', '$UName', '$Pass', '$accNo', '$branch', '$bal');";

            $TransactionTable=$UName."Transaction";

            $sql2="CREATE TABLE `banking`.`$TransactionTable` ( `Sno` INT NOT NULL AUTO_INCREMENT, `Transfer_to` VARCHAR(255) NOT NULL , `Transfer_from` VARCHAR(255) NOT NULL , `Mode` VARCHAR(255) NOT NULL, `Date` DATE NOT NULL , `Amount` DOUBLE NOT NULL , `Bal` DOUBLE NOT NULL, PRIMARY KEY (`Sno`));";

            $FullName=$FName." ".$MName." ".$LName;
            $debitCardNo=rand(100000000000,999999999999);
            $CVV=rand(100,999);
            $PIN=rand(1000,9999);
            $validDate = strtotime("+4 year", strtotime(date('y-m-d')));
            $validDate=date('y-m-d', $validDate);

            $sql3="INSERT INTO `banking`.`debitcard` (`Name`, `DebitCardNo`, `PIN`, `CVV`, `AccountNo`, `Validity`) VALUES ('$FullName', '$debitCardNo', '$PIN', '$CVV', '$accNo', '$validDate');";
            $sql4="INSERT INTO `banking`.`usersextrainfo` (`UserID`, `Gender`, `Categry`, `DOB`, `MaritalStat`, `Occupation`, `Address`) VALUES ('$UName', '$gender', '$category', '$dob', '$maritalStat', '$occupation', '$address');";
            
            if($con->query($sql) == true && $con->query($sql2) == true && $con->query($sql3) == true && $con->query($sql4) == true){
                $insert=true;
                echo "
                <script>
                    alert('Your account has been created SUCCESSFULLY!!');
                </script>
                ";
            }
            else{
                echo "ERROR: $sql <br> $con->error";
            }
        }
        else{
            echo "
            <script>
                alert('Password and Confirm Password did not match.');
            </script>
            ";
        }
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account Page</title>
    <link rel="stylesheet" href="CreateAccount.css">
    <link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Volkhov:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="block">
        <h1>Create Account</h1>
        <div class="table">
            <div class="input_field">
                <h3>Personal Details</h3>
                <div class="personaldetails">
                    <form action="CreateAccount.php" method="post">
                    <div class="name">
                        <div class="container1">
                            <input type="text" class="n1" id="name1" placeholder=" " name="FName" required>
                            <label for="name1" class="fname">First Name</label>
                        </div>
                        <div class="container2">

                            <input type="text" class="input" id="name2" placeholder=" " name="MName" required>
                            <label for="name2" class="mname">Middle Name</label>
                        </div>
                        <div class="container3">
                            <input type="text" class="input" id="name3" placeholder=" " name="LName" required>
                            <label for="name3" class="lname">Last Name</label>
                        </div>
                    </div>
                    <div class="userpasscp">
                        <div class="username">
                            <input type="text" name="Username" id="username" maxlength="20" placeholder=" " required>
                            <label for="username" class="uname">Username</label>
                        </div>
                        <div class="password">
                            <input type="password" name="Pass" id="password" maxlength="10" placeholder=" " required>
                            <label for="password" class="pwd">Password</label>
                            <!-- <i class="uil uil-eye-slash toggle"></i> -->
                        </div>
                        <div class="cpassword">
                            <input type="password" name="confirmPass" id="cnfpswd" maxlength="10" placeholder=" " required>
                            <label for="cnfpswd" class="cpwd">Confirm Password</label>
                            <!-- <i class="uil uil-eye-slash toggle"></i> -->
                        </div>
                    </div>
                    <div class="pnoemailbal">
                        <div class="phno">
                            <input type="number" name="PNo" id="pno" maxlength="10" placeholder=" " required>
                            <label for="pno" class="pnumber">Phone Number</label>
                        </div>
                        <div class="e-mail">
                            <input type="text" name="EMail" id="email" placeholder=" ">
                            <label for="email" class="email">Email</label>
                        </div>
                        <div class="inibal">
                            <input type="number" name="initBal" id="ib" maxlength="10" placeholder=" " required>
                            <label for="ib" class="ibalance">Initial Balance</label>
                        </div>
                    </div>
                    <div class="gencat">
                        <div class="gender">
                            <label for="gender">Gender:</label>
                            <label for="male" class="dot">Male
                                <input type="radio" id="male" name="gender" value="Male">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                            <label for="female" class="dot">Female
                                <input type="radio" id="female" name="gender" value="Female">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                            <label for="other" class="dot">Other
                                <input type="radio" id="other" name="gender" value="Other">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                        </div>
                        <div class="category">
                            <label for="category">Category:</label>
                            <label for="general" class="dot">General
                                <input type="radio" id="general" name="category" value="General">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                            <label for="sc" class="dot">SC
                                <input type="radio" id="sc" name="category" value="SC">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                            <label for="st" class="dot">ST
                                <input type="radio" id="st" name="category" value="ST">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                            <label for="obc" class="dot">OBC
                                <input type="radio" id="obc" name="category" value="OBC">
                                <!-- <span class="dotmark"></span> -->
                            </label>
                        </div>
                    </div>

                    <div class="dobstatus">
                        <div class="dob">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="birthdate" id="dob">
                        </div>
                        <div class="mstatus">
                            <label for="mstatus">Marital Status:</label>
                            <!-- <label for="married" class="dot">Married
                                <input type="radio" name="status" id="married" value="Married">
                                <span class="dotmark"></span>
                            </label>
                            <label for="unmarried" class="dot">Unmarried
                                <input type="radio" name="status" id="unmarried" value="Unmarried">
                                <span class="dotmark"></span>
                            </label> -->
                            <select name="mstatus" id="mstatus">
                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                            </select>
                        </div>
                    </div>
                    <div class="occadd">
                        <div class="occupation">
                            <input type="text" name="occupation" id="occupation" placeholder=" " required>
                            <label for="occupation" class="occ">Occupation</label>
                        </div>
                        <div class="address">
                            <input type="text" name="address" id="address" placeholder=" " required>
                            <label for="address" class="add">Correspondence Address</label>
                        </div>
                    </div>
                    <div class="brname">
                        <input type="text" name="branch" id="branch" placeholder=" " required>
                        <label for="branch" class="br">Branch Name</label>
                    </div>
                </div>
                <!-- <h3>Bank Details*</h3>
                <div class="bankdetails">
                    <div class="typeholder">
                        <div class="acctype">
                            <label for="acctype">Account Type:</label>
                            <label for="savings" class="dot">Savings Account         
                                <input type="radio" name="acctype" id="savings" value="Savings">
                                <span class="dotmark"></span>
                            </label>
                             
                             <br> -->
                <!-- <label for="current" class="dot">Current Account
                                <input type="radio" name="acctype" id="current" value="Current">
                                <span class="dotmark"></span>
                            </label>

                            <label for="salary" class="dot">Salary Account                         
                                <input type="radio" name="acctype" id="salary" value="Salary">
                                <span class="dotmark"></span>
                            </label> -->

                <!-- <br> -->
                <!-- <label for="recurring" class="dot">Recurring Account
                                <input type="radio" name="acctype" id="recurring" value="Recurring">
                                <span class="dotmark"></span>
                            </label>
                            
                            <label for="fixed" class="dot">Fixed Account
                                <input type="radio" name="acctype" id="fixed" value="Fixed">
                                <span class="dotmark"></span>  
                            </label>
                        </div>
                        <br>
                        <div class="accholdertype">
                            <label for="accholdertype">Account Holder Type:</label>
                            <label for="individual" class="dot">Individual
                                <input type="radio" name="accholdertype" id="individual" value="Individual">
                                <span class="dotmark"></span>
                            </label>
                            <label for="joint" class="dot">Joint
                                <input type="radio" name="accholdertype" id="joint" value="Joint">
                                <span class="dotmark"></span>
                            </label>
                        </div>
                    </div> -->

                <!-- </div> -->
                <h3>PAN and Aadhaar Details</h3>
                <div class="pan_aadhaar">
                    <div class="pan">
                        <label for="pan" class="check">PAN Card
                            <input type="checkbox" name="panCard" id="pan">
                            <!-- <span class="checkmark"></span> -->
                        </label>
                    </div>
                    <div class="aadhaar">
                        <label for="aadhaar" class="check">Aadhaar Card
                            <input type="checkbox" name="aadhaarCard" id="aadhaar">
                            <!-- <span class="checkmark"></span> -->
                        </label>
                    </div>
                </div>
            </div>
            <div class="btn" id="button">
                <button type="submit">Submit</button>
            </div>
            </form>
            <!-- <p>Already have an account?
                <div class="login">
                    <a href="#" id="login">Log In</a>               
                </div>
            </p> -->
            <div class="login">Already have an account?
                <a href="login.php" id="login">Log In</a>
            </div>
        </div>
    </div>

</body>
<script type="text/javascript">
    const buttons = document.querySelectorAll('a');
    buttons.forEach(btn => {
        btn.addEventListener('click', function (e) {

            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;

            let ripples = document.createElement('span');
            ripples.style.left = x + 'px';
            ripples.style.top = y + 'px';
            this.appendChild(ripples);

            setTimeout(() => {
                ripples.remove()
            }, 1000);
        })
    })
</script>



</html>