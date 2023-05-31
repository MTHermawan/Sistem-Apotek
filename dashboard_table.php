<div id="table_dashboard">
    <div id="table_dashboard_content">
        <div id="title" style="width: 100%">
            <h2>Obat Hampir Habis</h2>
            <hr>
        </div>
        <div>
            <select name="table_select" id="table_select">
                <option value="obat-hampir-habis">Obat Hampir Habis</option>
                <option value="transaksi-terbaru">Transaksi Terbaru</option>
                <option value="barang-keluar">Barang Keluar</option>
                <option value="barang-masuk">Barang Masuk</option>
            </select>
        </div>
        <div id="main_table">
            <table>
                <tr>
                    <th>No</th>
                    <th>ID Obat</th>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                </tr>
                <?php
                    include("config.php");
                    $no = 1;
                    $query = mysqli_query($connect, "SELECT * FROM obat WHERE stok < 10");
                    if (mysqli_num_rows($query) > 0) {
                        while($data = mysqli_fetch_array($query)){
                            ?><tr>
                                <td align="center"><?php echo $no++ ?></td>
                                <td><?php echo $data['id_obat'] ?></td>
                                <td align="center"><?php echo $data['nama_obat'] ?></td>
                                <td align="center"><?php echo $data['stok'] ?></td>
                            </tr><?php
                        }
                    } else {
                        ?><tr>
                            <td colspan="4" align="center">Tidak ada data obat yang hampir habis.</td>
                        </tr><?php
                    }
                ?>
            </table>
        </div>
    </div>
</div>
<script>
    var table_select = document.getElementById("table_select");
        var main_table = document.getElementById("main_table");
        var title = document.getElementById("title");
        table_select.addEventListener('change', function() {
            if (this.value == "obat-hampir-habis") {
                title.innerHTML = "<h2>Obat Hampir Habis</h2><hr>";
                main_table.innerHTML = `
                    <table>
                        <tr>
                            <th>No</th>
                            <th>ID Obat</th>
                            <th>Nama Obat</th>
                            <th>Stok</th>
                        </tr>
                        <?php
                            include("config.php");
                            $no = 1;
                            $query = mysqli_query($connect, "SELECT * FROM obat WHERE stok < 10");
                            if (mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_array($query)){
                                    ?><tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td align="center"><?php echo $data['id_obat'] ?></td>
                                        <td><?php echo $data['nama_obat'] ?></td>
                                        <td align="center"><?php echo $data['stok'] ?></td>
                                    </tr><?php
                                }
                            } else {
                                ?><tr>
                                    <td colspan="4" align="center">Tidak ada data obat yang hampir habis.</td>
                                </tr><?php
                            }
                        ?>
                    </table>`;
            } else if (this.value == "transaksi-terbaru") {
                title.innerHTML = "<h2>Transaksi Terbaru</h2><hr>";
                main_table.innerHTML = `
                    <table>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Total Harga</th>
                            <th>Waktu Transaksi</th>
                        </tr>
                        <?php
                            include("config.php");
                            $no = 1;
                            $query = mysqli_query($connect, "SELECT * FROM transaksi ORDER BY tanggal_transaksi DESC LIMIT 5");
                            setlocale(LC_ALL, 'id-ID', 'id_ID');
                            if (mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_array($query)){
                                    ?><tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td align="center"><?php echo $data['id_transaksi'] ?></td>
                                        <td align="center"><?php echo $data['nama_pembeli'] ?></td>
                                        <td align="center"><?php echo 'Rp'.$data['total_harga'] ?></td>
                                        <td align="center"><?php echo strftime("%A, %d %B %Y %H:%M", strtotime($data['tanggal_transaksi'])) ?></td>
                                    </tr><?php
                                }
                            } else {
                                ?><tr>
                                    <td colspan="4" align="center">Tidak ada data transaksi.</td>
                                </tr><?php
                            }
                        ?>
                    </table>`;
            }
            else if (this.value == "barang-keluar") {
                title.innerHTML = "<h2>Barang Keluar</h2><hr>";
                main_table.innerHTML = `
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Waktu Keluar</th>
                        </tr>
                        <?php
                            include("config.php");
                            $no = 1;
                            $query = mysqli_query($connect, "SELECT * FROM barang_keluar ORDER BY tanggal_keluar DESC LIMIT 5");
                            setlocale(LC_ALL, 'id-ID', 'id_ID');
                            if (mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_array($query)){
                                    ?><tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td><?php echo $data['nama_obat'] ?></td>
                                        <td align="center"><?php echo $data['jumlah'] ?></td>
                                        <td align="center"><?php echo strftime("%A, %d %B %Y %H:%M", strtotime($data['tanggal_keluar'])) ?></td>
                                    </tr><?php
                                }
                            } else {
                                ?><tr>
                                    <td colspan="4" align="center">Tidak ada data barang keluar.</td>
                                </tr><?php
                            }
                        ?>
                    </table>`;
            } else if (this.value == "barang-masuk") {
                title.innerHTML = "<h2>Barang Masuk</h2><hr>";
                main_table.innerHTML = `
                    <table>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Waktu Masuk</th>
                        </tr>
                        <?php
                            include("config.php");
                            $no = 1;
                            $query = mysqli_query($connect, "SELECT * FROM barang_masuk ORDER BY tanggal_masuk DESC LIMIT 5");
                            setlocale(LC_ALL, 'id-ID', 'id_ID');
                            if (mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_array($query)){
                                    ?><tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td><?php echo $data['nama_obat'] ?></td>
                                        <td align="center"><?php echo $data['jumlah'] ?></td>
                                        <td align="center"><?php echo strftime("%A, %d %B %Y %H:%M", strtotime($data['tanggal_masuk'])) ?></td>
                                    </tr><?php
                                }
                            } else {
                                ?><tr>
                                    <td colspan="4" align="center">Tidak ada data barang masuk.</td>
                                </tr><?php
                            }
                        ?>
                    </table>`;
            }
        });

        function BarangMasuk() {
            document.getElementById("table_select").value = "barang-masuk";
            main_table.innerHTML = `
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Waktu Masuk</th>
                </tr>
                <?php
                    include("config.php");
                    $no = 1;
                    $query = mysqli_query($connect, "SELECT * FROM barang_masuk ORDER BY tanggal_masuk DESC LIMIT 5");
                    setlocale(LC_ALL, 'id-ID', 'id_ID');
                    if (mysqli_num_rows($query) > 0) {
                        while($data = mysqli_fetch_array($query)){
                            ?><tr>
                                <td align="center"><?php echo $no++ ?></td>
                                <td><?php echo $data['nama_obat'] ?></td>
                                <td align="center"><?php echo $data['jumlah'] ?></td>
                                <td align="center"><?php echo strftime("%A, %d %B %Y %H:%M", strtotime($data['tanggal_masuk'])) ?></td>
                            </tr><?php
                        }
                    } else {
                        ?><tr>
                            <td colspan="4" align="center">Tidak ada data barang masuk.</td>
                        </tr><?php
                    }
                ?>
            </table>`;
        }
</script>