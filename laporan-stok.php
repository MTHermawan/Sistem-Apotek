<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>

    <div id="content-top-bar">
        <?php include("top-bar.php"); ?>
        <div id="content">
            <div id="table">
                <h1>Laporan Obat</h1>
                <hr>
                <a href="cetak-laporan.php" target="_blank"><button>Cetak</button></a>
                <table table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Jenis Obat</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                include("config.php");
                                $no = 1;
                                $query = mysqli_query($connect, "SELECT * FROM obat INNER JOIN jenis ON obat.jenis_obat = jenis.id_jenis ORDER BY id_obat ASC");
                                while($data = mysqli_fetch_array($query)){
                            ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $data['id_obat']; ?></td>
                            <td><?php echo $data['nama_obat']; ?></td>
                            <td><?php echo $data['nama_jenis']; ?></td>
                            <td><?php echo $data['stok']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>