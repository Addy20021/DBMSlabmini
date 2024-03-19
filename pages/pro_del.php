<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM product WHERE PRODUCT_ID = $id";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        ?>
        <script type="text/javascript">
            alert("Product Successfully Deleted.");
            window.location = "product.php";
        </script>
        <?php
    } else {
        echo "Product ID is not specified.";
    }
} else {
    echo "Invalid action.";
}

include'../includes/footer.php'
?>