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
                    <td><label for="nama">ID Lokasi: </label></td>
                    <td><input type="text" name="id_lokasi" id="id_lokasi" placeholder="0001"></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Lokasi: </label></td>
                    <td><input type="text" name="nama_lokasi" id="nama_lokasi" placeholder="Rak 1"></td>
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
        $id = $_POST['id_lokasi'];
        $nama = $_POST['nama_lokasi'];
        $query = mysqli_query($connect, "INSERT INTO lokasi (id_lokasi, nama_lokasi) VALUES ('$id', '$nama')");
        if($query){
            header('Location: lokasi-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>