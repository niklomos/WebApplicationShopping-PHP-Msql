<?php
function generateNavbar()
{
    $navbar = '<nav class="main-header navbar navbar-expand  navbar-dark fixed-top">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto me-2">
            <a href="datasystem-logout.php" class=" btn btn-outline-danger " style="border-width: 2px; ">
                <i class=" fa-solid fa-right-from-bracket "></i>
                Logout
            </a>
            
        </ul>
            ';

    $navbar .= '</nav>';
    return $navbar;
}
?>
