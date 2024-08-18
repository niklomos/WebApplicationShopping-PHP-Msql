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
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $detail = mysqli_real_escape_string($conn, $_POST['detail']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $amount = mysqli_real_escape_string($conn, $_POST['amount']);

  $type_name = mysqli_real_escape_string($conn, $_POST['type']);

  $sql_type = "SELECT id FROM type WHERE type_name = '$type_name' ";
  $result_type =  mysqli_query($conn, $sql_type);
  $row_type = mysqli_fetch_object($result_type);

  $type_id = $row_type->id;

  // image file directory
  $target = "images/" . basename($image);

  $sql = "INSERT INTO product (product_images,product_name,product_title,product_detail,product_price,product_amount,type_name,typ_id) VALUES ('$image','$name','$title','$detail','$price','$amount','$type_name','$type_id')";
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
            window.location = "datasystem-manage-product.php";
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
          window.location = "datasystem-insert-product.php";
        });
      });
    </script>';
  }
}

$result = mysqli_query($conn, "SELECT * FROM product");

$type_query = mysqli_query($conn, "SELECT type_name FROM type");
$types = mysqli_fetch_all($type_query, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INSERT-PRODUCT</title>
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
            <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-plus me-2"></i>INSERT-PRODUCT</h2>
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="size" value="1000000" class="form-control">
              <div class="input-group mb-3">
                <img class="image-preview border border-1 border-dark"  alt="" width="250px" style="border:3px white solid">
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลือกไฟล์ภาพ</b></span>
                <input type="file" class="form-control ip" placeholder="" aria-label="images" aria-describedby="basic-addon1" name="image" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อสินค้า</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="name" value="" required>
              </div>
              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>คำอธิบายสินค้า</b></span>
                <input type="text" class="form-control ip" placeholder="" aria-label="name" aria-describedby="basic-addon1" name="title" value="" required>
              </div>

              <div class="input-group mb-3 col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>ประเภทสินค้า</b></span>
                <select class="form-control select2bs4" id="typeSelect" name="type" style="width: 30%;" aria-describedby="basic-addon1">
                  <option selected>เลือกประเภทสินค้า......</option>
                  <?php foreach ($types as $type) : ?>
                    <option value="<?php echo $type['type_name']; ?>"><?php echo $type['type_name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group  col-sm12">
                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>รายละเอียด</b></span>
                <textarea type="text" name="detail" id="detail" class="form-control " style="height: 200px;" required></textarea>
              </div>

              <div class="input-group mb-3 col-sm12 mt-4">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคา</b></span>
                <input type="number" class="form-control ip" placeholder="" aria-label="placename" aria-describedby="basic-addon1" name="price" value="" required min="0">
              </div>
              <div class="input-group mb-3 col-sm12 mt-4">
                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>จำนวน</b></span>
                <input type="number" class="form-control ip" placeholder="" aria-label="placename" aria-describedby="basic-addon1" name="amount" value="" required min="0">
              </div>

              <div>
                <button type="submit" name="upload" class="btn btn-primary ">
                  <i class="fas fa-plus"></i> เพิ่มข้อมูล
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

    })
  </script>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="file"]').change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
        });
    });
</script>
</html>