<?php 
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this order list page
    }

    $select_order_product = " SELECT *
                              FROM products_orders
                            "; 
    $result_order_product = mysqli_query($conn, $select_order_product);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordered Products</title>
    <link rel="stylesheet" href="../css/order_products.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">

</head>
<body>

    <div class="upperContainer">
        <h2>Ordered Products</h2>
    </div>

    <div class="sidenav">
        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">

        <button onclick="back()">Back</button>
    </div>

    <div class="main">

        <div class="box-table">

            <div class="order-list">

                <table>

                    <thead>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th class="operation">Receipt</th>
                    </thead>

                    <tbody>
                        <?php 
                            while($row_order_product = mysqli_fetch_array($result_order_product)){
                                // Display Order_Products table ?>
                                <tr>
                                    <td> <?php echo $row_order_product['o_id']; ?></td>
                                    <td> <?php echo $row_order_product['p_id']; ?> </td>
                                    <td> <?php echo number_format($row_order_product['quantity']); ?></td>
                                    <td>
                                        <a href="receipt.php?o_id=<?php echo $row_order_product['o_id']; ?>" class="operation1">READ</a>
                                    </td>
                                </tr>
                        <?php
                            } ?>
                    </tbody>
                    
                </table>
            
            </div>

        </div>

    </div>

    <script>
        function back(){
            window.location.href = "order.php";
        }
    </script>
</body>
</html>