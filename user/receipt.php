<?php
    session_start();
    include("../connection/connect.php");

    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this order page
    }

    $o_id = $_GET['o_id'];

    $select_order = " SELECT *
                      FROM orders 
                      WHERE o_id = '$o_id'
                    ";
    $result_order = mysqli_query($conn, $select_order);
    $row_order_table = mysqli_fetch_assoc($result_order);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Details</title>
    <link rel="stylesheet" href="../css/receipt.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Receipt Details</h2>
    </div>

    <div class="sidenav">
        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">

        <button onclick="back()">Back</button>
    </div>

    <div class="main">

        <div class="container"> 

            <h1>Kharle Jane Pet Shop</h1><br>

            <br><hr><br>
            
            <p><b>Order ID:</b> <?php echo $row_order_table['o_id']; ?></p>
            <p><b>Reference Number:</b> <?php echo $row_order_table['reference_no']; ?></p>

            <p><b>Total Amount:</b> <?php echo number_format($row_order_table['total_amount']); ?> &#8369;</p>
            <p><b>Received Amount:</b> <?php echo number_format($row_order_table['received']); ?> &#8369;</p>

            <p><b>Change:</b> <?php echo number_format($row_order_table['received'] - $row_order_table['total_amount']); ?> &#8369;</p>

            <p><b>Date:</b> <?php echo $row_order_table['date']; ?></p>

            <br>
            
            <hr>
            
            <br>

            <ul>
                <?php 
                    $select_products_orders = " SELECT po.p_id, po.quantity, p.name 
                                                FROM products_orders po 
                                                JOIN products p ON po.p_id = p.p_id 
                                                WHERE po.o_id = '$o_id'
                                              ";
                    $result_select = mysqli_query($conn, $select_products_orders);
                    $order_products = mysqli_fetch_all($result_select, MYSQLI_ASSOC);
                    // Fetch products in the order table
                        foreach($order_products as $product){ ?>
                    <li><b>Product:</b> <?php echo $product['name']; ?> x<?php echo $product['quantity']; ?></li>
                <?php } ?>
            </ul>

        </div>
        
    </div>

    <script>
        function back(){
            window.location.href = "order.php";
        }
    </script>
</body>
</html>
