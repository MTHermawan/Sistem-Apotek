<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Jenis</title>
</head>
<body>
    <?php
        include("config.php");
        if(isset($_GET['id'])){
            $id_jenis = $_GET['id'];
            $sql = "DELETE FROM jenis WHERE id_jenis= '$id_jenis'";
            $query = mysqli_query($connect, $sql);
            if($query){
                echo "<script>window.location.href='jenis.php';</script>";
            }
        }
    ?>
</body>
</html>