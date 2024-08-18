<?php 

require('config.php');
$id=$_GET["idemp"];

$sql="DELETE FROM favorite WHERE id=$id";
$result=mysqli_query($conn,$sql);

if($result)
{
    header("location:favorite.php");
    exit(0);
}
else
{
    echo mysqli_error($conn);
}

?>