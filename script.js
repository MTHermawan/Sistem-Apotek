
function openPopup() {
    var overlay = document.getElementById('overlay');
    overlay.style.display = 'block';
}

 function closePopup() {
    var overlay = document.getElementById('overlay');
    overlay.style.display = 'none';
}

function TambahObat() {
    var formRow = document.getElementById("form-row");
    var div = document.createElement("div");
    
    div.innerHTML = '<tr><td><select name="nama_obat[]"><option value="0">--Pilih--</option><?php $query = mysqli_query($connect, "SELECT * FROM obat ORDER BY id_obat ASC"); while($data = mysqli_fetch_array($query)){ ?><option value="<?php echo $data[\'id_obat\']; ?>"><?php echo $data[\'nama_obat\']; ?></option><?php } ?></select></td><td><input type="text" name="stok" disabled></td><td><input type="text" name="harga_satuan" disabled></td><td><input type="text" name="jumlah[]"></td><td><input type="text" name="subtotal" disabled></td><td><button>Hapus</button></td></tr>';
    formRow.appendChild(div);
}