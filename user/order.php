<?php 
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this order page
    }
    
    $product_message = "";

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
        // it set an empty array
    }

    
    if(isset($_POST['add_order'])){
        $p_id = $_POST['p_id'];

        $select_stock = " SELECT stock 
                          FROM products 
                          WHERE p_id = '$p_id'
                        ";
        $result_select = mysqli_query($conn, $select_stock);
        $row_product_table = mysqli_fetch_assoc($result_select);
    
        $quantity =  1;

        if($row_product_table['stock'] >= $quantity){

            if(!isset($_SESSION['cart'][$p_id])){
            
                $select_products = " SELECT * 
                                     FROM products 
                                     WHERE p_id = '$p_id'
                                   ";
                $result_select = mysqli_query($conn, $select_products);
                $row_product_table = mysqli_fetch_assoc($result_select);
    
                $_SESSION['cart'][$p_id] = [ 'name' => $row_product_table['name'],
                                             'price' => $row_product_table['price'],
                                             'quantity' => $quantity
                                           ];
    
                $update_product_stock = " UPDATE products 
                                          SET stock = stock - $quantity 
                                          WHERE p_id = '$p_id'
                                        ";
                $result_update = mysqli_query($conn, $update_product_stock);
                // Update the stock                          
            }

        }else{
            $product_message = "Out of Stock";
        }
    }
    

    if(isset($_POST['update_qty'])){
        $update_quantity = intval($_POST['quantity']);
        $p_id = $_POST['p_id'];
    
        $current_quantity = $_SESSION['cart'][$p_id]['quantity'];
        
        $quantity = $update_quantity - $current_quantity;

        $select_stock = " SELECT stock 
                          FROM products
                          WHERE p_id = '$p_id'
                        ";
        $result_select = mysqli_query($conn, $select_stock);
        $row_product_table = mysqli_fetch_assoc($result_select);

        $stock = $row_product_table['stock'];  
    
            if($quantity <= $stock){
                $_SESSION['cart'][$p_id]['quantity'] = $update_quantity;

                $update_stock = " UPDATE products 
                                  SET stock = stock - $quantity 
                                  WHERE p_id = '$p_id'
                                ";
                $result_update = mysqli_query($conn, $update_stock);
                // Updating my Stock in the Inventory
            }else{
                $product_message = "Not enough Stock";
            }  
    }


    if(isset($_GET['remove_product'])){
        $p_id = $_GET['remove_product'];
        if(isset($_SESSION['cart'][$p_id])){
            $quantity = $_SESSION['cart'][$p_id]['quantity'];
            $update_stock = " UPDATE products 
                              SET stock = stock + $quantity 
                              WHERE p_id = '$p_id'
                            ";
            $result_update = mysqli_query($conn, $update_stock);
            // Updating my stock before removing each product 
        }
        unset($_SESSION['cart'][$p_id]);
        // Removing each product from the cart array
    }

    
    if(isset($_GET['clear_all'])){
        foreach($_SESSION['cart'] as $p_id => $product){
            $quantity = $product['quantity'];
            $update_stock = " UPDATE products 
                              SET stock = stock + $quantity 
                              WHERE p_id = '$p_id'
                            ";
            $result_update = mysqli_query($conn, $update_stock);
            // Updating my stock before clearing all products
        }
        $_SESSION['cart'] = [];
        // Clearing all product to my cart array
    }

    
    if (isset($_POST['payment'])) {   
        $received_amount = $_POST['received'];

        $total_amount = 0;
        $order_date = date('Y-m-d');
        $reference_no = rand(1111, 9999);
    
        foreach ($_SESSION['cart'] as $product) {
            $total_price_qty = $product['price'] * $product['quantity']; 
            $total_amount += $total_price_qty;
            // Calculate total amount before inserting to my order table   
        }
    
        $insert_order = " INSERT INTO orders (reference_no, total_amount,  received, date) 
                          VALUES ('$reference_no', '$total_amount', '$received_amount', '$order_date')
                        ";
        $result_insert = mysqli_query($conn, $insert_order);
    
        if($result_insert) {
            $o_id = mysqli_insert_id($conn);
    
            foreach ($_SESSION['cart'] as $p_id => $product) {
                $quantity = $product['quantity'];
                $insert_order_product = " INSERT INTO products_orders (o_id, p_id, quantity)
                                          VALUES ('$o_id', '$p_id', '$quantity')
                                        ";
                $result_insert_product = mysqli_query($conn, $insert_order_product);
            }   
            
            $_SESSION['cart'] = [];
            // Clear the cart after payment is done
    
            header("Location: receipt.php?o_id=$o_id");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS</title>
    <link rel="stylesheet" href="../css/order.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Point of Sale</h2>
    </div>

    <div class="main">

        <div class="container">

            <div class="box-products">

                <div class="button_text">

                    <div class="home-bttn">
                        <button onclick="home()" class="home-click">HOME</button>
                    </div>

                    <div class="text_box">
                        <h1 style="text-align: center;">Products</h1>
                    </div>
                    
                </div>

                <hr>
                
                <?php
                    $select_product = " SELECT * FROM products
                                         WHERE status = 1
                                       ";
                    $result_select = mysqli_query($conn, $select_product);

                    while($row_product_table = mysqli_fetch_assoc($result_select)){
                        // Only Available Products will Display?>
                <form action="order.php" method="POST">
                    
                    <div class="box">

                        <button type="submit" name="add_order" class="add-bttn-product">

                            <h1><?php echo $row_product_table['category']; ?></h1><br>
                            <h2><?php echo $row_product_table['name']; ?></h2><br>
                            <p><?php echo number_format($row_product_table['price']); ?> &#8369;</p>

                            <input type="hidden" name="p_id" value=" <?php echo $row_product_table['p_id']; ?>">

                        </button>

                    </div>

                </form>
                <?php } ?>
            </div>

            <div class="box-table">

                <div class="order-list"> 
                    <table>

                        <thead>
                            <th>Quantity</th>
                            <th>Item Name</th>
                            <th>Total</th>
                            <th class="operation">Operation</th>
                        </thead>

                        <tbody>
                            <?php      
                               $total_amount = 0;
                                $change = 0;
                                if(!empty($_SESSION['cart'])){

                                    foreach($_SESSION['cart'] as $p_id => $product){
                                        // qty, name, price exist in the cart array
                                        if(isset($product['quantity'], $product['name'], $product['price'])){

                                            $total_price_qty = intval($product['price']) * intval($product['quantity']);
                                            $total_amount = $total_amount + $total_price_qty;  
                                            ?>
                                            <tr>
                                                <td>
                                                    <form action="order.php" method="POST">
                                                        <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
                                                        <input type="number" name="quantity" class="qty-input" value="<?php echo $product['quantity']; ?>">
                                                        <input type="submit" name="update_qty" class="update-bttn" value="Update">
                                                    </form>
                                                </td>
                                                <td> <?php echo $product['name']; ?> </td>
                                                <td> <?php echo number_format($total_price_qty); ?> &#8369;</td>
                                                <td> 
                                                    <a href="order.php?remove_product=<?php echo $p_id; ?>" class="remove-bttn">REMOVE</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                                            <tr>
                                                <td colspan="1"> <span onclick="pay()">Payment</span> </td>
                                                <td> <span onclick="receipt()">Receipt</span> </td>
                                                <td> <?php echo number_format($total_amount); ?> &#8369;</td>
                                                <td>
                                                    <a href="order.php?clear_all" class="clear-bttn" onclick="return confirm('Delete all order list?')">CLEAR ALL</a>
                                                </td>
                                            </tr>
                        </tbody>
                    </table>

                    <h2 style="text-align: center;"><?php echo $product_message ?></h2>

                </div>
                
            </div>

            <div class="pay-container" id="pay-create">

                <div class="pay-box">

                    <div class="form-container">     

                        <form action="order.php" method="POST">

                            <input type="hidden" name="o_id">

                            <label for=""><b>Total amount:</b></label>
                                <p><?php echo number_format($total_amount); ?> &#8369;</p>

                            <label for=""><b>Received amount:</b></label>
                                <input type="number" name="received" required><br>    

                            <button type="submit" name="payment">Pay</button>
                            <button type="button" onclick="cancel()">Cancel</button>
                            
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function home() {
            window.location.href = "home.php";
        }
        function receipt(){
            window.location.href = "products_orders.php";
        }

        function pay(){
            document.getElementById('pay-create').style.display = "block";
        }
        function cancel(){
            document.getElementById('pay-create').style.display = "none";
        }
    </script>
</body>
</html>