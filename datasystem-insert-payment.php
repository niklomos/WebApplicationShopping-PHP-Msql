<?php
// Create database connection
include_once 'config.php';
// Initialize message variable
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {
  // Get image name
  $image = $_FILES['image']['name'];
  // Get text
  $account_name = mysqli_real_escape_string($conn, $_POST['account_name']);
  $account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
  $status = 'disabled';


  // image file directory
  $target = "images/" . basename($image);

  $sql = "INSERT INTO payment (images, account_name, account_number,status) VALUES ('$image','$account_name','$account_number','$status')";
  // execute query
  mysqli_query($conn, $sql);

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "เพิ่มข้อมูลสำเร็จ",
            icon: "success"
          }).then(function(result) {
            window.location = "datasystem-manage-payment.php";
          });
        });
      </script>';
  } else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          title: "เพิ่มข้อมูลไม่สำเร็จ",
          icon: "error"
        }).then(function(result) {
          window.location = "datasystem-insert-payment.php";
        });
      });
    </script>';    
  }
}
$result = mysqli_query($conn, "SELECT * FROM payment");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INSERT-PAYMENT</title>
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
    <div class="content-wrapper">
    <div class="container pt-3">
        <div class="card ">
          <div class="card-header " style="background-color:#2C3E50">
            <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-plus me-2"></i>INSERT-PAYMENT</h2>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="size" value="1000000" class="form-control">
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>เลือกไฟล์ภาพ</b></span>
                <input type="file" class="form-control " placeholder="" aria-label="images" aria-describedby="basic-addon1" name="image" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>ชื่อธนาคาร</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="account_name" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>ชื่อเลขบัญชี</b></span>
                <input type="text" class="form-control " placeholder="" aria-label="name" aria-describedby="basic-addon1" name="account_number" value="" required>
              </div>
              <button type="submit" name="upload" class="btn btn-primary b">
                <i class="fas fa-plus"></i> เพิ่มข้อมูล
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>