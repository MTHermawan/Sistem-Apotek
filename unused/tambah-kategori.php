<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex">
<?php include("sidebar.php") ?>
    <div class="table">    
        <h1>Tambah Kategori</h1>
        <br>
        <form method="post">
            <table>
                <tr>
                    <td><label for="nama">ID Kategori: </label></td>
                    <td><input type="text" name="id_kategori" id="id_kategori" placeholder="0001"></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Kategori: </label></td>
                    <td><input type="text" name="nama_kategori" id="nama_kategori" placeholder="Obat Bebas"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit"></td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    include("config.php");
    if(isset($_POST['submit'])){
        $id = $_POST['id_kategori'];
        $nama = $_POST['nama_kategori'];
        $query = mysqli_query($connect, "INSERT INTO kategori (id_kategori, nama_kategori) VALUES ('$id', '$nama')");
        if($query){
            header('Location: kategori-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>