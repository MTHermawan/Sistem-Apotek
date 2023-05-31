<?php

include("config.php");
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
    $query = mysqli_query($connect, $sql);
    if($query){
        header('Location: transaksi.php');
    }
}
?>