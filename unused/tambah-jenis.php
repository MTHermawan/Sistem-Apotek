<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jenis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php") ?>
    <div class="table">
        <h1>Tambah Jenis</h1>
        <br>
        <form>
            <table>
                <tr>
                    <td><label for="nama">ID Jenis: </label></td>
                    <td><input type="text" name="id_jenis" id="id_jenis" placeholder="0001"></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Jenis: </label></td>
                    <td><input type="text" name="nama_jenis" id="nama_jenis" placeholder="Tablet"></td>
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
        $id = $_POST['id_jenis'];
        $nama = $_POST['nama_jenis'];
        $query = mysqli_query($connect, "INSERT INTO jenis (id_jenis, nama_jenis) VALUES ('$id', '$nama')");
        if($query){
            header('Location: jenis-obat.php');
        }else{
            echo "Gagal";
        }
    }
    ?>
</body>
</html>