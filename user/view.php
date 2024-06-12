<?php 
    session_start();
    include("../connection/connect.php");

    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this view page
    }

    if (isset($_GET['view_product'])) {
        $p_id = $_GET['view_product'];

        $select_product = " SELECT * 
                            FROM products
                            WHERE p_id = '$p_id' 
                          ";
        $result_select = mysqli_query($conn, $select_product);

        $row_product_table = mysqli_fetch_array($result_select);
        // Selecting to View Product to my Inventory
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link rel="stylesheet" href="../css/view.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>View Product</h2>
    </div>

    <div class="main">

        <div class="sidenav">
            <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">
            <button onclick="back()">Back</button>
        </div>

        <div class="container1">

            <h1>#<?php echo $row_product_table['p_id']; ?></h1><hr>

            <div class="product-details">

                <h1>Category</h1>
                <p><?php echo $row_product_table['category']; ?></p><hr>

                <h1>Name</h1>
                <p><?php echo $row_product_table['name']; ?></p><hr>

                <h1>Price</h1>
                <p><?php echo $row_product_table['price']; ?></p><hr>

                <h1>Stock</h1>
                <p><?php echo $row_product_table['stock']; ?></p><hr>
                
                <h1>Description</h1>
                <p><?php echo $row_product_table['description']; ?></p>

            </div>

        </div>


    <script>
        function back(){
            window.location.href = "inventory.php";
        }
    </script>
</body>
</html>
