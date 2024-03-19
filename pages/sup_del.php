<?php
include '../includes/connection.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            // Attempt to delete the supplier
            $query = "DELETE FROM supplier WHERE SUPPLIER_ID = $id";
            $result = mysqli_query($db, $query);

            if (!$result) {
                // Check if the error is due to a foreign key constraint violation
                if (mysqli_errno($db) == 1451) {
                    ?>
                    <script type="text/javascript">
                        alert("Supplier cannot be deleted because it is associated with one or more products.");
                        window.location = "supplier.php";
                    </script>
                    <?php
                } else {
                    // Handle other types of errors
                    throw new Exception(mysqli_error($db));
                }
            } else {
                // Trigger the trigger manually
                mysqli_query($db, "DELETE FROM supplier_audit WHERE deleted_supplier_id = $id");
                ?>
                <script type="text/javascript">
                    alert("Supplier Successfully Deleted.");
                    window.location = "supplier.php";
                </script>
                <?php
            }
        } catch (Exception $e) {
            // Display a generic error message
            ?>
            <script type="text/javascript">
                alert("An error occurred while deleting the supplier. Please try again later because u r still using the supplier in ur product section.");
                window.location = "supplier.php";
            </script>
            <?php
        }
    } else {
        echo "Invalid action or ID not specified.";
    }
} else {
    echo "Invalid action or ID not specified.";
}
?>
