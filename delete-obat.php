<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Obat</title>
</head>
<body>
    <?php
        include("config.php");
        if(isset($_GET['id'])){
            $id_obat = $_GET['id'];
            $sql = "DELETE FROM obat WHERE id_obat= '$id_obat'";
            $query = mysqli_query($connect, $sql);
            if($query){
                echo "<script>window.location.href='obat.php';</script>";
            }
        }
    ?>
</body>
</html>