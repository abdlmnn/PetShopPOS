<?php 
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this home page
    }
    
    $select_products = " SELECT * 
                         FROM products 
                       ";
    $result_select = mysqli_query($conn, $select_products);
    $row_products_table = mysqli_num_rows($result_select);
    // Display Total Products

    $select_orders = " SELECT * 
                       FROM orders
                     ";
    $result_select = mysqli_query($conn, $select_orders);
    $row_orders_table = mysqli_num_rows($result_select);
    // Display Total Sales
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <header>

        <div class="upperContainer">
             <h2>Point of Sales</h2>
        </div>

    </header>

    <main>

        <div class="container">

            <h1>Kharle Jane Pet Shop</h1>

            <div class="buttons">

                <a href="order.php" class="button">
                    <div>
                        <img src="../image/Icons/pos.png" alt="POS Icon" height=100>
                    </div>
                    Order
                </a>
                
                <a href="inventory.php" class="button">
                    <div>
                        <img src="../image/Icons/inventory.png" alt="Inventory Icon" height=100>
                    </div>
                    Inventory
                </a>

                <a href="report.php" class="button">
                    <div>
                        <img src="../image/Icons/report.png" alt="Sales Report Icon" height=100>
                    </div>
                    Report
                </a>

                <a href="../logout.php" class="button">
                    <div>
                        <img src="../image/Icons/logout.png" alt="Logout Icon" height=100>
                    </div>
                    Logout
                </a>

            </div>
            
            <div class="display-total">

                    <div class="total-sales">
                        <h3>Total Sales</h3>
                        <hr><br>
                        <p><?php echo $row_orders_table ?></p>
                    </div>

                    <div class="user">
                        <h3>User</h3>
                        <hr><br>
                        <?php echo "<p>" .$_SESSION['usertype']. "</p>"; ?>
                    </div>

                    <div class="total-products">
                        <h3>Total Products</h3>
                        <hr><br>
                        <?php echo "<p>" .$row_products_table. "</p>"; ?>
                    </div>
            </div>

        </div>

    </main>

</body>
</html>