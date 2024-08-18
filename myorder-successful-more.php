<?php
include_once 'config.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $id = $_GET["id"];

  // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
  $query = "SELECT * FROM register WHERE id = $user_id";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username_user = $row['username'];

    // Query เพื่อดึงข้อมูลจากตาราง orders
    $sql = "SELECT * FROM report_successful_order WHERE id= $id AND username = '$username_user'";
    $result_orders = $conn->query($sql);


?>
    <!DOCTYPE html>
    <html lang="th">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- เรียกใช้ Bootstrap CSS -->
      <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/bootstrap.min.css">
      <script src="./js/bootstrap.min.js"></script>
      <!-- เรียกใช้ FontAwesome CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
      <link rel="stylesheet" href="./style-index.css">
      <title>คำสั่งซื้อสำเร็จ</title>
      <style>
        /* ปรับแต่ง CSS เพื่อให้ table ที่แสดงผล responsive สำหรับอุปกรณ์ที่มีขนาดเล็กลง */
        table {
          width: 100%;
          margin-bottom: 1rem;
          color: #212529;
          border-collapse: collapse;
          border-spacing: 0;
        }

        th,
        td {
          padding: 0.75rem;
          vertical-align: top;
          border-top: 1px solid #dee2e6;
        }

        tbody tr:nth-of-type(even) {
          background-color: rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 767.98px) {
          table {
            overflow-x: auto;
            display: block;
          }
        }
      </style>
    </head>

    <body>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark  nav-search">
        <a class="navbar-brand text-white" href="index.php">BSRU SHOP</a>

        <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
        <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbar1">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar1" class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="index.php" class="nav-link text-light"><i class="fas fa-user mr-2"></i><?php echo $username_user; ?></a>
            </li>
            <li class="nav-item">
              <a href="address.php" class="nav-link text-light"><i class="fas fa-map-marker-alt mr-2"></i>ที่อยู่</a>
            </li>
            <li class="nav-item ">
              <a href="cart.php" class="nav-link text-light"><i class="fa-solid fa-cart-plus mr-2"></i>ตะกร้า</a>
            </li>
            <li class="nav-item ">
              <a href="myorder-check.php" class="nav-link text-light">
                <i class="fa-solid fa-truck-fast mr-2"></i>คำสั่งซื้อ
              </a>
            </li>
            <li class="nav-item dropdown">
              <button class="btn  text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cog text-light" aria-hidden="true"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-dark btn-color text-light">
                <li><a class="dropdown-item" href="manage-personal.php">จัดการข้อมูลส่วนตัว<i class="fa-solid fa-user-pen ms-1"></i></a></li>
                <li><a class="dropdown-item" href="myorder-successful.php">การซื้อของฉัน<i class="fa-brands fa-shopify ms-1"></i></a></li>
                <li><a class="dropdown-item " href="favorite.php">รายการโปรด<i class="fa-solid fa-heart ms-1"></i></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container mt-5">
        <?php
        if ($result_orders->num_rows > 0) {
          // Loop เพื่อแสดงข้อมูล
          while ($row = $result_orders->fetch_assoc()) {
        ?>
            <div>
              <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><i class="fa-solid fa-truck-fast me-1"></i><b>สถานะการจัดส่ง</b></a>
              <div class="card mb-3 border-dark b-product" style="width: 100%">
                <div class="card-body">
                  <h6>บริษัทขนส่ง: <?php echo $row['delivery_name']; ?></h6>
                  <h6>เลขพัสดุ:<?php echo $row['delivery_number']; ?></h6>
                  <h6 class="text-success">*พัสดุถูกจัดส่งสำเร็จแล้ว</h6>
                  <h6><?php echo $row['sucessful_at']; ?></h6>
                </div>
              </div>
            </div>
            <div>
              <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><i class="fa-solid fa-location-dot me-2"></i><b>ที่อยู่ในการจัดส่ง</b></a>
              <div class="card mb-3 border-dark b-product" style="width: 100%">
                <div class="card-body">
                  <h6><?php echo $row['full_name']; ?></h6>
                  <h6><?php echo $row['phone']; ?></h6>
                  <h6><?php echo $row['address']; ?></h6>
                </div>
              </div>
            </div>
            <a href="# " class=" btn btn-color text-light rounded-pill mb-3 b-product" style="width:12rem"><i class="fa-solid fa-cart-plus me-2"></i><b>รายการสั่งซื้อ</b></a>

            <div class="card mb-3 border-dark b-product" style="width: 100%">
              <div class="card-body">
                <div class="row">
                  <?php
                  // Extract product names from the 'product_name' column
                  $product_name1 = $row['product_name'];
                  $product_names = explode(",", $product_name1);

                  // Initialize an empty array to store product data
                  $products = [];

                  // Create a comma-separated string of product names for the SQL query
                  $product_names_string = implode("', '", $product_names);

                  // Fetch product data for all product names in one query
                  $sql = "SELECT * FROM product WHERE product_name IN ('$product_names_string')";
                  $result = mysqli_query($conn, $sql);

                  // Check if any product data is returned
                  if (mysqli_num_rows($result) > 0) {
                    // Store product data in the $products array
                    while ($product_data = mysqli_fetch_assoc($result)) {
                      $products[] = $product_data;
                    }
                  }

                  if ($row1) { ?>
                    <div class="d-grid gap-2">
                      <a href="product.php?id=<?php echo $row1['id']; ?>" class="btn btn-primary b-product" type="button">ซื้ออีกครั้ง</a>
                    </div>
                  <?php } else { ?>
                    <div class="d-flex">

                      <table class="table">
                        <thead>
                        </thead>
                        <tbody>
                          <tr>
                            <?php foreach ($products as $product) {
                              if ($product['product_images']) {
                                $productImageSource = "images/" . $product['product_images'];

                                if (file_exists($productImageSource)) { ?>


                                  <td> <?php echo '<img src="' . $productImageSource . '" alt="" class="card-img" style="width:12rem;">'; ?> </td>



                            <?php  }
                              }
                            }
                            ?>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  <?php } ?>
                  <div class="col-md-6 mt-5">

                    <h6>สินค้า: <?php echo $row['product_name']; ?></h6>
                    <h6>จำนวน: <?php echo $row['product_quantity']; ?> ชิ้น</h6>
                    <h6>ราคา: <?php echo $row['product_price']; ?> บาท</h6>
                    <h6>รวมการสั่งซื้อ: <?php echo number_format($row['total_product_price'], 2); ?> บาท</h6>

                  </div>
                </div>
              </div>
            </div>
            <div class="card mb-3 border-dark b-product" style="width: 100%">
              <div class="card-body">

                <div>
                  <h6><b>หมายเลขคำสั่งซื้อ: <?php echo $row['order_number']; ?></b></h6>
                  <h6>เวลาที่สั่งซื้อ: <?php echo $row['created_at']; ?> </h6>
                  <h6>เวลาส่งสินค้า: <?php echo $row['delivery_at']; ?> </h6>
                  <h6>เวลาที่คำสั่งซื้อสำเร็จ: <?php echo $row['sucessful_at']; ?> </h6>
                </div>
              </div>
            </div>

            <?php
            $product_name1 = $row['product_name'];
            $product_name2 = explode(",", $row['product_name']);

            $products = array();

            // Fetch all product details in a single query
            $sql2 = "SELECT * FROM product WHERE product_name IN ('" . implode("','", $product_name2) . "')";
            $result = mysqli_query($conn, $sql2);

            while ($product_row = mysqli_fetch_assoc($result)) {
              $products[] = $product_row;
            }

            if ($row1) { ?>
              <div class="d-grid gap-2">
                <a href="product.php?id=<?php echo $row1['id']; ?>" class="btn btn-primary b-product" type="button">ซื้ออีกครั้ง</a>
              </div>
            <?php } else { ?>
              <div class="d-grid gap-2">
                <?php foreach ($products as $product) { ?>
                  <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary me-3 b-product" type="button">ซื้ออีกครั้ง: <?php echo $product['product_name']; ?></a>
                <?php } ?>
              </div>
            <?php } ?>

        <?php
          }
        } else {
          echo "ไม่พบข้อมูล";
        }
        $conn->close();
        ?>

      </div>
    </body>

    </html>
<?php
  }
}
?>


</body>

</html>