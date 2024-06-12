<?php
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this product list page
    }

    // Staff only can access
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inventory managing products, add, view, update, delete">

    <title>Product List</title>

    <link rel="stylesheet" href="../css/product.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Product List</h2>
    </div>

    <div class="sidenav">

        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">

        <button onclick="home()">Home</button>

    </div>

    <div class="main"> 
      
        <div class="table-product">

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $select_products = " SELECT * 
                                             FROM products 
                                           ";
                        $result_select = mysqli_query($conn, $select_products);

                            while($row_products = mysqli_fetch_array($result_select)){
                                // Displaying the Products that has been Added?>
                                <tr>
                                    <td><?php echo $row_products['p_id']; ?></td>
                                    <td><?php echo $row_products['category']; ?></td>
                                    <td><?php echo $row_products['name']; ?></td>
                                    <td><?php echo number_format($row_products['price']); ?> &#8369;</td>
                                    <td><?php echo $row_products['description']; ?></td>
                                    <td><?php echo $row_products['stock']; ?></td>
                                    <td><?php 
                                            if($row_products['status'] == 1){
                                                echo "<a href='' class='avail-bttn'>Available</a>";
                                            }else{
                                                echo "<a href='' class='unavail-bttn'>Unavailable</a>";
                                            }
                                        ?>
                                    </td>
                                <tr>
                            <?php
                            }
                        ?>
                </tbody>

            </table>      

        </div>

    </div>

    <script>
        function home(){
            window.location.href = "home.php";
        }
    </script>
</body>
</html>