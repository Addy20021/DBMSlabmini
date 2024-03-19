<?php
include '../includes/connection.php';
include '../includes/sidebar.php';



if (isset($_GET['action']) &&  $_GET['action'] == 'delete') {
    
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = 'DELETE FROM employee WHERE EMPLOYEE_ID = ' . $_GET['id'];
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                ?>
                <script type="text/javascript">
                    alert("Employee Successfully Deleted.");
                    window.location = "employee.php";
                </script>
                <?php
            } else {
                echo "Employee ID is not specified.";
            }
           
    }else{ 
        echo "Invalid action.";
    }

?>
