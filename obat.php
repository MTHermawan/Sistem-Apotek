<!DOCTYPE html>
<html lang="en">
<head class="flex">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obat</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php include("sidebar.php"); ?>
    <div id="popup"></div>
    
    <div id="content-top-bar">
        <?php include 'top-bar.php'; ?>
        <div id="content">
            <div id="table">
                <h1>Obat</h1>
                <hr>
                <div class="action-button">
                    <a href="#" id="obat-tambah"><button class="background-add" onclick="popupInsert()">Tambah Obat</button></a>
                    <input type="text" name="search" id="search" class="search" placeholder="Cari Obat" onkeyup="search()">
                </div>
                <table table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th id="head-obat-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include("config.php");
                            $limit = 10;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

                            $no = $offset + 1;
                            $query = mysqli_query($connect, "SELECT * FROM obat INNER JOIN jenis ON obat.jenis_obat = jenis.id_jenis INNER JOIN kategori ON obat.kategori = kategori.id_kategori INNER JOIN lokasi ON obat.lokasi = lokasi.id_lokasi ORDER BY id_obat ASC LIMIT $limit OFFSET $offset;");
                            while($data = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td align="center" width="4%"><?php echo $no++; ?></td>
                            <td align="center" width="6%"><?php echo $data['id_obat']; ?></td>
                            <td width="10%"><?php echo $data['nama_obat']; ?></td>
                            <td width="10%"><?php echo $data['nama_jenis']; ?></td>
                            <td width="10%"><?php echo $data['nama_kategori']; ?></td>
                            <td width="8%"><?php echo $data['nama_lokasi']; ?></td>
                            <td align="center" width="6%"><?php echo $data['stok']; ?></td>
                            <td align="center" width="8%"><?php echo 'Rp'.$data['harga']; ?></td>
                            <td align="center" width="6%"><?php echo $data['status']; ?></td>
                            <td><?php if ($data['keterangan'] == NULL || $data['keterangan'] == "") {
                                echo "(Tidak ada keterangan.)";
                            } else {
                                echo $data['keterangan'];
                            } ?></td>
                            <td align="center" id="obat-aksi" width="16%">
                            <a href="#" onclick="popupEdit('<?php echo $data['id_obat']; ?>', '<?php echo $data['nama_obat']; ?>', '<?php echo $data['nama_jenis']; ?>', '<?php echo $data['nama_kategori']; ?>', '<?php echo $data['nama_lokasi']; ?>', '<?php echo $data['stok']; ?>', '<?php echo $data['harga']; ?>', '<?php echo $data['status']; ?>', '<?php echo $data['keterangan']; ?>')"><button class="background-edit">Edit</button></a>
                                <a href="delete-obat.php?id=<?php echo $data['id_obat']; ?>"><button class="background-delete">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php
                        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM obat");
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
    function popupInsert() {
        document.getElementById("popup").style.visibility = "visible";
        document.getElementById("popup").style.opacity = "1";
        document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        document.getElementById("popup").innerHTML = `
            <div id="overlay">
                <div id="title">
                    <h1>Tambah Obat</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div class="input-group">
                            <div>
                                <label for="id_obat">ID Obat:<span class="required">*</span> </label>
                            </div>
                            <div>
                                <input type="text" name="id_obat" id="id_obat" placeholder="0001" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="nama_obat">Nama Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <input type="text" name="nama_obat" id="nama_obat" placeholder="Sanmol" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="jenis">Jenis Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <select name="jenis" id="jenis">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM jenis");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['id_jenis'] ?>"><?php echo $data['nama_jenis'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="kategori">Kategori Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <select name="kategori" id="kategori">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM kategori");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['id_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="lokasi">Lokasi Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <select name="lokasi" id="lokasi">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM lokasi");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['id_lokasi'] ?>"><?php echo $data['nama_lokasi'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="harga">Harga Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <input type="text" name="harga" id="harga" placeholder="10" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="stok">Stok Obat:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <input type="text" name="stok" id="stok" placeholder="10" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="status">Status:<span class="required">*</span>  </label>
                            </div>
                            <div>
                                <?php
                                $result = mysqli_query($connect, "SHOW COLUMNS FROM obat LIKE 'status'");
                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    $enumValues = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row['Type']));
                                }
                                ?>
                                <select name="status" id="status">
                                    <?php foreach ($enumValues as $value) : ?>
                                        <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <div>
                                <label for="keterangan">Keterangan: </label>
                            </div>
                            <div>
                                <input type="text" name="keterangan" id="keterangan" placeholder="keterangan">
                            </div>
                        </div>
                    </div>
                    <div id="form-button">
                        <div>
                            <input type="submit" name="submit" id="submit" value ="Tambah">
                        </div>
                        <div>
                            <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
    }

    function popupEdit(id, nama, jenis, kategori, lokasi, stok, harga, status, keterangan) {
        console.log(id, nama, jenis, kategori, lokasi, stok, harga);
        document.getElementById("popup").style.visibility = "visible";
        document.getElementById("popup").style.opacity = "1";
        document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        document.getElementById("popup").innerHTML = `
        <div id="overlay">
            <div id="title">
                <h1>Edit Obat</h1>
                <hr>
            </div>
            <form method="post">
                <div id="form-data">
                    <div class="input-group">
                        <div>
                            <label for="nama">ID Obat: </label>
                        </div>
                        <div>
                            <input type="text" name="id_obat" id="id_obat" value="${id}" placeholder="0001" disabled>
                            <input type="text" name="id_obat" id="id_obat" value="${id}" placeholder="0001" hidden>
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="nama">Nama Obat: </label>
                        </div>
                        <div>
                            <input type="text" name="nama_obat" id="nama_obat" value="${nama}" placeholder="Sanmol">
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="jenis">Jenis Obat: </label>
                        </div>
                        <div>
                            <select name="jenis" id="jenis">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM jenis");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_jenis']; ?>"><?php echo $data['nama_jenis'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="kategori">Kategori Obat: </label>
                        </div>
                        <div>
                            <select name="kategori" id="kategori">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM kategori");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="lokasi">Lokasi Obat: </label>
                        </div>
                        <div>
                            <select name="lokasi" id="lokasi">
                                <?php
                                include ("config.php");
                                $query = mysqli_query($connect, "SELECT * FROM lokasi");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                    <option value="<?php echo $data['nama_lokasi'] ?>"><?php echo $data['nama_lokasi'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="harga">Harga Obat: </label>
                        </div>
                        <div>
                            <input type="text" name="harga" id="harga" value="${harga}" placeholder="10">
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="stok">Stok Obat: </label>
                        </div>
                        <div>
                            <input type="text" name="stok" id="stok" value="${stok}" placeholder="10">
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="status">Status: </label>
                        </div>
                        <div>
                            <?php
                            $result = mysqli_query($connect, "SHOW COLUMNS FROM obat LIKE 'status'");
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $enumValues = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row['Type']));
                            }
                            ?>
                            <select name="status" id="status">
                                <?php foreach ($enumValues as $value) : ?>
                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-group">
                        <div>
                            <label for="keterangan">Keterangan: </label>
                        </div>
                        <div>
                            <input type="text" name="keterangan" id="keterangan" value="${keterangan}" placeholder="Keterangan">
                        </div>
                    </div>
                </div>
                <div id="form-button">
                    <div>
                        <input type="submit" name="update" id="submit" value ="Perbarui">
                    </div>
                    <div>
                        <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
        `;

        var jenisSelect = document.getElementById("jenis");
        for (var i = 0; i < jenisSelect.length; i++) {
            if (jenisSelect.options[i].value == jenis) {
                jenisSelect.selectedIndex = i;
                break;
            }
        }

        var kategoriSelect = document.getElementById("kategori");
        for (var i = 0; i < kategoriSelect.length; i++) {
            if (kategoriSelect.options[i].value == kategori) {
                kategoriSelect.selectedIndex = i;
                break;
            }
        }

        var lokasiSelect = document.getElementById("lokasi");
        for (var i = 0; i < lokasiSelect.length; i++) {
            if (lokasiSelect.options[i].value == lokasi) {
                lokasiSelect.selectedIndex = i;
                break;
            }
        }

        var statusSelect = document.getElementById("status");
        for (var i = 0; i < statusSelect.length; i++) {
            if (statusSelect.options[i].value == status) {
                statusSelect.selectedIndex = i;
                break;
            }
        }
}

    function closePopup() {
        document.getElementById("popup").style.visibility = "hidden";
        document.getElementById("popup").style.opacity = "0";
        document.getElementById("popup").style.transform = "translate(-25%, -35%)";
    }

    function refresh() {
        window.location.href = "obat.php";
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closePopup();
        }
    });

    function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("table");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            // make td array for each row
            td = tr[i].getElementsByTagName("td");
            if (td || td2) {
                txtValue = [td[1].textContent || td[1].innerText, td[2].textContent || td[2].innerText, td[3].textContent || td[3].innerText, td[4].textContent || td[4].innerText, td[5].textContent || td[5].innerText, td[6].textContent || td[6].innerText, td[7].textContent || td[7].innerText, td[8].textContent || td[8].innerText, td[9].textContent || td[9].innerText];
                if (txtValue[0].toUpperCase().indexOf(filter) > -1 || txtValue[1].toUpperCase().indexOf(filter) > -1 || txtValue[2].toUpperCase().indexOf(filter) > -1 || txtValue[3].toUpperCase().indexOf(filter) > -1 || txtValue[4].toUpperCase().indexOf(filter) > -1 || txtValue[5].toUpperCase().indexOf(filter) > -1 || txtValue[6].toUpperCase().indexOf(filter) > -1 || txtValue[7].toUpperCase().indexOf(filter) > -1 || txtValue[8].toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<?php
    include ("config.php");

    if (isset($_POST['submit'])) {
        $id = $_POST['id_obat'];
        $nama = $_POST['nama_obat'];
        $jenis = $_POST['jenis'];
        $kategori = $_POST['kategori'];
        $lokasi = $_POST['lokasi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $status = $_POST['status'];
        $keterangan = $_POST['keterangan'];

        $query = mysqli_query($connect, "SELECT * FROM obat WHERE id_obat = '$id'");
        $cek = mysqli_num_rows($query);
        if ($cek > 0) {
            echo "<script>alert('ID Obat sudah ada!')</script>";
        } else {
            $query = mysqli_query($connect, "INSERT INTO obat VALUES ('$id', '$nama', '$jenis', '$kategori', '$lokasi', '$stok', '$harga', '$status', '$keterangan')");
            $query2 = mysqli_query($connect, "INSERT INTO barang_masuk (id_barang_masuk, nama_obat, jumlah) VALUES ('$id', '$nama', '$stok')");
            if ($query && $query2) {
                echo "<script>refresh()</script>";
            } else {
                echo "Gagal";
            }
        }
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id_obat'];
        $nama = $_POST['nama_obat'];
        $jenis = $_POST['jenis'];
        $kategori = $_POST['kategori'];
        $lokasi = $_POST['lokasi'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];
        $status = $_POST['status'];
        $keterangan = $_POST['keterangan'];

        //cek apabila stok bertambah maka masukkan ke barang masuk
        $query = mysqli_query($connect, "SELECT * FROM obat WHERE id_obat = '$id'");
        $row = mysqli_fetch_assoc($query);
        $stok_lama = $row['stok'];
        if ($stok > $stok_lama) {
            $query = mysqli_query($connect, "INSERT INTO barang_masuk (nama_obat, jumlah) VALUES ('$nama', '$stok' - '$stok_lama')");
        } else if ($stok < $stok_lama) {
            $query = mysqli_query($connect, "INSERT INTO barang_keluar (nama_obat, jumlah) VALUES ('$nama', '$stok_lama' - '$stok')");
        }

        $query = mysqli_query($connect, "UPDATE obat SET nama_obat = '$nama', lokasi = (SELECT id_lokasi FROM lokasi WHERE nama_lokasi = '$lokasi'), jenis_obat = (SELECT id_jenis FROM jenis WHERE nama_jenis = '$jenis'), kategori = (SELECT id_kategori FROM kategori WHERE nama_kategori = '$kategori'), harga = '$harga', stok = '$stok', `status` = '$status', keterangan = '$keterangan' WHERE id_obat = '$id'");
        if ($query) {
            echo "<script>refresh()</script>";
        } else {
            echo mysqli_error($connect);
        }
    }
?>
</body>
</html>