<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>
    <div class="table">
    <h1>Tambah Lokasi</h1>
    <br>
        <form>
            <table>
                <tr>
                    <td><label for="nama">ID Petugas: </label></td>
                    <td><input type="text" name="id_petugas" id="id_petugas" placeholder="01"></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Petugas: </label></td>
                    <td><input type="text" name="nama_petugas" id="nama_petugas" placeholder="admin"></td>
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
        $id = $_POST['id_petugas'];
        $nama = $_POST['nama_petugas'];
        $query = mysqli_query($connect, "INSERT INTO petugas (id_petugas, nama_petugas) VALUES ('$id', '$nama')");
        if($query){
            header('Location: lokasi-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>