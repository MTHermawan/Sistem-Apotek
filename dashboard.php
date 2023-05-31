<?phpsession_start()?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>    
    <div id="content-top-bar">
        <?php include("top-bar.php"); ?>
        <div id="content">
            <div class="table">
                <h1 style="color: #333">Dashboard</h1>
                <br>
                <div id="card-flex">
                    <div id="card_1" class="dashboard-card"></div>
                    <div id="card_2" class="dashboard-card"></div>
                    <div id="card_3" class="dashboard-card"></div>
                    <div id="card_4" class="dashboard-card"></div>
                </div>
                <?php include("dashboard_table.php"); ?>
                <?php include("chart.php"); ?>
            </div>
        </div>

    <?php
    include("config.php");
    $query = mysqli_query($connect, "SELECT COUNT(*) AS jumlah_obat FROM obat");
    $jumlah_obat = 0;
    if ($data = mysqli_fetch_array($query)) {
        $jumlah_obat = $data['jumlah_obat'];
        ?><script> document.getElementById("card_1").innerHTML = "<div id='data-jumlah-obat'><h2><?php echo $jumlah_obat.' Obat' ?></h2><h2>Jumlah Obat</h2></div><a href='obat.php' class='lihat-obat'>Lihat Data</a>"</script><?php
    }
    
    $query = mysqli_query($connect, "SELECT FORMAT(SUM(total_harga), 2) AS total_penjualan FROM transaksi WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE()) AND MONTH(tanggal_transaksi) = MONTH(CURDATE());");
    $total_penjujualan = 0;
    if ($data = mysqli_fetch_array($query)) {
        $total_penjualan = $data['total_penjualan'];
        ?><script> document.getElementById("card_2").innerHTML = "<div id='data-jumlah-obat'><h2><?php echo 'Rp'.$total_penjualan ?></h2><h2>Penjualan Bulan Ini</h2></div><a href='transaksi.php' class='lihat-obat'>Lihat Data</a>"</script><?php
    }

    $query = mysqli_query($connect, "SELECT COUNT(*) AS total_transaksi FROM transaksi WHERE YEAR(tanggal_transaksi) = YEAR(CURDATE()) AND MONTH(tanggal_transaksi) = MONTH(CURDATE());");
    $total_transaksi = 0;
    if ($data = mysqli_fetch_array($query)) {
        $total_transaksi = $data['total_transaksi'];
        ?><script> document.getElementById("card_3").innerHTML = "<div id='data-jumlah-obat'><h2><?php echo $total_transaksi.' Transaksi' ?></h2><h2>Transaksi Bulan Ini</h2></div><a href='transaksi.php' class='lihat-obat'>Lihat Data</a>"</script><?php
    }

    $query = mysqli_query($connect, "SELECT COUNT(*) AS total_barang_masuk FROM barang_masuk WHERE YEAR(tanggal_masuk) = YEAR(CURDATE()) AND MONTH(tanggal_masuk) = MONTH(CURDATE());");
    if ($data = mysqli_fetch_array($query)) {
        ?><script> document.getElementById("card_4").innerHTML = "<div id='data-jumlah-obat'><h2><?php echo $data['total_barang_masuk'].' Barang Masuk' ?></h2><h2>Barang Masuk Bulan Ini</h2></div><a href='#table_dashboard' onclick='BarangMasuk()' class='lihat-obat'>Lihat Data</a>"</script><?php
    }
    ?>
</body>

<style>
    @media print {
        #sidebar {
            display: none;
        }

        #content-top-bar {
            margin-left: 0;
        }

        #top-bar {
            display: none;
        }

        #content {
            margin: 0;
        }
    }
</style>
</html>