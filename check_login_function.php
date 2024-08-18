<?php
function generateCheck($admin_level)
{
    // Check if admin_level is neither 'A' nor 'E'
    if ($admin_level !== 'A' && $admin_level !== 'E') {
        header("Location: datasystem-login.php");
        exit();
    }

}
?>
