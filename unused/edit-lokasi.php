<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php
    include("config.php");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($connect, "SELECT * FROM lokasi WHERE id_lokasi='$id'");
        $data = mysqli_fetch_array($query);
    }
    ?>

    <?php include("sidebar.php") ?>
    <div class="table">
        <h1>Edit Lokasi</h1>
        <form>
            <table>
                <tr>
                    <td><label for="nama">ID Lokasi: </label></td>
                    <td><input type="text" name="id_lokasi" id="id_lokasi" value="<?php echo $data['id_lokasi'] ?>" disabled></td>
                    <td><input type="text" name="id_lokasi" id="id_lokasi" value="<?php echo $data['id_lokasi'] ?>" hidden></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Lokasi: </label></td>
                    <td><input type="text" name="nama_lokasi" id="nama_lokasi" value="<?php echo $data['nama_lokasi'] ?>"></td>
                </tr>
                <tr>
                    <td><button type="submit" name="submit" class="submit" required>Perbarui</button></td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $id = $_POST['id_lokasi'];
        $nama = $_POST['nama_lokasi'];
        $query = mysqli_query($connect, "UPDATE lokasi SET nama_lokasi='$nama' WHERE id_lokasi='$id'");
        if($query){
            header('Location: lokasi-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>