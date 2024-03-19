<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM users WHERE ID = $id";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        ?>
        <script type="text/javascript">
            alert("User Successfully Deleted.");
            window.location = "user.php";
        </script>
        <?php
    } else {
        echo "Invalid action or ID not specified.11";
    }
} else {
    echo "Invalid action or ID not specified.";
}

include '../includes/footer.php';
?>
