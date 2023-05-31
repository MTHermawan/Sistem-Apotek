<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jenis</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php
    include("config.php");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($connect, "SELECT * FROM jenis WHERE id_jenis='$id'");
        if ($data = mysqli_fetch_array($query)) {
            $id = $data['id_jenis'];
            $nama = $data['nama_jenis'];
        }
    }
    ?>

    <?php include("sidebar.php") ?>
    <div id="content-top-bar">
        <?php include("top-bar.php") ?>
        <div class="content">
            <div class="table">
                <h1>Edit Jenis</h1>
                <form>
                    <table>
                        <tr>
                            <td><label for="nama">ID Jenis: </label></td>
                            <td><input type="text" name="id_jenis" id="id_jenis" value="<?php echo $id ?>" disabled></td>
                            <td><input type="text" name="id_jenis" id="id_jenis" value="<?php echo $id ?>" hidden></td>
                        </tr>
                        <tr>
                            <td><label for="nama">Nama Jenis: </label></td>
                            <td><input type="text" name="nama_jenis" id="nama_jenis" value="<?php echo $nama ?>"></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="submit" class="submit" required>Perbarui</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $nama = $_POST['nama_jenis'];
        $query = mysqli_query($connect, "UPDATE jenis SET nama_jenis='$nama' WHERE id_jenis='$id'");
        if($query){
            header('Location: jenis-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>