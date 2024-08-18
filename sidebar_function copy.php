<?php

function isMenuItemActive($pages)
{
    foreach ($pages as $page) {
        if (basename($_SERVER['PHP_SELF']) === $page) {
            return 'active';
        }
    }
    return '';
}

function isSubMenuOpen($pages)
{
    foreach ($pages as $page) {
        if (basename($_SERVER['PHP_SELF']) === $page) {
            return 'menu-open';
        }
    }
    return '';
}
function PagesOpenAndActive1()
{
    return [
        'datasystem-manage-type.php',
        'datasystem-manage-product.php',
        'datasystem-manage-payment.php',
        'datasystem-manage-employee.php',
        'datasystem-manage-member.php',
        'datasystem-insert-type.php',
        'datasystem-edit-type.php',
        'datasystem-insert-product.php',
        'datasystem-edit-product.php',
        'datasystem-insert-payment.php',
        'datasystem-edit-payment.php',
        'datasystem-insert-employee.php',
        'datasystem-edit-employee.php',
        'datasystem-edit-member.php'
    ];
}
function PagesType()
{
    return [
        'datasystem-manage-type.php',
        'datasystem-insert-type.php',
        'datasystem-edit-type.php'
    ];
}
function 
PagesProduct()
{
    return [
        'datasystem-manage-product.php',
        'datasystem-insert-product.php',
        'datasystem-edit-product.php'
    ];
}
function PagesPayment()
{
    return [
        'datasystem-manage-payment.php',
        'datasystem-insert-payment.php',
        'datasystem-edit-payment.php'
    ];
}
function PagesEmployee()
{
    return [
        'datasystem-manage-employee.php',
        'datasystem-insert-employee.php',
        'datasystem-edit-employee.php'
    ];
}
function PagesMember()
{
    return [
        'datasystem-manage-member.php',
        'datasystem-edit-member.php'
    ];
}

function PagesOpenAndActive2()
{
    return [
        'datasystem-show-order.php',
        'datasystem-show-order-cart.php',
        'datasystem-manage-delivery.php',
        'datasystem-edit-delivery.php',
        'datasystem-edit-delivery2.php'

    ];
}
function PagesOrder()
{
    return [
        'datasystem-show-order.php',
        'datasystem-edit-delivery.php'
    ];
}
function PagesOrderCart()
{
    return [
        'datasystem-show-order-cart.php',
        'datasystem-edit-delivery2.php'
    ];
}
function PagesDelivery()
{
    return [
        'datasystem-manage-delivery.php'
    ];
}
function PagesOpenAndActive3()
{
    return [
        'datasystem-report-order.php',
        'datasystem-report-order-successful.php',
        'datasystem-report-sales.php',
        'datasystem-report-order-detail.php',
        'datasystem-report-order-successful-detail.php'
    ];
}
function PagesReportOrder()
{
    return [
        'datasystem-report-order.php',
        'datasystem-report-order-detail.php'
    ];
}
function PagesReportSuccessful()
{
    return [
        'datasystem-report-order-successful.php',
        'datasystem-report-order-successful-detail.php'
    ];
}
function PagesReportSale()
{
    return [
        'datasystem-report-sales.php'
    ];
}

function PagesOrder2()
{
    return [
        'datasystem-show-order.php',
        'datasystem-edit-delivery.php'
    ];
}
function PagesOrderCart2()
{
    return [
        'datasystem-show-order-cart.php',
        'datasystem-edit-delivery2.php'
    ];
}
function PagesDelivery2()
{
    return [
        'datasystem-manage-delivery.php'
    ];
}

function PagesReportOrder2()
{
    return [
        'datasystem-report-order.php',
        'datasystem-report-order-detail.php'
    ];
}
function PagesReportSuccessful2()
{
    return [
        'datasystem-report-order-successful.php',
        'datasystem-report-order-successful-detail.php'
    ];
}
function PagesReportSale2()
{
    return [
        'datasystem-report-sales.php'
    ];
}

