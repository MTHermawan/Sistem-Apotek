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
            $id_karyawan = $_GET['id'];
            $sql = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";
            $query = mysqli_query($connect, $sql);
            if($query){
                header('Location: karyawan.php');
            }
        }
    ?>
</body>
</html>