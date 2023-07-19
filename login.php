<?php 
    session_start();
?>

<?php
$_SESSION['login_success']=false;

include "dbcon.php";

if(isset($_POST['uname']) && isset($_POST['pswd']))
{
    $uname = $_POST['uname'];
    $pass = $_POST['pswd'];

    $username_search="SELECT * from `banking`.`users` where UserID='$uname'";

    $userquery=mysqli_query($con,$username_search);
    
    $user_count=mysqli_num_rows($userquery);

    if($user_count){ 
        $user_pass=mysqli_fetch_assoc($userquery);
        $savedPassword=$user_pass['Password'];
        
        $_SESSION['Name']=$user_pass['FName']." ".$user_pass['MName']." ".$user_pass['LName'];
        $_SESSION['accNo']=$user_pass['AccountNo'];
        $_SESSION['branch']=$user_pass['Branch'];
        date_default_timezone_set("Asia/Calcutta");
        $_SESSION['loginTime']=date("l")." ".date("Y-m-d")." ".date("h:i:sa");
        $_SESSION['email']=$user_pass['email'];
        $_SESSION['userID']=$user_pass['UserID'];

        if($pass === $savedPassword)
        {
            echo "
            <script>
            alert('Login Successful'); 
            </script>
            ";

            header('location:AfterLandingPage.php');
            $_SESSION['login_success']=true;
        }
        else{
            echo "
            <script>
                alert('Incorrect Password');
            </script>
            ";
        }

    }
    else{
        echo "
        <script>
            alert('UserName does not exist!');
        </script>
        ";
    }

    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
</head>
<body>
    <form action="login.php" method="POST">
        <div class ="form-box">
            <h1>Login</h1>
            <div class="input-box">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            <input type="text" name= "uname" placeholder="Username">
        </div>
        <div class="input-box">
            <i class="fa fa-key" aria-hidden="true"></i>
            <input type="password" name="pswd" placeholder="Password" id="myInput">
            <span class="eye" onclick = "myFunction()" >
            <i id="hide1" class="fa fa-eye" aria-hidden="true"></i>
            <i id ="hide2" class="fa fa-eye-slash" aria-hidden="true"></i>
            </span>
        </div>
        <input type="submit" value="Login" class="login-btn">
    </form>
    <p class="dont">Don't have an account?</p>
    <a href="CreateAccount.php"><button type="button" class="create-btn">Create account</button></a>
    </div>

    <script>
        function myFunction(){
            var x = document.getElementById("myInput");
            var y = document.getElementById("hide1");
            var z = document.getElementById("hide2");

            if(x.type==='password'){
                x.type="text";
                y.style.display="block";
                z.style.display="none";

            }
            else{
                x.type="password";
                y.style.display="none";
                z.style.display="block";
            }
        }
       </script>
</body>
</html>