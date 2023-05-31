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
                <h1>Data Pengguna</h1>
                <hr>
                <div class="action-button">
                    <a href="#"><button class="background-add" onclick="popupInsert()">Tambah Pengguna</button></a>
                    <input type="text" name="search" id="search" class="search" placeholder="Cari Pengguna Obat" onkeyup="search()">
                </div>
                <table border="1" width="95%" align="center">
                    
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Level</th>
                            <th>Karyawan</th>
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
                                $query = mysqli_query($connect, "SELECT * FROM user INNER JOIN `level` ON user.id_level = level.id_level INNER JOIN karyawan ON user.id_karyawan = karyawan.id_karyawan ORDER BY id_user ASC LIMIT $limit OFFSET $offset");
                                while($data = mysqli_fetch_array($query)){
                            ?>
                        <tr>
                            <td align="center"><?php echo $no++; ?></td>
                            <td align="center"><?php echo $data['id_user']; ?></td>
                            <td><?php echo $data['username']; ?></td>
                            <td><?php echo $data['password']; ?></td>
                            <td><?php echo $data['nama_level']; ?></td>
                            <td><?php echo $data['nama_karyawan']; ?></td>
                            <td align="center">
                                <a href="#" onclick="popupEdit('<?php echo $data['id_user']; ?>', '<?php echo $data['username']; ?>', '<?php echo $data['password']; ?>', '<?php echo $data['nama_level']; ?>', '<?php echo $data['nama_karyawan']; ?>')"><button class="background-edit">Edit</button></a>
                                <a href="delete-user.php?id=<?php echo $data['id_user']; ?>"><button class="background-delete">Hapus</button></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php
                        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM user");
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
                    <h1>Tambah Pengguna</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="id_pengguna">ID Pengguna:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_pengguna" id="id_pengguna" placeholder="0001" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="username">Username:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="username" id="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="password">Password:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                                <input type="text" name="password" id="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="level">Level:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                            <select name="level" id="level">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM `level` ORDER BY id_level ASC");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['id_level'] ?>"><?php echo $data['nama_level'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="karyawan">Karyawan:<span class="required">*</span>  </label><br>
                            </div>
                            <div>
                            <select name="karyawan" id="karyawan">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM karyawan ORDER BY id_karyawan ASC");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['id_karyawan'] ?>"><?php echo $data['nama_karyawan'] ?></option>
                                    <?php } ?>
                                </select>
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

    function popupEdit(id, username, password, level, karyawan) {
        console.log(id, username, password, level, karyawan);
        document.getElementById("popup").style.visibility = "visible";
        document.getElementById("popup").style.opacity = "1";
        document.getElementById("popup").style.transform = "translate(-25%, -25%)";
        document.getElementById("popup").innerHTML = `
        <div id="overlay">
                <div id="title">
                    <h1>Tambah Pengguna</h1>
                    <hr>
                </div>
                <form method="post">
                    <div id="form-data">
                        <div>
                            <div>
                                <label for="id_pengguna">ID Pengguna: </label><br>
                            </div>
                            <div>
                                <input type="text" name="id_pengguna" id="id_pengguna" placeholder="0001" value="${id}" disabled>
                                <input type="text" name="id_pengguna" id="id_pengguna" placeholder="0001" value="${id}" hidden>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="username">Username: </label><br>
                            </div>
                            <div>
                                <input type="text" name="username" id="username" placeholder="Username" value="${username}" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="password">Password: </label><br>
                            </div>
                            <div>
                                <input type="text" name="password" id="password" placeholder="Password" value="${password}" required>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="level">Level: </label><br>
                            </div>
                            <div>
                            <select name="level" id="level">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM `level` ORDER BY id_level ASC");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['nama_level'] ?>"><?php echo $data['nama_level'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="level">Karyawan: </label><br>
                            </div>
                            <div>
                            <select name="karyawan" id="karyawan">
                                    <?php
                                    include ("config.php");
                                    $query = mysqli_query($connect, "SELECT * FROM karyawan ORDER BY id_karyawan ASC");
                                    while($data = mysqli_fetch_array($query)){
                                    ?>
                                        <option value="<?php echo $data['nama_karyawan'] ?>"><?php echo $data['nama_karyawan'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="form-button">
                        <div>
                            <input type="submit" name="update" id="submit" value="Tambah">
                        </div>
                        <div>
                            <button type="button" onclick="closePopup()" class="background-delete">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
            <script>
        `;

        var levelSelect = document.getElementById("level");
        for (let i = 0; i < levelSelect.length; i++) {
            if (levelSelect.options[i].value == level) {
                levelSelect.selectedIndex = i;
                break;
            }
        }

        var karyawanSelect = document.getElementById("karyawan");
        for (let i = 0; i < karyawanSelect.length; i++) {
            if (karyawanSelect.options[i].value == karyawan) {
                karyawanSelect.selectedIndex = i;
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
        window.location.href = "user.php";
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

<?php
    include("config.php");
    if(isset($_POST['submit'])){
        $id = $_POST['id_user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $karyawan = $_POST['karyawan'];
        $query = mysqli_query($connect, "SELECT * FROM user WHERE id_user = '$id'");
        $data = mysqli_fetch_array($query);
        if($data){
            echo "<script>alert('ID sudah ada')</script>";
        } else {
            $query = mysqli_query($connect, "INSERT INTO user VALUES ('$id', '$username', '$password', '$level', '$karyawan')");
            if($query){
                echo "<script>refresh()</script>";
            }else{
                echo "Gagal";
            }
        }
    }
    
    if (isset($_POST['update'])) {
        $id = $_POST['id_user'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $karyawan = $_POST['karyawan'];
        $query = mysqli_query($connect, "UPDATE user SET username = '$nama', `password` = $password, `id_level` = $level, id_karyawan = $karyawan WHERE id_user = '$id'");
        if($query){
            echo "<script>refresh()</script>";
        }else{
            echo "Gagal";
        }
    }
?>
</body>
</html>