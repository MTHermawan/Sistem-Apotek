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
                <hr>
                <div class="action-button">
                    <a href="tambah-transaksi.php" id="transaksi-tambah"><button class="background-add">Tambah Transaksi</button></a>
                    <input type="text" name="search" id="search" class="search" placeholder="Cari Transaksi" onkeyup="search()">
                </div>
                <table table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Total Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Petugas</th>
                            <th id="head-transaksi-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        <?php
                        include("config.php");
                        $limit = 10;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        setlocale(LC_ALL, 'id-ID', 'id_ID');

                        $no = $offset + 1;
                        $query = mysqli_query($connect, "SELECT * FROM detail_transaksi INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN user ON transaksi.id_user = user.id_user GROUP BY transaksi.id_transaksi ORDER BY transaksi.tanggal_transaksi ASC LIMIT $limit OFFSET $offset;");
                        while ($data = mysqli_fetch_array($query)) {
                            $tanggal_transaksi = strftime("%A, %d %B %Y %H:%M", strtotime($data['tanggal_transaksi']));
                            ?>
                            <tr>
                                <td align="center"><?php echo $no++; ?></td>
                                <td><?php echo '#'.$data['id_transaksi']; ?></td>
                                <td><?php echo $data['nama_pembeli']; ?></td>
                                <td><?php echo 'Rp' . $data['total_harga']; ?></td>
                                <td><?php echo $tanggal_transaksi; ?></td>
                                <td><?php echo $data['username']; ?></td>
                                <td id="transaksi-aksi">
                                    <a href="#"><button class="background-detail"
                                            onclick="popupDetail('<?php echo $data['id_transaksi']; ?>')">Detail</button></a>
                                    <a href="delete-transaksi.php?id=<?php echo $data['id_transaksi'] ?>"><button
                                            class="background-delete">Hapus</button></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php
                        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM transaksi");
                        $row = mysqli_fetch_assoc($result);
                        $total_pages = ceil($row['total'] / $limit);

                        if ($page > 1) {
                            echo '<a href="?page='.($page - 1).'"><button class="background-pagination">Sebelumnya</button></a>';
                        } else {
                            echo '<a href="#"><button class="background-pagination">Sebelumnya</button></a>';
                        }
                    
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<a href="?page='.$i.'"';
                            if ($i == $page) {
                                echo ' class="active"';
                            }
                            echo '><button class="background-pagination">'.$i.'</button></a>';
                        }
                    
                        if ($page < $total_pages) {
                            echo '<a href="?page='.($page + 1).'"><button class="background-pagination">Berikutnya</button></a>';
                        } else {
                            echo '<a href="#"><button class="background-pagination">Berikutnya</button></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function popupDetail(id) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("popup").innerHTML = xhr.responseText;
                    adjustTableHeight();
                }
            };
            xhr.open('POST', 'get-detail.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + id);

            document.getElementById("popup").style.visibility = "visible";
            document.getElementById("popup").style.opacity = "1";
            document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") {
                closePopup();
            }
        });

        function closePopup() {
            document.getElementById("popup").style.visibility = "hidden";
            document.getElementById("popup").style.opacity = "0";
            document.getElementById("popup").style.transform = "translate(-25%, -35%)";
        }

        function adjustTableHeight() {
            var tbody = document.querySelector('#overlay tbody');
            var thead = document.querySelector('#overlay thead');
            var tfoot = document.querySelector('#overlay tfoot');
            var tr = document.querySelector('#overlay tbody tr');

            if (tbody && thead && tfoot && tr) {
                tbody.style.height = 'calc(100% - ' + (thead.offsetHeight + tfoot.offsetHeight + tr.offsetHeight) + 'px)';
                if (tbody.offsetHeight > 294) {
                    tbody.style.height = '294px';
                }
                console.log(tbody.offsetHeight);
            }
        }

        function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        console.log(filter);
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            if (td) {
                txtValue = [td[1].textContent || td[1].innerText, td[2].textContent || td[2].innerText, td[3].textContent || td[3].innerText, td[4].textContent || td[4].innerText, td[5].textContent || td[5].innerText];
                if (txtValue[0].toUpperCase().indexOf(filter) > -1 || txtValue[1].toUpperCase().indexOf(filter) > -1, txtValue[2].toUpperCase().indexOf(filter) > -1, txtValue[3].toUpperCase().indexOf(filter) > -1, txtValue[4].toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>

    <style>
        #overlay tbody {
            display: block;
            height: 182px;
            overflow-y: scroll;
        }

        #overlay thead,
        #overlay tbody tr,
        #overlay tfoot {
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
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        #overlay tbody::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
        }
    </style>
</body>
</html>
