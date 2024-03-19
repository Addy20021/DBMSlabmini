<?php
include '../includes/connection.php';
include '../includes/sidebar.php';

$query = 'SELECT ID, t.TYPE
            FROM users u
            JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

while ($row = mysqli_fetch_assoc($result)) {
    $Aa = $row['TYPE'];
                   
    if ($Aa=='User') {
?>
<script type="text/javascript">
    //then it will be redirected
    alert("Restricted Page! You will be redirected to POS");
    window.location = "pos.php";
</script>
<?php
    }           
}

$sql = "SELECT DISTINCT JOB_TITLE, JOB_ID FROM job ORDER BY JOB_ID ASC";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

$opt = "<select class='form-control' name='jobs'>
        <option>Select Job</option>";
while ($row = mysqli_fetch_assoc($result)) {
    $opt .= "<option value='".$row['JOB_ID']."'>".$row['JOB_TITLE']."</option>";
}

$opt .= "</select>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form submission, handle addition of supplier

    // Sanitize input data to prevent SQL injection
    $companyname = mysqli_real_escape_string($db, $_POST['companyname']);
    $province = mysqli_real_escape_string($db, $_POST['province']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $phonenumber = mysqli_real_escape_string($db, $_POST['phonenumber']);

    // Perform insertion into supplier table
    $query = "INSERT INTO supplier (COMPANY_NAME, PROVINCE, CITY, PHONE_NUMBER)
              VALUES ('$companyname', '$province', '$city', '$phonenumber')";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Insertion successful, now let's trigger the audit log

        $query = "INSERT INTO supplier_audit (supplier_id, action)
                  VALUES (LAST_INSERT_ID(), 'ADD')";
        $result = mysqli_query($db, $query);

        if ($result) {
            // Audit log successfully recorded
            echo "<script>alert('Supplier added successfully.');</script>";
        } else {
            // Error recording audit log
            echo "<script>alert('Error recording audit log.');</script>";
        }
    } else {
        // Error inserting into supplier table
        echo "<script>alert('Error adding supplier.');</script>";
    }
}
?>

<script>
window.onload = function() {  

  // ---------------
  // basic usage
  // ---------------
  var $ = new City();
  $.showProvinces("#province");
  $.showCities("#city");

  // ------------------
  // additional methods 
  // -------------------

  // will return all provinces 
  console.log($.getProvinces());
  
  // will return all cities 
  console.log($.getAllCities());
  
  // will return all cities under specific province (e.g Batangas)
  console.log($.getCities("Batangas")); 
  
}
</script>

<center>
    <div class="card shadow mb-4 col-xs-12 col-md-8 border-bottom-primary">
        <div class="card-header py-3">
            <h4 class="m-2 font-weight-bold text-primary">Add Supplier</h4>
        </div>
        <a href="supplier.php?action=add" type="button" class="btn btn-primary bg-gradient-primary">Back</a>
        <div class="card-body">
            <div class="table-responsive">
                <form role="form" method="post" action="sup_transac.php?action=add">
                    <div class="form-group">
                        <input class="form-control" placeholder="Company Name" name="companyname" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="province" placeholder="Province" name="province" required></select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="city" placeholder="City" name="city" required></select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Phone Number" name="phonenumber" required>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-check fa-fw"></i>Save</button>
                    <button type="reset" class="btn btn-danger btn-block"><i class="fa fa-times fa-fw"></i>Reset</button>
                </form>  
            </div>
        </div>
    </div>
</center>

<?php
include '../includes/footer.php';
?>
