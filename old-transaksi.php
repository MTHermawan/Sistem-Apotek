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
    <div id="popup"></div>

    <div id="content-top-bar">
        <?php include("top-bar.php"); ?>
        <div id="content">
            <div id="table">
                <h1>Riwayat Transaksi</h1>
                <table table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Total Transaksi</th>
                            <th>Pembayaran</th>
                            <th id="head-transaksi-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                            <?php
                                include("config.php");
                                $no = 1;
                                $query = mysqli_query($connect, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi GROUP BY transaksi.id_transaksi ORDER BY transaksi.tanggal_transaksi ASC;");
                                while($data = mysqli_fetch_array($query)){
                            ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td><?php echo $data['tanggal_transaksi']; ?></td>
                            <td><?php echo $data['nama_pembeli']; ?></td>
                            <td><?php echo 'Rp'.$data['total_harga']; ?></td>
                            <td><?php echo 'Rp'.$data['pembayaran']; ?></td>
                            <td id="transaksi-aksi">
                                <a href="#"><button class="background-detail" onclick="popupDetail('<?php echo $data['id_transaksi']; ?>')">Detail</button></a>
                                <a href="delete-transaksi.php?no_ref=<?php echo $data['id_transaksi'] ?>"><button class="background-delete">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr id="transaksi-tambah">
                            <td colspan="6" align="center">
                                <a href="tambah-transaksi.php"><button class="background-add">Tambah Transaksi</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function popupDetail(id) {
        document.getElementById("popup").style.visibility = "visible";
        document.getElementById("popup").style.opacity = "1";
        document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        document.getElementById("popup").innerHTML = `
        <div id="overlay" style="justify-content: flex-start">
            <div id="title">
                <h1>Detail Transaksi</h1>
            </div>
            <div>
                <h3>Nama Pembeli: </h3>
                <h3>No. Referensi: ` + id + `</h3>
            </div>
            <div id="table_test">
                <table table border="0" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Sub Total</th>
                            <th class="overflow-width"></th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        include("config.php");
                        // change the id variable in this JavaScript function to PHP variable
                        $id = '` + id + `';
                        $no = 1;
                        if ($id != '' || $id != null) {
                            // echo '$id value is '.$id;
                            $query = "SELECT * FROM detail_transaksi INNER JOIN obat ON detail_transaksi.obat = obat.id_obat WHERE detail_transaksi.id_transaksi = '" . $id . "' ORDER BY detail_transaksi.id_detail_transaksi ASC";
                            echo $query;
                            $result = mysqli_query($connect, $query);
                            while ($data = mysqli_fetch_array($result)) {
                                ?>
                            <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama_obat']; ?></td>
                            <td><?php echo $data['jumlah']; ?></td>
                            <td>Rp<?php echo $data['harga'] * $data['jumlah']; ?></td>
                            </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <td align="center">
                                <?php
                                $query = mysqli_query($connect, "SELECT SUM(harga) AS total FROM detail_transaksi WHERE id_transaksi = '" . $id . "'");
                                $data = mysqli_fetch_array($query);
                                echo 'Rp' . $data['total'];
                                ?>
                            </td>
                            <td class="overflow-width"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="form-button" style="height: 100%; align-items: flex-end">
                <div>
                    <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                </div>
            </div>
        </div>
        `;

        var tbody = document.querySelector('#overlay tbody');
        var thead = document.querySelector('#overlay thead');
        var tfoot = document.querySelector('#overlay tfoot');
        var tr = document.querySelector('#overlay tbody tr');

        if (tbody && thead && tfoot && tr) {
            tbody.style.height = 'calc(100% - ' + (thead.offsetHeight + tfoot.offsetHeight + tr.offsetHeight) + 'px)';
            if (tbody.offsetHeight > 182) {
                tbody.style.height = '182px';
            }
        }
    }


    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closePopup();
        }
    });

    function closePopup() {
        document.getElementById("popup").style.visibility = "hidden";
        document.getElementById("popup").style.opacity = "0";
        document.getElementById("popup").style.transform = "translate(-25%, -35%)";
    }
    </script>

    <style>
        #overlay tbody{
            display:block;
            height:182px;
            overflow-y:scroll;
        }
        #overlay thead, #overlay tbody tr, #overlay tfoot {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        #overlay thead {
            width: calc( 100% + 0.1em )
        }

        #overlay tfoot {
            width: calc( 100% + 0.05em )
        }

        #overlay thead .overflow-width {
            width: 1.15em;
        }

        #overlay tfoot .overflow-width {
            width: 1.1em;
        }

        #overlay tbody::-webkit-scrollbar {
            width: 1.1em;
        }
        #overlay tbody::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }
        #overlay tbody::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
        }
    </style>
</body>
</html>
