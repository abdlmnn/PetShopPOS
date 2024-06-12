<?php 
    session_start();
    include("connection/connect.php");

    $error_message = "";
    
   if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $select_user = " SELECT * 
                         FROM user 
                         WHERE username = '$username' 
                         AND password = '$password' 
                       ";
        $result_select = mysqli_query($conn, $select_user);

            if($row_user_table = mysqli_fetch_array($result_select)){

                if($row_user_table['usertype'] == "admin"){
                    $_SESSION['username'] = $username;
                    $_SESSION['usertype'] = $row_user_table['usertype'];
                    $_SESSION['user_id'] = $row_user_table['user_id']; 

                    header("location: user/home.php");
                    exit();
                }else{
                    $_SESSION['username'] = $username;
                    $_SESSION['usertype'] = $row_user_table['usertype'];
                    $_SESSION['user_id'] = $row_user_table['user_id']; 

                    header("location: user/home.php");
                    exit();
                }

            }else{
                $error_message = "username or password incorrect";
            }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>
    <div class="login-container">

        <div class="logo-container">
            <img src="image/Logo/Title&Logo.jpg" alt="Kharle Jane Pet Shop Logo">
        </div>

        <div class="login-form">
            
            <form action="login.php" method="POST">

                <h1>Login your account</h1>
                
                <div class="group">
                    <input type="username" name="username" placeholder="USERNAME" autofocus required>
                </div>

                <div class="group">
                    <input type="password" name="password" placeholder="PASSWORD" required>
                </div>

                <button type="submit" name="login">LOGIN</button>

                <?php 
                    if(!empty($error_message)){
                        echo "<div class='errorMessage'> $error_message </div>";
                    } 
                ?>

            </form>
        </div>

    </div>
</body>
</html>