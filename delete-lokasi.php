<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Lokasi</title>
</head>
<body>
    <?php
        include("config.php");
        if(isset($_GET['id'])){
            $id_lokasi = $_GET['id'];
            $sql = "DELETE FROM lokasi WHERE id_lokasi= '$id_lokasi'";
            $query = mysqli_query($connect, $sql);
            if($query){
                header('Location: lokasi-obat.php');
            }
        }
    ?>
</body>
</html>