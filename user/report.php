<?php
    session_start();
    include("../connection/connect.php");

    if(!isset($_SESSION['username'])){
        header("location: ../login.php");
        exit();
        // the Logged in user can't access to this inventory page
    }

    if($_SESSION['usertype'] !== 'admin'){
        header("location: home.php");
        exit();
        // Staff can't access Inventory but he can View Product list
    }

    $start= "";
    $end = "";
    $select_date = "";

    if(isset($_POST['submit'])){    
        $start = $_POST['start'];
        $end = $_POST['end'];
        $select_date = " WHERE DATE(date) 
                         BETWEEN '$start' 
                         AND '$end'
                       ";
        
    }
    
    $select_sales = " SELECT * 
                      FROM orders 
                      $select_date
                    ";
    $result_select= mysqli_query($conn, $select_sales);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="../css/salesreport.css">
    <link rel="shortcut icon" href="../image/Logo/PetShopLogo.png" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/bankgothic-md-bt" rel="stylesheet">
</head>
<body>

    <div class="upperContainer">
        <h2>Sales Report</h2>
    </div>

    <div class="sidenav">
        <img src="../image/Logo/Whitelogo.png" alt="Pet Logo" height="140">

        <button onclick="date()">Date</button><br><br>

        <hr style="border: 2px solid white;"><br>

        <button onclick="home();">Home</button>
    </div>

    <div class="main">

        <div class="date-container" id="date-form">

            <div class="date">

                <div class="form-container">     

                    <form action="report.php" method="POST">

                        <label for="date">Start:</label>
                            <input type="date" name="start" value="<?php echo $date; ?>" required>
                        <label for="date">End:</label>
                            <input type="date" name="end" value="<?php echo $date; ?>" required>
                        
                            <br>

                        <button type="submit" name="submit">Filter</button>
                        <button onclick="cancel()">Cancel</button>

                    </form>

                </div>

            </div>

        </div>             

    
        <div class="table-product">

                <table>
                    
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ref no.</th>
                            <th>Total Amount</th>
                            <th>Pay Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $total = 0;
                            $received_amount = 0;

                            while($row_order_table = mysqli_fetch_assoc($result_select)){ 
                                $total = $total + $row_order_table['total_amount'];
                                $received_amount = $received_amount + $row_order_table['received'];
                                // Calculate all my total amount and received amount in order table
                                // Display Order table
                        ?>
                            <tr>
                                <td><?php echo $row_order_table['o_id']; ?></td>
                                <td><?php echo $row_order_table['reference_no']; ?></td>
                                <td><?php echo number_format($row_order_table['total_amount']); ?> &#8369;</td>
                                <td><?php echo number_format($row_order_table['received']); ?> &#8369;</td>
                                <td><?php echo $row_order_table['date']; ?></td>
                            </tr>
                        <?php 
                            } 
                            mysqli_data_seek($result_select, 0);    
                        ?>
                            <tr>
                                <td colspan="2"><b>Total</b></td>
                                <td> <b><?php echo number_format($total); ?> &#8369;</b></td>
                                <td> <b><?php echo number_format($received_amount); ?> &#8369;</b></td>
                                <td colspan="2"> </td>
                            </tr>
                </table>
        </div>

    </div>
    
    <script>
        function home(){
            window.location.href = "home.php";
        }
        function date(){
            document.getElementById('date-form').style.display = "block";
        }
        function cancel(){
            document.getElementById('date-form').style.display = "none";
        }
        
    </script>
</body>
</html>