function generateSidebar($username, $admin_level)
{

    global $conn;
    $sidebar = '';
    

    //เรียกใช้คำสั่ง SQL ในการดึงข้อมูลจากฐานข้อมูล
    $query = "SELECT COUNT(*) as total_orders FROM orders";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_orders = $row['total_orders'];
    } else {
        $total_orders = 0; //กำหนดค่าให้กับตัวแปรเพื่อจะแสดงผลให้ถูกต้อง
    }

    //เรียกใช้คำสั่ง SQL ในการดึงข้อมูลจากฐานข้อมูล
    $query2 = "SELECT COUNT(*) as total_orders_cart FROM orders_cart";
    $result2 = $conn->query($query2);

    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $total_orders_cart = $row2['total_orders_cart'];
    } else {
        $total_orders_cart = 0; //กำหนดค่าให้กับตัวแปรเพื่อจะแสดงผลให้ถูกต้อง
    }

    //เรียกใช้คำสั่ง SQL ในการดึงข้อมูลจากฐานข้อมูล
    $query3 = "SELECT COUNT(*) as total_delivery FROM delivery";
    $result3 = $conn->query($query3);

    if ($result3->num_rows > 0) {
        $row3 = $result3->fetch_assoc();
        $total_delivery = $row3['total_delivery'];
    } else {
        $total_delivery = 0; //กำหนดค่าให้กับตัวแปรเพื่อจะแสดงผลให้ถูกต้อง
    }
    $sidebar = '';
    if ($admin_level === 'A') {

        $sidebar .= ' <aside class="main-sidebar sidebar-dark-primary elevation-4 Layout-fixed" >
        <!-- Brand Logo -->
        <a href="#"class="brand-link text-decoration-none">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light font-weight-bold text-decoration-none">SHOPPING-SYSTEM</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">';
        $sidebar .= '<a href="#" class="d-block  text-warning text-decoration-none">' . $username . '</a>';
        $sidebar .= '</div>
            </div>

         

            <!-- Sidebar Menu -->
            <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
            <a href="datasystem.php" class="nav-link ' . (basename($_SERVER['PHP_SELF']) == 'datasystem.php' ? 'active' : '') . '">
            <i class="nav-icon fas fa-home  ml-1"></i>
            <p class="ml-1"> หน้าแรก </p>
            </a>
            </li>';
        // Call isMenuItemActive and isSubMenuOpen directly within the HTML
        $sidebar .= '
        <li class="nav-item ' . isSubMenuOpen(PagesOpenAndActive1()) . '">
        <a href="#" class="nav-link ' . isMenuItemActive(PagesOpenAndActive1()) . '">
                <i class="nav-icon fa-solid fa-sliders"></i>
                   
                    <p>
                        การจัดการ
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul  class="nav nav-treeview">
                <li class="nav-item">
                <a href="datasystem-manage-type.php" class="nav-link ' . isMenuItemActive(PagesType()) . '">
                <i class="far fa-circle nav-icon"></i>
                <p>จัดการประเภทสินค้า</p>
            </a>

                    </li>
                <li class="nav-item">
                <a href="datasystem-manage-product.php" class="nav-link ' . isMenuItemActive(PagesProduct()) . '">
                <i class="far fa-circle nav-icon"></i>
                <p>จัดการสินค้า</p>
            </a>
                    </li>
                <li class="nav-item">
                <a href="datasystem-manage-payment.php" class="nav-link ' . isMenuItemActive(PagesPayment()) . '">
                <i class="far fa-circle nav-icon"></i>
                            <p>จัดการบัญชีธนาคาร</p>
                        </a>
                    </li>
                <li class="nav-item">
                <a href="datasystem-manage-employee.php" class="nav-link ' . isMenuItemActive(PagesEmployee()) . '">
                <i class="far fa-circle nav-icon"></i>
                            <p>จัดการข้อมูลพนักงาน</p>
                        </a>
                    </li>
                <li class="nav-item">
                <a href="datasystem-manage-member.php" class="nav-link ' . isMenuItemActive(PagesMember()) . '">
                <i class="far fa-circle nav-icon"></i>
                <p>จัดการสมาชิก</p>
            </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item ' . isSubMenuOpen(PagesOpenAndActive2()) . '" >
                <a href="#" class="nav-link ' . isMenuItemActive(PagesOpenAndActive2()) . '">
                <i class="nav-icon fa-solid fa-cart-plus"></i>
                    
                    <p>
                        จัดการคำสั่งซื้อ
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul  class="nav nav-treeview">
                <li class="nav-item">
        <a href="datasystem-show-order.php" class="nav-link ' . isMenuItemActive(PagesOrder()) . ' ">
        <i class="far fa-circle nav-icon"></i>
        <p>รายการสั่งซื้อ</p>';
        if ($total_orders > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_orders . '</span>';
        }
        $sidebar .= '</a>
       </li>

                <li class="nav-item">
                        <a href="datasystem-show-order-cart.php" class="nav-link ' . isMenuItemActive(PagesOrderCart()) . ' ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายการสั่งซื้อตะกร้า</p>';
        if ($total_orders_cart > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_orders_cart . '</span>';
        }
        $sidebar .= '</a>
                          
                    </li>
                <li class="nav-item">
                        <a href="datasystem-manage-delivery.php" class="nav-link ' . isMenuItemActive(PagesDelivery()) . ' ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>รายการจัดส่ง</p>';
        if ($total_delivery > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_delivery . '</span>';
        }
        $sidebar .= '</a>
                    </li>
                
                </ul>
            </li>
            <li class="nav-item '. isSubMenuOpen(PagesOpenAndActive3()) . '">
                <a href="#" class="nav-link ' . isMenuItemActive(PagesOpenAndActive3()) . '">
                <i class="nav-icon fa-solid fa-file-invoice"></i>
                   
                    <p>
                        รายงาน
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul  class="nav nav-treeview">
                <li class="nav-item">
                        <a href="datasystem-report-order.php" class="nav-link ' . isMenuItemActive(PagesReportOrder()) . '">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ประวัติคำสั่งซื้อ</p>
                        </a>
                    </li>
                <li class="nav-item">
                        <a href="datasystem-report-order-successful.php" class="nav-link ' . isMenuItemActive(PagesReportSuccessful()) . '">
                            <i class="far fa-circle nav-icon"></i>
                            <p>ประวัติคำสั่งซื้อสำเร็จ</p>
                        </a>
                    </li>
                <li class="nav-item">
                        <a href="datasystem-report-sales.php" class="nav-link ' . isMenuItemActive(PagesReportSale()) . ' ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>เช็คยอดขาย</p>
                        </a>
                    </li>
              
                
                </ul>
            </li>
            
            <li class="nav-item">
                <a href="datasystem-logout.php" class="nav-link  text-danger text-bold">
                    <i class=" fa-solid fa-right-from-bracket ml-1"></i>
                    <p class="ml-2"> Logout </p>
                </a>
            </li>
                </ul>
            </nav>
        </div>';

        $sidebar .=
            '</aside>';
    } elseif ($admin_level === 'E') {

        $sidebar .= ' <aside class="main-sidebar sidebar-dark-primary elevation-4" >
                    <!-- Brand Logo -->
                    <a href="#" class="brand-link text-decoration-none">
                        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                        <span class="brand-text font-weight-light font-weight-bold text-decoration-none">SHOPPING-SYSTEM</span>
                    </a>

                    <!-- Sidebar -->
                    <div class="sidebar">
                        <!-- Sidebar user panel (optional) -->
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <img src="dist/img/avatar4.png" class="img-circle elevation-2" alt="User Image">
                            </div>
                            <div class="info">';
        $sidebar .= '<a href="#" class="d-block  text-warning text-decoration-none">' . $username . '</a>';
        $sidebar .= '</div>
                        </div>

                     

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                            <a href="datasystem.php" class="nav-link ' . (basename($_SERVER['PHP_SELF']) == 'datasystem.php' ? 'active' : '') . '">
                            
                                <i class="nav-icon fas fa-home  ml-1"></i>
                                <p class="ml-1"> หน้าแรก </p>
                            </a>
                        </li>
                        <li class="nav-item">
                                    <a href="datasystem-show-order.php" class="nav-link ' . isMenuItemActive(PagesOrder2()) . ' ">
                                    <i class="nav-icon fa-solid fa-cart-plus"></i>
                                        <p>รายการสั่งซื้อ</p>';
        if ($total_orders > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_orders . '</span>';
        }
        $sidebar .= '</a>

                                    </a>
                                </li>
                            <li class="nav-item">
                                    <a href="datasystem-show-order-cart.php" class="nav-link ' . isMenuItemActive(PagesOrderCart2()) . ' ">
                                        <i class="fas fa-shopping-bag nav-icon"></i>
                                        <p>รายการสั่งซื้อตะกร้า</p>';
        if ($total_orders_cart > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_orders_cart . '</span>';
        }
        $sidebar .= '</a>

                                    </a>
                                </li>
                            <li class="nav-item">
                                    <a href="datasystem-manage-delivery.php" class="nav-link ' . isMenuItemActive(PagesDelivery2()) . ' ">
                                    <i class="fa-solid fa-truck-fast nav-icon"></i>
                                        <p>รายการจัดส่ง</p>';
        if ($total_delivery > 0) {
            $sidebar .= '<span class="right badge badge-warning">' . $total_delivery . '</span>';
        }
        $sidebar .= '</a>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="datasystem-report-order.php" class="nav-link ' . isMenuItemActive(PagesReportOrder2()) . '">
                                    <i class="fas fa-print nav-icon"></i>
                                        <p>ประวัติคำสั่งซื้อ</p>
                                    </a>
                                </li>
                            <li class="nav-item">
                                    <a href="datasystem-report-order-successful.php" class="nav-link ' . isMenuItemActive(PagesReportSuccessful2()) . '">
                                        <i class="fas fa-file-invoice nav-icon"></i>
                                        <p>ประวัติคำสั่งซื้อสำเร็จ</p>
                                    </a>
                                </li>
                            <li class="nav-item">
                                    <a href="datasystem-report-sales.php" class="nav-link ' . isMenuItemActive(PagesReportSale2()) . '">
                                    <i class="fas fa-calendar-check nav-icon"></i>
                                        <p>เช็คยอดขาย</p>
                                    </a>
                                </li>
                        
                                <li class="nav-item">
                            <a href="datasystem-logout.php" class="nav-link  text-danger text-bold">
                                <i class=" fa-solid fa-right-from-bracket ml-1"></i>
                                <p class="ml-2"> Logout </p>
                            </a>
                        </li>
                            </ul>
                        </nav>
                    </div>';

        $sidebar .=
            '</aside>';
        } else {
            header("Location: datasystem-login.php");
            exit(); // ออกจากการทำงานของ script
        }
        
    return $sidebar;
}
