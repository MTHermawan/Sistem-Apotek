<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Obat</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <div id="popup"></div>
    <?php include("sidebar.php"); ?>
    <div id="content-top-bar">
        <?php include("top-bar.php"); ?>
        <div id="content">
            <div id="table">
                <h1>Data Karyawan</h1>
                <hr>
                <div class="action-button">
                    <a href="#"><button class="background-add" onclick="popupInsert()">Tambah Karyawan</button></a>
                    <input type="text" name="search" id="search" class="search" placeholder="Cari Jenis Obat" onkeyup="search()">
                </div>
                <table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            include("config.php");
                            $limit = 10;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

                            $no = $offset + 1;
                            $query = mysqli_query($connect, "SELECT * FROM karyawan ORDER BY id_karyawan ASC LIMIT $limit OFFSET $offset");
                            while($data = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $data['id_karyawan']; ?></td>
                            <td><?php echo $data['nama_karyawan']; ?></td>
                            <td align="center">
                                <a href="#" onclick="popupEdit('<?php echo $data['id_karyawan']; ?>', '<?php echo $data['nama_karyawan']; ?>')"><button class="background-edit">Edit</button></a>
                                <a href="delete-karyawan.php?id=<?php echo $data['id_karyawan']; ?>"><button class="background-delete">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php
                        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM karyawan");
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
                    <h1>Tambah Karyawan</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="id_karyawan">ID Karyawan:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_karyawan" id="id_karyawan" placeholder="0001" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="nama_karyawan">Nama Karyawan:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Budi" required>
                            </div>
                        </div>
                    </div>
                    <div id="form-button">
                        <div>
                            <input type="submit" name="submit" id="submit" value="Tambah">
                        </div>
                        <div>
                            <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
    }

    function popupEdit(id, nama) {
        document.getElementById("popup").style.visibility = "visible";
        document.getElementById("popup").style.opacity = "1";
        document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        document.getElementById("popup").innerHTML = `
            <div id="overlay">
                <div id="title">
                    <h1>Edit Karyawan</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="id_karyawan">ID Karyawan: </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_karyawan" id="id_karyawan" value="${id}" placeholder="0001" disabled>
                                <input type="text" name="id_karyawan" id="id_karyawan" value="${id}" placeholder="0001" hidden>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="nama_karyawan">Nama Karyawan: </label><br>
                            </div>
                            <div>
                                <input type="text" name="nama_karyawan" id="nama_karyawan" value="${nama}" placeholder="Tablet" required>
                            </div>
                        </div>
                    </div>
                    <div id="form-button">
                        <div>
                            <input type="submit" name="update" id="submit" value="Perbarui">
                        </div>
                        <div>
                            <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        `;
    }

    function closePopup() {
        document.getElementById("popup").style.visibility = "hidden";
        document.getElementById("popup").style.opacity = "0";
        document.getElementById("popup").style.transform = "translate(-25%, -35%)";
    }

    function refresh() {
        window.location.href = "karyawan.php";
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
            td = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            if (td || td2) {
                txtValue = td.textContent || td.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<?php
    include("config.php");
    if(isset($_POST['submit'])){
        $id = $_POST['id_karyawan'];
        $nama = $_POST['nama_karyawan'];
        $query = mysqli_query($connect, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
        $cek = mysqli_num_rows($query);
        if($cek > 0){
            echo "<script>alert('ID Karyawan sudah ada!')</script>";
        } else {
            $query = mysqli_query($connect, "INSERT INTO karyawan (id_karyawan, nama_karyawan) VALUES ('$id', '$nama')");
            if($query){
                echo "<script>refresh()</script>";
            }else{
                echo "Gagal";
            }
        }
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id_karyawan'];
        $nama = $_POST['nama_karyawan'];
        $query = mysqli_query($connect, "UPDATE karyawan SET nama_karyawan = '$nama' WHERE id_karyawan = '$id'");
        if($query){
            echo "<script>refresh()</script>";
        }else{
            echo "Gagal";
        }
    }
?>
</body>
</html>