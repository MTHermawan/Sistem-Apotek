<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body class="flex">
    <?php 
        if (isset($_POST['submit'])) {
            include("config.php");
            $id_transaksi = $_POST['id_transaksi'];
            $nama_pembeli = $_POST['nama_pembeli'];
            $obat = $_POST['nama_obat'];
            $jumlah = $_POST['jumlah'];
            $total = $_POST['total'];
            $pembayaran = $_POST['pembayaran'];
            $usia = $_POST['usia'];
            $no_hp = $_POST['no_hp'];
            $username = "kasir";

            $isStok = true;
            $isPembayaran = false;

            for ($i=0; $i < count($obat); $i++) { 
                $index_obat = $obat[$i];
                $index_jumlah = $jumlah[$i];
                $query = mysqli_query($connect, "SELECT stok FROM obat WHERE id_obat = '$index_obat'");
                $data = mysqli_fetch_array($query);
                if ($index_jumlah >= $data['stok']) {
                    $isStok = false;
                    break;
                    echo '<script>console.log('.$index_jumlah.' <= '.$data['stok'].')</script>';
                }
            }

            if ($pembayaran >= $total) {
                $isPembayaran = true;
                echo '<script>console.log('.$pembayaran.' >= '.$total.')</script>';
            }
            
            $checkQuery = mysqli_query($connect, "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'");
            $cek = mysqli_num_rows($checkQuery);
            if ($cek > 0) {
                echo "<script>alert('ID Transaksi sudah ada!'); window.location = 'tambah-transaksi.php';</script>";
            } else {
                if ($isStok) {
                    if ($isPembayaran) {
                            $query = mysqli_query($connect, "ALTER TABLE detail_transaksi AUTO_INCREMENT = 1");
                            $query = mysqli_query($connect, "INSERT INTO transaksi VALUES ('$id_transaksi', '$nama_pembeli', CURRENT_TIME(), '$total', '$pembayaran', (SELECT id_user FROM user WHERE username = '$username'), '$usia', '$no_hp');");
                            if ($query) {
                            for ($i=0; $i < count($obat); $i++) {
                                $index_obat = $obat[$i];
                                $index_jumlah = $jumlah[$i];
                                $query = mysqli_query($connect, "INSERT INTO detail_transaksi (id_transaksi, obat, jumlah, harga) VALUES ((SELECT id_transaksi FROM transaksi WHERE id_transaksi = '$id_transaksi' LIMIT 1), '$index_obat', '$index_jumlah', (SELECT harga FROM obat WHERE id_obat = '$index_obat') * '$index_jumlah');");
                                $query2 = mysqli_query($connect, "UPDATE obat SET stok = stok - '$index_jumlah' WHERE id_obat = '$index_obat'");
                                $query3 = mysqli_query($connect, "INSERT INTO barang_keluar (nama_obat, jumlah) VALUES ((SELECT nama_obat FROM obat WHERE id_obat = '$index_obat'), '$index_jumlah')");
                            }
                            session_abort();
                            header("Location: transaksi.php");
                        } else {
                            echo "Gagal menginputkan data.";
                        }
                    } else {
                        echo "<script>alert('Pembayaran tidak mencukupi!'); window.location = 'tambah-transaksi.php';</script>";
                    }
                } else {
                    echo "<script>alert('Stok tidak mencukupi!'); window.location = 'tambah-transaksi.php';</script>";
                }
            }
        }
    ?>
    <?php include("sidebar.php"); ?>
    <div id="content-top-bar">
    <?php include("top-bar.php"); ?>
        <div id="content">
            <div id="table">
                <h1>Transaksi Obat</h1>
                <hr>
                <form method="post">
                    <div id="tambah-transaksi-input-pembeli">
                        <div class="form-group">
                            <div>
                                <label for="nama_pembeli">Nama Pembeli:<span class="required">*</span> </label>
                            </div>
                            <div>
                                <input type="text" name="nama_pembeli" id="nama_pembeli" required placeholder="Budi">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="id_transaksi">ID Transaksi:<span class="required">*</span> </label>
                            </div>
                            <div>
                                <input type="text" name="id_transaksi" id="id_transaksi" required placeholder="0001">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="usia">Usia:<span class="required">*</span> </label>
                            </div>
                            <div>
                                <input type="number" inputmode="numeric" name="usia" id="usia" required placeholder="17">
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="no_hp">No. Telepon:<span class="required">*</span> </label>
                            </div>
                            <div>
                                <input type="text" name="no_hp" id="no_hp" required placeholder="081234567890">
                            </div>
                        </div>
                    </div>

                    <table table width="95%">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                                <th class="overflow-width"></th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>
                                <td>
                                    <select name="nama_obat[]" onchange="UpdateTable()">
                                        <option value="0">--Pilih--</option>
                                        <?php
                                            include("config.php");
                                            $query = mysqli_query($connect, "SELECT * FROM obat ORDER BY id_obat ASC");
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                        <option value="<?php echo $data['id_obat']; ?>"><?php echo $data['nama_obat']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" name="stok[]" readonly></td>
                                <td><input type="text" name="harga_satuan[]" disabled></td>
                                <td><input type="number" inputmode="numeric" name="jumlah[]" onkeyup="UpdateTable()" required></td>
                                <td><input type="text" name="subtotal[]" disabled></td>
                                <td><button type="button" class="row-delete-button background-delete" onclick="HapusObat()">Hapus</button></td>
                            </tr>
                            <tr id="form-row"></tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" align="right">Total</td>
                                <td><input type="text" name="total" id="total" readonly></td>
                                <td></td>
                                <td class="overflow-width"></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Bayar</td>
                                <td><input type="text" name="pembayaran" id="pembayaran" onkeyup="HitungKembalian()" required></td>
                                <td></td>
                                <td class="overflow-width"></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Kembalian</td>
                                <td><input type="text" name="kembalian" id="kembalian" readonly></td>
                                <td></td>
                                <td class="overflow-width"></td>
                            </tr>
                            <tr>
                                <td colspan="6" align="center">
                                    <button type="button" onclick="TambahObat()" class="background-add">Tambah Produk</button>
                                    <input type="submit" name="submit" id="submit">
                                </td>
                                <td class="overflow-width"></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script>
        function TambahObat() {
            var formRow = document.getElementById("form-row"); // Mengambil table row yang kosong dengan id form-row
            var tr = document.createElement("tr"); // Membuat element tr
            
            tr.innerHTML = `<td>
                                    <select name="nama_obat[]" onchange="UpdateTable()">
                                        <option value="0">--Pilih--</option>
                                        <?php
                                            include("config.php");
                                            $query = mysqli_query($connect, "SELECT * FROM obat ORDER BY id_obat ASC");
                                            while($data = mysqli_fetch_array($query)){
                                        ?>
                                        <option value="<?php echo $data['id_obat']; ?>"><?php echo $data['nama_obat']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" name="stok[]" readonly></td>
                                <td><input type="text" name="harga_satuan[]" disabled></td>
                                <td><input type="number" inputmode="numeric" name="jumlah[]" onkeyup="UpdateTable()" required></td>
                                <td><input type="text" name="subtotal[]" disabled></td>
                                <td><button type="button" class="row-delete-button background-delete" onclick="HapusObat()">Hapus</button></td>`; // Menduplikat row yang sama untuk form obat
            formRow.parentNode.insertBefore(tr, formRow.nextElementSibling); // Memasukkan row yang sudah diduplikat ke dalam table setelahnya
            UpdateTable(); // Memanggil fungsi UpdateTable() untuk mengupdate table setelah form ditambahkan
        }
        
        function HapusObat() {
            var buttons = document.getElementsByClassName("row-delete-button"); // Mengambil semua button dengan class "row-delete-button"
            function handleClick(event) { // Membuat fungsi untuk menghapus form
                var buttonIndex = Array.from(buttons).indexOf(event.target); // Mengambil index button yang diklik
                buttons[buttonIndex].parentNode.parentNode.remove(); // Menghapus row yang pada index button yang diklik
            }

            for (var i = 0; i < buttons.length; i++) {
                buttons[i].addEventListener("click", handleClick); // Menambahkan event listener untuk setiap button delete
            }
            
            UpdateTable(); // Memanggil fungsi UpdateTable() untuk mengupdate table setelah form dihapus
        }

        function UpdateTable() {
            var jumlah_field = document.getElementsByName("jumlah[]"); // Baris 211-216 mengambil field berdasarkan nama-nama form
            var harga = document.getElementsByName("harga_satuan[]");
            var subtotal = document.getElementsByName("subtotal[]");
            var id_obat = document.getElementsByName("nama_obat[]");
            var stok = document.getElementsByName("stok[]");
            var jumlah = document.getElementsByName("jumlah[]");

            for (let i = 0; i < stok.length; i++) { // membuat pengulangan untuk mengambil value masing-masing field
                if (id_obat[i].value != 0) {
                    jumlah[i].disabled = false; // Apabila bukan obat seperti <option value="0">--Pilih--</option> maka field "jumlah" akan diaktifkan
                    <?php
                        include("config.php"); // Mengambil koneksi database
                        $query = mysqli_query($connect, "SELECT * FROM obat ORDER BY id_obat ASC"); // Mengambil data dari tabel obat
                        while($data = mysqli_fetch_array($query)){ // Baris 224 membuat perulangan seluruh row tabel obat
                    ?>
                    if (id_obat[i].value == "<?php echo $data['id_obat']; ?>") { // Baris 226 memeriksa id_obat yang sama dengan row yang ada di database maka akan menggunakan data dari row tersebut
                        stok[i].value = "<?php echo $data['stok']; ?>";
                        harga[i].value = "<?php echo $data['harga']; ?>";
                        subtotal[i].value = jumlah[i].value != "" && jumlah[i].value != 0 ? parseInt(jumlah[i].value) * "<?php echo $data['harga']; ?>" : 0;  // Apabila blank atau 0, maka subtotal akan bernilai 0
                    }
                    <?php } ?>
                } else { // Apabila id_obat bernilai 0 maka field akan direset
                    stok[i].value = "0"; 
                    harga[i].value = "0";
                    subtotal[i].value = "0";
                    jumlah[i].value = "0";
                    jumlah[i].disabled = true;
                    document.getElementById("total").value = "0";
                }
            }
            document.getElementById("total").value = calculateTotal(); // Menghitung total dari semua subtotal di functino calculateTotal()
            HitungKembalian();
            tableOffSet();
        }

        function calculateTotal() {
            var subtotal = document.getElementsByName("subtotal[]"); // Mengambil semua field dengan name subtotal[]
            var total = 0; // Default value total 0
            for (let i = 0; i < subtotal.length; i++) {
                total += parseInt(subtotal[i].value); // Menjumlahkan semua subtotal
            }
            return total; // Mengembalikan nilai total
        }

        function HitungKembalian() {
            var pembayaran = document.getElementById("pembayaran").value; // Mengambil value dari field pembayaran
            var total = document.getElementById("total").value; // Mengambil value dari field total
            var kembalian = document.getElementById("kembalian"); // Mengambil field kembalian
            var check = false; 
            kembalian.value = pembayaran - total; // Terserah, ini cuma ngecek kalau kembaliannya kurang dari 0 warnanya merah
            if (kembalian.value < 0) {
                kembalian.style.backgroundColor = "#f8d7da";
                check = true;
            } else {
                kembalian.style.backgroundColor = "#e9ecef";
            }
            return check;
        }

        function CheckAvaibleId() {
            var id_transaksi = document.getElementById("id_transaksi").value; 
            var check = false;
            <?php
                include("config.php");
                $query = mysqli_query($connect, "SELECT id_transaksi FROM transaksi");
                while($data = mysqli_fetch_array($query)){
                    $id_detail_transaksi = $data['id_transaksi'];
                    ?>
                    if (id_transaksi == "<?php echo $id_detail_transaksi; ?>") {
                        check = true;
                    }
                    <?php
                }
            ?>
            return check;
        }

        function tableOffSet() { // Buat ngatur ulang ukuran tabel
            var tbody = document.querySelector('tbody');
            var thead = document.querySelector('thead');
            var tfoot = document.querySelector('tfoot');
            var tr = document.querySelector('tbody tr');
    
            if (tbody && thead && tfoot && tr) {
                tbody.style.height = 'calc(100% - ' + (thead.offsetHeight + tfoot.offsetHeight + tr.offsetHeight) + 'px)';
                if (tbody.offsetHeight > 250) {
                    tbody.style.height = '250px';
                }
            }
        }

        UpdateTable();
        tableOffSet();
    </script>

<style>
        table {
            margin-top: 0px;
        }

        tbody{
            display:block;
            height:182px;
            overflow-y:scroll;
        }
        thead, tbody tr, tfoot {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        thead {
            width: calc( 100% + 0.1em )
        }

        tfoot {
            width: calc( 100% + 0.05em )
        }

        thead .overflow-width {
            width: 1.15em;
        }

        tfoot .overflow-width {
            width: 1.1em;
        }

        tbody::-webkit-scrollbar {
            width: 1.1em;
        }
        tbody::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        }
        tbody::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
        }

        tbody tr td input, tbody tr td select, tfoot tr td input[type="text"] {
            width: 100%;
            padding: 1px 4px;
        }

        input:disabled {
            background-color: #e9ecef;
        }

        input:read-only {
            background-color: #e9ecef;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 1rem;
        }

        .form-group div {
            display: flex;
            flex-direction: row;
            margin-right: rem;
        }

        .form-group input[type="text"], .form-group input[type="number"] {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            width: 260px;
        }

        .form-group input[type="text"]:focus, .form-group input[type="number"]:focus {
            border-color: #80bdff;
            outline: 0;
        }
    </style>
</body>
</html>
