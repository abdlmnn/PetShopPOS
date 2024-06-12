<?php
    session_start();
    include("../connection/connect.php");
    
    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this inventory page
    }
    
    if($_SESSION['usertype'] !== 'admin'){
        header("location: product_list.php");
        exit();
        // Staff can't access Inventory but he can View Product list
    }


    if(isset($_POST['add-product'])){
        $category = $_POST['category'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        
        $insert_new_product = " INSERT INTO products (category, name, price, stock, description)
                                VALUES ('$category', '$name', '$price', '$stock','$description') 
                              ";
        $result_insert = mysqli_query($conn, $insert_new_product);
        // Adding New Product to my Inventory
    }


    if(isset($_POST['update-product'])){
        $p_id = $_POST['p_id'];
        $category = $_POST['category'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        
        $update_product = " UPDATE products 
                            SET category = '$category', 
                                name = '$name', 
                                price = '$price', 
                                stock = '$stock', 
                                description = '$description' 
                            WHERE p_id = '$p_id' 
                          ";
        $result_update = mysqli_query($conn, $update_product);
        // Updating Product to my Inventory
    }


    if(isset($_GET['delete_product'])){
        $p_id = $_GET['delete_product'];

        $delete_product = " DELETE FROM products
                            WHERE p_id = '$p_id' 
                          ";
        $result_delete = mysqli_query($conn, $delete_product);
        // Deleting Product to my Inventory
    }


    if(isset($_GET['p_id'])){
        $p_id = $_GET['p_id'];
        $status = $_GET['status'];
        
        $select_product = " UPDATE products 
                            SET status = '$status' 
                            WHERE p_id = '$p_id' 
                          ";
        $result_select = mysqli_query($conn, $select_product);
        // Update Available or Unavailable Product
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="../css/inventory.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Product List</h2>
    </div>

    <div class="sidenav">
        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">

        <button onclick="create()">Create</button><br><br>

        <hr style="border: 2px solid white;"><br>

        <button onclick="home()">Home</button>
    </div>

    <div class="main"> 

        <div class="container1" id="form-create">

            <div class="container2">

                <div class="form-container">

                    <h3 style="text-align: center; background-color: #fff;">
                        C<br>r<br>e<br>a<br>t<br>e<br><br>P<br>r<br>o<br>d<br>u<br>c<br>t<br>s
                    </h3><hr> 

                    <form action="inventory.php" method="POST">

                        <label for="category">Category</label>
                            <input type="text" name="category" required>

                            <br><br>

                        <label for="name">Product Name</label>
                            <input type="text" name="name" required>

                            <br><br>

                        <label for="price">Price</label>
                            <input type="number" name="price" required>

                            <br><br>    

                        <label for="stock">Stock</label>
                            <input type="number" name="stock" required>

                            <br><br> 

                        <label for="description">Description</label>    
                            <textarea name="description" rows="5" cols="39" required></textarea>

                            <br><br>

                        <button type="submit" name="add-product" class="add-bttn">ADD</button>
                        <button class="cancel-bttn" onclick="cancel()">CANCEL</button>
                        
                    </form> 

                </div> 
                <div class="cont-black"></div>

            </div>

        </div>
        
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
                        <th class='operation'>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $select_products = " SELECT * 
                                             FROM products 
                                           ";
                        $result_select = mysqli_query($conn, $select_products);

                            while($row_product_table = mysqli_fetch_array($result_select)){
                                // Displaying the Products that has been Added?>
                                <tr>
                                    <td><?php echo $row_product_table['p_id']; ?></td>
                                    <td><?php echo $row_product_table['category']; ?></td>
                                    <td><?php echo $row_product_table['name']; ?></td>
                                    <td><?php echo $row_product_table['price']; ?> &#8369;</td>
                                    <td><?php echo $row_product_table['description']; ?></td>
                                    <td><?php echo $row_product_table['stock']; ?></td>
                                    <td><?php 
                                            if($row_product_table['status'] == 1){
                                                echo "<a href='inventory.php?p_id=$row_product_table[p_id] &status=0' class='avail-bttn'>Available</a>";
                                            }else{
                                                echo "<a href='inventory.php?p_id=$row_product_table[p_id] &status=1' class='unavail-bttn'>Unavailable</a>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="view.php?view_product=<?php echo $row_product_table['p_id']; ?>" class="operation1">READ</a>
                                        <a href='update.php?edit_product=<?php echo $row_product_table['p_id']; ?>' class="operation1">UPDATE</a>
                                        <a href="inventory.php?delete_product=<?php echo $row_product_table['p_id']; ?>" class="operation1">DELETE</a>
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
        function create(){
            document.getElementById("form-create").style.display = "block";
        }
        function cancel(){
            document.getElementById("form-create").style.display = "none";
        }
    </script>
</body>
</html>