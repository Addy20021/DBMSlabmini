<?php
include('../includes/connection.php');

$zz = $_POST['idd'];
$a = $_POST['qty'];
$b = $_POST['oh'];

$query = 'UPDATE product 
          SET QTY_STOCK="'.$a.'", 
              ON_HAND="'.$b.'" 
          WHERE PRODUCT_ID ="'.$zz.'"';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// Call the stored procedure update_qty_stock
$update_qty_stock_result = mysqli_query($db, "CALL update_qty_stock()");

// Check if the stored procedure executed successfully
if ($update_qty_stock_result) {
    // Display local host message
    echo '<script type="text/javascript">
        alert("You\'ve successfully modified the product. As a result  trigger being triggered due to less amount, stocks will be replenished");
        window.location = "inventory.php";
    </script>';
} else {
    // Display error message if stored procedure execution fails
    echo '<script type="text/javascript">
        alert("An error occurred while updating the quantity stock.");
        window.location = "inventory.php";
    </script>';
}
?>
