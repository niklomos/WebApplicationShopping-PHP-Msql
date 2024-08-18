<?php 

require('config.php');
$id=$_GET["idemp"];

$sql="DELETE FROM report_allorder WHERE id=$id";
$result=mysqli_query($conn,$sql);

if($result)
{
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit(0);
}
else
{
    echo mysqli_error($conn);
}

?>