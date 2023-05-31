<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php
    include ("config.php");
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($connect, "SELECT obat.*, jenis.nama_jenis, kategori.nama_kategori, lokasi.nama_lokasi FROM obat JOIN jenis ON obat.jenis_obat = jenis.id_jenis JOIN kategori ON obat.kategori = kategori.id_kategori JOIN lokasi ON obat.lokasi = lokasi.id_lokasi WHERE id_obat='$id'");
        
        if ($data = mysqli_fetch_array($query)) {
            $id = $data['id_obat'];
            $nama = $data['nama_obat'];
            $jenis = $data['nama_jenis'];
            $kategori = $data['nama_kategori'];
            $lokasi = $data['nama_lokasi'];
            $harga = $data['harga'];
            $stok = $data['stok'];
        }
    }
    ?>

    <?php include("sidebar.php") ?>
    <div class="table">
        <h1>Edit Obat</h1>
        <form method="post">
            <table>
                <tr>
                    <td><label for="id">ID Obat</label></td>
                    <td><input type="text" name="id" id="id" placeholder="1" value="<?php echo $id?>" disabled></td>
                    <td><input type="hidden" name="id" id="id" placeholder="1" value="<?php echo $id?>"></td>
                </tr>
                <tr>
                    <td><label for="nama">Nama Obat: </label></td>
                    <td><input type="text" name="nama" id="nama" placeholder="Paracetamol" value="<?php echo $nama?>"></td>
                </tr>
                <tr>
                    <td><label for="jenis">Jenis Obat: </label></td>
                    <td>
                        <select name="jenis" id="jenis">
                            <?php
                            $query = mysqli_query($connect, "SELECT * FROM jenis");
                            while($data = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $data['nama_jenis'] ?>"<?php if ($jenis == $data['nama_jenis']) {echo "selected";} ?>><?php echo $data['nama_jenis'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="jenis">Kategori Obat: </label></td>
                    <td>
                        <select name="kategori" id="kategori">
                            <?php
                            $query = mysqli_query($connect, "SELECT * FROM kategori");
                            while($data = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $data['nama_kategori'] ?>"<?php if ($kategori == $data['nama_kategori']) {echo "selected";} ?>><?php echo $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="lokasi">Lokasi Obat: </label></td>
                    <td>
                        <select name="lokasi" id="lokasi">
                            <?php
                            $query = mysqli_query($connect, "SELECT * FROM lokasi");
                            while($data = mysqli_fetch_array($query)){
                            ?>
                                <option value="<?php echo $data['nama_lokasi'] ?>"<?php if ($lokasi == $data['nama_lokasi']) {echo "selected";} ?>><?php echo $data['nama_lokasi'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="harga">Harga Obat: </label></td>
                    <td><input type="text" name="harga" id="harga" placeholder="10" value="<?php echo $harga?>"></td>
                </tr>
                <tr>
                    <td><label for="stok">Stok Obat: </label></td>
                    <td><input type="text" name="stok" id="stok" placeholder="10" value="<?php echo $stok?>"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" class="submit"></td>
                </tr>
                <!-- <tr>
                    <td><a href="obat.php"><button>Kembali</button></a></td>
                </tr> -->
            </table>
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $jenis = $_POST['jenis'];
        $kategori = $_POST['kategori'];
        $lokasi = $_POST['lokasi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $query = mysqli_query($connect, "UPDATE obat SET nama_obat = '$nama', lokasi = (SELECT id_lokasi FROM lokasi WHERE nama_lokasi = '$lokasi'), jenis_obat = (SELECT id_jenis FROM jenis WHERE nama_jenis = '$jenis'), kategori = (SELECT id_kategori FROM kategori WHERE nama_kategori = '$kategori'), harga = '$harga', stok = '$stok' WHERE id_obat = '$id'");
        if ($query) {
            header("Location: obat.php");
        } else {
            echo mysqli_error($connect);
        }
    }
    ?>
</body>
</html>