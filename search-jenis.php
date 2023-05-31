<?php
    include("config.php");

    $search = $_GET['search'];
    $query = "SELECT * FROM jenis WHERE nama_jenis LIKE '%$search%' OR id_jenis LIKE '%$search%'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) > 0){
        $no = 1;
        while($data = mysqli_fetch_array($result)){
            echo '<tr>
                    <td align="center">'.$no++.'</td>
                    <td align="center">'.$data['id_jenis'].'</td>
                    <td>'.$data['nama_jenis'].'</td>
                    <td align="center">
                        <a href="#" onclick="popupEdit(\''.$data['id_jenis'].'\', \''.$data['nama_jenis'].'\')"><button class="background-edit">Edit</button></a>
                        <a href="delete-jenis.php?id='.$data['id_jenis'].'"><button class="background-delete">Hapus</button></a>
                    </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
    }
?>