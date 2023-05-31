<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div id="sidebar">
    <div id="sidebar-content">
        <div id="sidebar-logo">
            <h1>Appotek</h1>
        </div>
        <br>
        <div id="sidebar-nav">
            <a href="dashboard.php">
                <div id="sidebar-dashboard" class="sidebar-item <?php if ($current_page == 'dashboard.php') echo ' active'; ?>">Dashboard</div>
            </a>
            <a href="obat.php">
                <div id="sidebar-obat" class="sidebar-item <?php if ($current_page == 'obat.php') echo ' active'; ?>">Obat</div>
            </a>

            <div id="sidebar-master-data">
                <div class="sidebar-master-item">
                    <a href="#" class="dropdown-toggle">Master Data<span class="arrow">&#9660;</span></a>
                    <div class="dropdown-content" style="height: 0px">
                        <a href="kategori-obat.php" class="<?php if ($current_page == 'kategori-obat.php') echo 'active-dropdown'; ?>">Kategori Obat</a>
                        <a href="lokasi-obat.php" class="<?php if ($current_page == 'lokasi-obat.php') echo 'active-dropdown'; ?>">Lokasi Obat</a>
                        <a href="jenis-obat.php" class="<?php if ($current_page == 'jenis-obat.php') echo 'active-dropdown'; ?>">Jenis Obat</a>
                    </div>
                </div>
            </div>

            <a href="transaksi.php">
                <div id="sidebar-transaksi" class="sidebar-item <?php if ($current_page == 'transaksi.php') echo ' active'; ?>">Transaksi</div>
            </a>
            <a href="tambah-transaksi.php">
                <div id="sidebar-tambah-transaksi" class="sidebar-item <?php if ($current_page == 'tambah-transaksi.php') echo ' active'; ?>">Tambah Transaksi</div>
            </a>
            <!-- <a href="laporan.php">
                <div id="sidebar-laporan" class="sidebar-item <?php if ($current_page == 'laporan.php') echo ' active'; ?>">Laporan</div>
            </a> -->
            <!-- <a href="laporan-stok.php">
                <div id="sidebar-laporan-stok" class="sidebar-item <?php if ($current_page == 'laporan-stok.php') echo ' active'; ?>">Laporan stok</div>
            </a> -->
            <a href="user.php">
                <div id="sidebar-petugas" class="sidebar-item <?php if ($current_page == 'user.php') echo ' active'; ?>">Pengguna</div>
            </a>
            <a href="karyawan.php">
                <div id="sidebar-karyawan" class="sidebar-item <?php if ($current_page == 'karyawan.php') echo ' active'; ?>">Karyawan</div>
            </a>
        </div>
    </div>
</div>

<style>
    .dropdown-content {
        display: block;
        background-color: #555;
        min-width: 0px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        transition: all 0.3s;
        height: 0px;
        overflow: hidden;
    }

    #sidebar-master-data a {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: 10px 40px;
        width: 100%;
        height: 60px;
        font: 16px Arial, sans-serif;
    }

    .sidebar-master-item a:hover {
        cursor: pointer;
        background-color: #292929;
    }

    .dropdown-content a {
        color: black;
        padding: 16px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        color: white;
    }

    .sidebar-master-item .arrow {
        transition: transform 0.3s;
    }

    .sidebar-master-item.open .arrow {
        transform: rotate(180deg);
    }
</style>

<script>
    // Toggle dropdown on click
    var dropdownToggle = document.querySelectorAll('.dropdown-toggle');
    var master_data = document.getElementById("sidebar-master-data");
    dropdownToggle.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            var dropdownContent = this.nextElementSibling;
            var dropdownContentAnchor = dropdownContent.querySelector('a');
            this.parentNode.classList.toggle('open');
            dropdownContent.style.height = dropdownContent.style.height == '0px' ? dropdownContent.querySelector('a').offsetHeight * dropdownContent.querySelectorAll('*').length + 'px' : '0px';
            console.log(dropdownContent.style.marginBottom);
            if (this.parentNode.classList.contains('open')) {
                localStorage.setItem('openDropdown', 'sidebar-master-data');
            } else {
                localStorage.setItem('openDropdown', '');
            }
            console.log(this);
        });
    });

    var dropdownContent = document.getElementById('sidebar-master-data').querySelector('.dropdown-content');
    if (dropdownContent.querySelector('.active-dropdown')) {
        document.getElementById('sidebar-master-data').querySelector('.dropdown-toggle').style.borderLeft = '3px solid #3a8ce3';
        document.getElementById('sidebar-master-data').querySelector('.dropdown-toggle').style.color = '#3a8ce3';
        document.getElementById('sidebar-master-data').querySelector('.dropdown-toggle').style.paddingLeft = '37px';
        console.log("success");
    }    

    window.addEventListener('DOMContentLoaded', function() {
        var openDropdown = localStorage.getItem('openDropdown');
        if (document.getElementById(openDropdown) != null) {
            var dropdownContent = document.getElementById(openDropdown).querySelector('.dropdown-toggle').nextElementSibling;
        }

        if (dropdownContent) {
            dropdownContent.style.height = 'auto';
            dropdownContent.style.marginBottom = 'auto';
            dropdownContent.parentNode.classList.add('open');
            if (dropdownContent.style.height == 'auto') {
                dropdownContent.style.height = dropdownContent.querySelector('a').offsetHeight * dropdownContent.querySelectorAll('*').length + 'px';    
            }
        }
    });


</script>

<?php
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='logout.php';</script>";
} else {
    if ($_SESSION['level'] == "01" || $_SESSION['level'] == "Administrator") {
?>
        <style>
            #sidebar-tambah-transaksi,
            #transaksi-tambah {
                display: none;
            }
        </style>
<?php
    } else if ($_SESSION['level'] == "02" || $_SESSION['level'] == "Kasir") {
        if ($current_page == "dashboard.php" || $current_page == "laporan.php" || $current_page == "laporan-stok.php" || $current_page == "user.php" || $current_page == "karyawan.php" || $current_page == "master-data.php" || $current_page == "tambah-karyawan.php" || $current_page == "tambah-user.php" || $current_page == "edit-karyawan.php" || $current_page == "edit-user.php" || $current_page == "edit-obat.php" || $current_page == "tambah-obat.php") {
            echo "<script>window.location.href='logout.php';</script>";
        }
?>
        <style>
            #sidebar-kategori,
            #sidebar-lokasi,
            #sidebar-jenis,
            #sidebar-petugas,
            #head-obat-aksi,
            #obat-aksi,
            #obat-tambah,
            #sidebar-laporan,
            #sidebar-laporan-stok,
            #sidebar-dashboard,
            #transaksi-aksi .background-delete,
            #sidebar-karyawan,
            #sidebar-master-data {
                display: none;
            }
        </style>
<?php
    }
}
?>
