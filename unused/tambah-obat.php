<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php") ?>
        <div class="table">
            <h1>Tambah Obat</h1>
            <br>
            <form action="tambah-obat.php" method="post">
                <table>
                    <tr>
                        <td><label for="id">ID Obat</label></td>
                        <td><input type="text" name="id" id="id" placeholder="0001"></td>
                    </tr>
                    <tr>
                        <td><label for="nama">Nama Obat: </label></td>
                        <td><input type="text" name="nama" id="nama" placeholder="Paracetamol"></td>
                    </tr>
                    <tr>
                        <td><label for="jenis">Jenis Obat: </label></td>
                        <td>
                            <select name="jenis" id="jenis">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM jenis");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_jenis'] ?>"><?php echo $data['nama_jenis'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="kategori">Kategori Obat: </label></td>
                        <td>
                            <select name="kategori" id="kategori">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM kategori");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lokasi">Lokasi Obat: </label></td>
                        <td>
                            <select name="lokasi" id="lokasi">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM lokasi");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_lokasi'] ?>"><?php echo $data['nama_lokasi'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="harga">Harga Obat: </label></td>
                        <td><input type="text" name="harga" id="harga" placeholder="10"></td>
                    </tr>
                    <tr>
                        <td><label for="stok">Stok Obat: </label></td>
                        <td><input type="text" name="stok" id="stok" placeholder="10"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="submit" id="submit"></td>
                    </tr>
                </table>
        </div>
                <?php
                include ("config.php");

                if (isset($_POST['submit'])) {
                    $id = $_POST['id'];
                    $nama = $_POST['nama'];
                    $jenis = $_POST['jenis'];
                    $kategori = $_POST['kategori'];
                    $lokasi = $_POST['lokasi'];
                    $harga = $_POST['harga'];
                    $stok = $_POST['stok'];

                    $query = mysqli_query($connect, "INSERT INTO obat VALUES ('$id', '$nama', (SELECT id_jenis FROM jenis WHERE nama_jenis = '$jenis'), (SELECT id_kategori FROM kategori WHERE nama_kategori = '$kategori'), (SELECT id_lokasi FROM lokasi WHERE nama_lokasi = '$lokasi'), '$stok', '$harga')");
                    if ($query) {
                        header("Location: obat.php");
                    } else {
                        echo "Gagal";
                    }
                }
                ?>
    </form>
</body>
</html>