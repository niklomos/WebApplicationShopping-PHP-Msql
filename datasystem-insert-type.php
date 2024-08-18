<?php
// Create database connection
include_once 'config.php';
// If upload button is clicked ...
if (isset($_POST['upload'])) {
  // Get image name
  $image = $_FILES['image']['name'];
  // Get text
  $type_name = mysqli_real_escape_string($conn, $_POST['type_name']);

  $sql = "INSERT INTO type (type_name) VALUES ('$type_name')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "เพิ่มข้อมูลสำเร็จ",
            icon: "success"
          }).then(function(result) {
            window.location = "datasystem-manage-type.php";
          });
        });
      </script>';
  } else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "เพิ่มข้อมูลไม่สำเร็จ",
            text: "' . mysqli_error($conn) . '",
            icon: "error"
          }).then(function(result) {
            window.location = "datasystem-insert-type.php";
          });
        });
      </script>';
  }
}
$result = mysqli_query($conn, "SELECT * FROM product");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INSERT-TYPE</title>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <?php
  include_once 'includeCSS.php';
  include_once 'includeJS.php';
  includeJS();
  includeCSS();
  include_once 'navbar_function.php';
  include_once 'sidebar_function.php';
  session_start();

  // เช็คว่ามี session 'admin_id' หรือไม่
  if (isset($_SESSION['admin_id'])) {
    // ดึงค่า admin_id จาก session
    $admin_id = $_SESSION['admin_id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $querynew = "SELECT * FROM employee WHERE id = $admin_id";
    $resultnew = $conn->query($querynew);

    if ($resultnew->num_rows > 0) {
      $rownew = $resultnew->fetch_assoc();
      $username = $rownew['username'];
      $admin_level = $rownew['level'];
    }
  }
  include_once 'check_login_function.php';
  echo generateCheck($admin_level);
  echo generateNavbar();
  echo generateSidebar($username, $admin_level);
  ?>
  <div class="wrapper">
    <div class="content-wrapper">
      <div class="container pt-3">
        <div class="card ">
          <div class="card-header " style="background-color:#2C3E50">
            <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-plus me-2"></i>INSERT-TYPE OF PRODUCT</h2>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="size" value="1000000" class="form-control">
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ประเภทสินค้า</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="type_name" value="" required>
              </div>
              <button type="submit" name="upload" class="btn btn-primary ">
                <i class="fas fa-plus"></i> เพิ่มข้อมูล
              </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  </form>
  </div>
</body>

</html>