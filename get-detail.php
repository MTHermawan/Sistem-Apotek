<?php
include("config.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query SQL untuk mendapatkan detail transaksi berdasarkan ID
    $query = "SELECT * FROM detail_transaksi INNER JOIN obat ON detail_transaksi.obat = obat.id_obat INNER JOIN transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi WHERE detail_transaksi.id_transaksi = '$id' ORDER BY detail_transaksi.id_detail_transaksi ASC;";
    $result = mysqli_query($connect, $query);

    $data = mysqli_fetch_array($result);
    setlocale(LC_ALL, 'id-ID', 'id_ID');
    $tanggal_transaksi = strftime("%e %B %Y (%H:%M", strtotime($data['tanggal_transaksi'])) . " WITA)";
    // Memformat hasil query menjadi HTML
    $html = '
    <div id="overlay" class="detail" style="justify-content: flex-start" style="height: 668px">
        <div id="title">
                <h4 style="height: 20px; align-self: flex-start;">'.$tanggal_transaksi.'</h4>
                <h1 style="margin-top: -20px;">Detail Transaksi</h1>
        </div>
        <div id="info_pembeli" style="45px">
            <h3><span class="label">Nama Pembeli</span><span class="value">: '.$data['nama_pembeli'].'</span></h3>
            <h3><span class="label">No. Referensi</span><span class="value">: #'.$id.'</h3>
            <h3><span class="label">Usia</span><span class="value">: '.$data['usia'].' Tahun</span></h3>
            <h3><span class="label">No. HP</span><span class="value">: '.$data['no_hp'].'</span></h3> 
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
                <tbody align="center">';
    $no = 1;
    $query = "SELECT * FROM detail_transaksi INNER JOIN obat ON detail_transaksi.obat = obat.id_obat WHERE id_transaksi = '$id' ORDER BY detail_transaksi.id_detail_transaksi ASC;";
    $result = mysqli_query($connect, $query);
    while ($data = mysqli_fetch_array($result)) {
        $html .= '
                    <tr>
                        <td>' . $no++ . '</td>
                        <td>' . $data['nama_obat'] . '</td>
                        <td>' . $data['jumlah'] . '</td>
                        <td>Rp' . $data['harga'] * $data['jumlah'] . '</td>
                    </tr>';
    }
    $html .= '
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right">Total</td>
                        <td align="center">';
    $query = mysqli_query($connect, "SELECT * FROM transaksi WHERE id_transaksi = '$id'");
    $data = mysqli_fetch_array($query);
    $html .= 'Rp' . $data['total_harga'] . '</td>
                        <td class="overflow-width"></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">Bayar</td>
                        <td align="center">';
    $query = mysqli_query($connect, "SELECT * FROM transaksi WHERE id_transaksi = '$id'");
    $data = mysqli_fetch_array($query);
    $html .= 'Rp' . $data['pembayaran'] . '</td>
                        <td class="overflow-width"></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">Kembalian</td>
                        <td align="center">';
    $query = mysqli_query($connect, "SELECT * FROM transaksi WHERE id_transaksi = '$id'");
    $data = mysqli_fetch_array($query);
    $data = $data['pembayaran'] - $data['total_harga'];
    $html .= 'Rp' . $kembalian  . '</td>
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
        ';

    echo $html;
}
?>
