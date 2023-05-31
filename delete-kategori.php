<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Kategori</title>
</head>
<body>
    <?php
        include("config.php");
        if(isset($_GET['id'])){
            $id_kategori = $_GET['id'];
            $sql = "DELETE FROM kategori WHERE id_kategori= '$id_kategori'";
            $query = mysqli_query($connect, $sql);
            if($query){
                header('Location: kategori-obat.php');
            }
        }
    ?>
</body>
</html>