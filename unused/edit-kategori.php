<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php
    include("config.php");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($connect, "SELECT * FROM kategori WHERE id_kategori='$id'");
        $data = mysqli_fetch_array($query);
    }
    ?>

    <?php include("sidebar.php"); ?>
    <div class="table">
        <h1>Edit Kategori</h1>
        <form>
            <table>
                <tr>
                    <td><label for="nama">ID Kategori: </label></td>
                    <td><input type="text" name="id_kategori" id="id_kategori" value="<?php echo $data['id_kategori'] ?>" disabled></td>
                    <td><input type="text" name="id_kategori" id="id_kategori" value="<?php echo $data['id_kategori'] ?>" hidden></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Kategori: </label></td>
                    <td><input type="text" name="nama_kategori" id="nama_kategori" value="<?php echo $data['nama_kategori'] ?>"></td>
                </tr>
                <tr>
                    <td><button type="submit" name="submit" class="submit" required>Perbarui</button></td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $id = $_POST['id_kategori'];
        $nama = $_POST['nama_kategori'];
        $query = mysqli_query($connect, "UPDATE kategori SET nama_kategori='$nama' WHERE id_kategori='$id'");
        if($query){
            header('Location: kategori-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>