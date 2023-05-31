<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>
    <div id="content-top-bar">
        <?php include("top-bar.php"); ?>
        <div id="content">
            <div id="table">
                <h1>Menu Laporan</h1>
                <hr>
                <ul>
                    <li><a href="laporan-stok.php">Laporan Obat</a></li>
                    <li><a href="laporan-transaksi.php">Laporan Transaksi</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>