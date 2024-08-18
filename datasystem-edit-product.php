<?php
require('config.php');
$id = $_GET["id"];
$page = $_GET["page"];
$search = $_GET["search"];

$sql = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_title = $_POST['product_title'];
    $product_detail = $_POST['product_detail'];
    $product_price = $_POST['product_price'];
    $product_amount = $_POST['product_amount'];
    $type_id = $_POST['typ_id'];

    $sql_type ="SELECT type_name FROM type WHERE id = '$type_id' ";
    $result_type =  mysqli_query($conn, $sql_type);
    $row_type = mysqli_fetch_object( $result_type);
   
    $type_name = $row_type->type_name;


    // Check if a new image file is uploaded
    if ($_FILES['imagenew']['name'] !== '') {
        $image = $_FILES['imagenew']['name'];
        $image_temp = $_FILES['imagenew']['tmp_name'];
        move_uploaded_file($image_temp, "images/$image");
    } else {
        $image = $row['product_images']; // Keep the existing image if no new image is uploaded
    }

    // Update the record in the database
    $update_sql = "UPDATE product SET product_images='$image',product_name='$product_name',product_title='$product_title', product_detail='$product_detail', product_price='$product_price', product_amount='$product_amount', type_name='$type_name', typ_id='$type_id'WHERE id=$id";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลสำเร็จ",
                icon: "success"
              }).then(function() {
                if ("' . $search . '" !== "") {
                    window.location = "datasystem-manage-product.php?search_input=' . $search . '&page=' . $page . '";
                } else {
                    window.location = "datasystem-manage-product.php?page=' . $page . '&search_input=' . $search . '";
                }
              });
            });
          </script>';;
    } else {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              Swal.fire({
                title: "อัปเดตข้อมูลไม่สำเร็จ",
                icon: "error"
              }).then(function() {
                window.location = "datasystem-edit-product.php";
              });
            });
          </script>';
    }
}
$type_query = mysqli_query($conn, "SELECT * FROM type");
$types = mysqli_fetch_all($type_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT-PRODUCT</title>

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
                        <h2 class="text-center text-light  pt-2 "><i class="fa-solid fa-pen-to-square  me-2"></i>EDIT-PRODUCT</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="input-group mb-3 d-none">
                                <div class="input-group-prepend  ">
                                    <span class="input-group-text text-dark ip bg-warning">ID</span>
                                </div>
                                <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" class="form-control  ip">
                            </div>
                            <div class="input-group mb-3">
                                <img class="image-preview border border-1 border-dark" src="images/<?php echo $row['product_images']; ?>" alt="" width="250px" style="border:3px white solid">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลือกไฟล์ภาพ</b></span>
                                <div class="input-group-prepend">

                                </div>
                                <input type="file" class="form-control ip" placeholder="" aria-label="imagenew" aria-describedby="basic-addon1" name="imagenew">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อสินค้า</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="product_name" aria-describedby="basic-addon1" name="product_name" value="<?php echo $row['product_name']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>คำอธิบายสินค้า</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="product_title" aria-describedby="basic-addon1" name="product_title" value="<?php echo $row['product_title']; ?>">
                            </div>
                            <div class="form-group ipdetail ">
                                <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>รายละเอียด</b></span>
                                <textarea type="text" name="product_detail" id="product_detail" class="form-control " style="height: 200px;"><?php echo $row['product_detail']; ?></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคา</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="product_price" aria-describedby="basic-addon1" name="product_price" value="<?php echo  $row['product_price']; ?>">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>จำนวน</b></span>
                                <input type="text" class="form-control ip" placeholder="" aria-label="product_amount" aria-describedby="basic-addon1" name="product_amount" value="<?php echo $row['product_amount']; ?>">
                            </div>
                            <div class="input-group mb-3 col-sm12">
                                <span class="input-group-text bg-dark text-light " ><b>ประเภทสินค้า</b></span>
                                <select class="form-control " id="typeSelect" name="typ_id">
                                    <?php foreach ($types as $type) : ?>
                                        <option  value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="my-3 btn btn-primary " name="update">
                                <i class="fa-solid fa-pen-to-square me-1"></i>
                                อัปเดตข้อมูล</button>
                            <a href="datasystem-manage-product.php" target="" class="my-2 btn btn-danger "><i class="fa-solid fa-circle-notch me-1"></i></i>ยกเลิก</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script>
    // Create an array to store the selected types
    var selectedTypes = <?php echo json_encode($row['typ_id']); ?>;
    
    // Get the select element
    var selectElement = document.getElementById('typeSelect');
    
    // Loop through each option in the select element
    for (var i = 0; i < selectElement.options.length; i++) {
        // Check if the option value is in the selectedTypes array
        if (selectedTypes.includes(selectElement.options[i].value)) {
            // If it is, set the selected attribute for that option
            selectElement.options[i].selected = true;
        }
    }
</script>


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