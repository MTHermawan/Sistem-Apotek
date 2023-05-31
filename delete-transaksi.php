<?php

include("config.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
    $query = mysqli_query($connect, $sql);
    if($query){
        echo "<script>window.location.href='transaksi.php';</script>";
    }
}
?>