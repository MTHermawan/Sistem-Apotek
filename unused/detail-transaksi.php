<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>
    <div id="table">
        <h1>Detail Transaksi</h1>
        <table table border="1" width="95%" align="center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody align="center">
                    <?php
                        include("config.php");
                        $no_ref = $_GET['no_ref'];
                        $no_index = 1;
                        $query = mysqli_query($connect, "SELECT * FROM transaksi INNER JOIN obat ON transaksi.obat = obat.id_obat WHERE no_ref = '$no_ref' ORDER BY id_transaksi ASC");
                        while($data = mysqli_fetch_array($query)){
                    ?>
                <tr>
                    <td><?php echo $no_index; $no_index++?></td>
                    <td><?php echo $data['nama_obat']; ?></td>
                    <td><?php echo $data['jumlah']; ?></td>
                    <td><?php echo $data['harga']; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td>
                        <?php
                            $query = mysqli_query($connect, "SELECT SUM(harga) AS total FROM transaksi WHERE no_ref = '$no_ref'");
                            $data = mysqli_fetch_array($query);
                            echo $data['total'];
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <a href="transaksi.php"><button>Kembali</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
</body>
</html>