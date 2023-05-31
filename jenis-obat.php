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
                <h1>Jenis Obat</h1>
                <hr>
                <div class="action-button">
                    <a href="#"><button class="background-add" onclick="popupInsert()">Tambah Jenis</button></a>
                    <input type="text" name="search" id="search" class="search" placeholder="Cari Jenis Obat" onkeyup="search()">
                </div>
                <table border="1" width="95%" align="center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table_content">
                    <?php
                            include("config.php");
                            $limit = 10;
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

                            $no = $offset + 1;
                            $query = mysqli_query($connect, "SELECT * FROM jenis ORDER BY id_jenis ASC LIMIT $limit OFFSET $offset");
                            while($data = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $data['id_jenis']; ?></td>
                            <td><?php echo $data['nama_jenis']; ?></td>
                            <td align="center">
                                <a href="#" onclick="popupEdit('<?php echo $data['id_jenis']; ?>', '<?php echo $data['nama_jenis']; ?>')"><button class="background-edit">Edit</button></a>
                                <a href="delete-jenis.php?id=<?php echo $data['id_jenis']; ?>"><button class="background-delete">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php
                        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM jenis");
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
                    <h1>Tambah Jenis</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="nama">ID Jenis:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_jenis" id="id_jenis" placeholder="0001" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="nama">Nama Jenis:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="nama_jenis" id="nama_jenis" placeholder="Tablet">
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
                    <h1>Edit Jenis</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="nama">ID Jenis: </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_jenis" id="id_jenis" value="${id}" placeholder="0001" disabled>
                                <input type="text" name="id_jenis" id="id_jenis" value="${id}" placeholder="0001" hidden>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="nama">Nama Jenis: </label><br>
                            </div>
                            <div>
                                <input type="text" name="nama_jenis" id="nama_jenis" value="${nama}" placeholder="Tablet">
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
        window.location.href = "jenis-obat.php";
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
            td = tr[i].getElementsByTagName("td");
            if (td || td2) {
                txtValue = [td[1].textContent || td[1].innerText, td[2].textContent || td[2].innerText];
                if (txtValue[0].toUpperCase().indexOf(filter) > -1 || txtValue[1].toUpperCase().indexOf(filter) > -1) {
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
        $id = $_POST['id_jenis'];
        $nama = $_POST['nama_jenis'];
        $query = mysqli_query($connect, "SELECT * FROM jenis WHERE id_jenis='$id'");
        $cek = mysqli_num_rows($query);
        if($cek > 0){
            echo "<script>alert('ID Jenis sudah ada!')</script>";
        } else {
            $query = mysqli_query($connect, "INSERT INTO jenis (id_jenis, nama_jenis) VALUES ('$id', '$nama')");
            if($query){
                echo "<script>refresh()</script>";
            }else{
                echo "Gagal";
            }
        }
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id_jenis'];
        $nama = $_POST['nama_jenis'];
        $query = mysqli_query($connect, "UPDATE jenis SET nama_jenis='$nama' WHERE id_jenis='$id'");
        if($query){
            echo "<script>refresh()</script>";
        }else{
            echo "Gagal";
        }
    }
?>

<style>
    
</style>
</body>
</html>