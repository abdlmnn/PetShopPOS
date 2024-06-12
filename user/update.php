<?php
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this update page
    }

    if(isset($_GET['edit_product'])){
        $p_id = $_GET['edit_product'];

        $select_product = " SELECT * FROM products
                            WHERE p_id = '$p_id' "; 
        $result_select = mysqli_query($conn, $select_product);
        $row_product_table = mysqli_fetch_array($result_select);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Update Product Form">

    <title>Update Product</title>

    <link rel="stylesheet" href="../css/update.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Update Product</h2>
    </div>
    
    <div class="sidenav">
        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">
        <button onclick="back()">Back</button>
    </div>

    <div class="main">
        <div class="container1">

            <form action="inventory.php" method="POST">

                <input type="hidden" name="p_id" value="<?php echo $row_product_table['p_id']; ?>">

                <div class="input-cont">
                <label for="category">Category</label>
                    <input type="text" name="category" value="<?php echo $row_product_table['category']; ?>" required>
                </div>

                <div class="input-cont">
                <label for="name">Product Name</label>
                    <input type="text" name="name" value="<?php echo $row_product_table['name']; ?>" required>
                </div>

                <div class="input-cont">
                <label for="price">Price</label>
                    <input type="number" name="price" value="<?php echo $row_product_table['price']; ?>" required>
                </div>

                <div class="input-cont">
                <label for="stock">Stock</label>
                    <input type="number" name="stock" value="<?php echo $row_product_table['stock']; ?>" required>
                </div>

                <div class="input-cont">
                <label for="description">Description</label>
                    <textarea name="description" rows="5" cols="39" required><?php echo $row_product_table['description']; ?></textarea>
                </div>

                <div class="cont-bttn">
                     <button type="submit" name="update-product" class="update-bttn">Update</button>
                </div>

            </form>
        </div>
    </div>
    
    <script>
        function back(){
            window.location.href = "inventory.php";
        }
    </script>
</body>
</html>
