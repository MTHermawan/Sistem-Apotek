<div class="grafik">
    <div><h2>Penjualan Seminggu Terakhir</h2><hr></div>
    <div>
        <!-- <select name="chartType" id="chartType">
            <option value="bar">Bar</option>
            <option value="line">Line</option>
            <option value="pie">Pie</option>
        </select> -->
    </div>
    <div id="div_chart"><canvas id="myChart"></canvas></div>
</div>

<script src="chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            <?php
                $date = date('Y-m-d');
                $date = date('Y-m-d', strtotime($date . "- 0 days"));
                $currentDay = date('D', strtotime($date));
                $dayOrder = ['Mon', 'Sun', 'Sat', 'Fri', 'Thu', 'Wed', 'Tue'];
                $currentIndex = array_search($currentDay, $dayOrder);
                for ($i = 0; $i < 7; $i++) {
                    $day = $dayOrder[$currentIndex];
                    switch($day){
                        case 'Sun':
                            $day = 'Minggu';
                            break;
                        case 'Mon':
                            $day = 'Senin';
                            break;
                        case 'Tue':
                            $day = 'Selasa';
                            break;
                        case 'Wed':
                            $day = 'Rabu';
                            break;
                        case 'Thu':
                            $day = 'Kamis';
                            break;
                        case 'Fri':
                            $day = 'Jumat';
                            break;
                        case 'Sat':
                            $day = 'Sabtu';
                            break;
                    }
                    echo "'".$day."',";
                    $currentIndex = ($currentIndex + 1) % 7;
                }
            ?>
        ],
        datasets: [{
            label: 'Total Penjualan',
            backgroundColor: ['red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink'],
            borderColor: ['red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink'],
            data: [
                <?php
                        include("config.php");
                        $query = mysqli_query($connect, "SELECT DATE(tanggal_transaksi) AS tanggal, SUM(total_harga) AS total_harga FROM transaksi WHERE tanggal_transaksi >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(tanggal_transaksi)");
                        $dayCounter = 0;
                        $totalHarga = array(); // Menggunakan array untuk menyimpan total harga setiap hari
                        setlocale(LC_ALL, 'id-ID', 'id_ID');
                        while ($data = mysqli_fetch_array($query)) {
                            $tanggal = strtotime($data['tanggal']);
                            $hari = strftime('%A', $tanggal);
                        
                            // Mengonversi nama hari dalam Bahasa Inggris menjadi Bahasa Indonesia
                            switch ($hari) {
                                case 'Sunday':
                                    $hari = 'Minggu';
                                    break;
                                case 'Monday':
                                    $hari = 'Senin';
                                    break;
                                case 'Tuesday':
                                    $hari = 'Selasa';
                                    break;
                                case 'Wednesday':
                                    $hari = 'Rabu';
                                    break;
                                case 'Thursday':
                                    $hari = 'Kamis';
                                    break;
                                case 'Friday':
                                    $hari = 'Jumat';
                                    break;
                                case 'Saturday':
                                    $hari = 'Sabtu';
                                    break;
                            }
                        
                            // Menyimpan total harga untuk setiap hari dalam array
                            $totalHarga[$hari] = $data['total_harga'];
                        }
                        
                        // Mengisi data total harga untuk setiap hari dalam grafik
                        $currentIndex = array_search($currentDay, $dayOrder);
                        for ($i = 0; $i < 7; $i++) {
                            $day = $dayOrder[$currentIndex];
                            switch($day){
                                case 'Sun':
                                    $day = 'Minggu';
                                    break;
                                case 'Mon':
                                    $day = 'Senin';
                                    break;
                                case 'Tue':
                                    $day = 'Selasa';
                                    break;
                                case 'Wed':
                                    $day = 'Rabu';
                                    break;
                                case 'Thu':
                                    $day = 'Kamis';
                                    break;
                                case 'Fri':
                                    $day = 'Jumat';
                                    break;
                                case 'Sat':
                                    $day = 'Sabtu';
                                    break;
                            }
                        
                            if (isset($totalHarga[$day])) {
                                echo $totalHarga[$day].",";
                            } else {
                                echo "0,";
                            }
                            $currentIndex = ($currentIndex + 1) % 7;
                        }
                        
                    ?>
            ]
        }],
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false,
            }
        }
    }
});



    function getRandomColors(count) {
        var colors = [];
        for (var i = 0; i < count; i++) {
            var color = 'rgb(' + getRandomNumber(0, 255) + ',' + getRandomNumber(0, 255) + ',' + getRandomNumber(0, 255) + ')';
            colors.push(color);
        }
        return colors;
    }

    function getRandomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // var chartType = document.getElementById('chartType');
    // chartType.addEventListener('change', function(){
    //     chart.destroy();
    //     chart = new Chart(ctx, {
    //         type : this.value,
    //         data : {
    //             labels: [
    //                 <?php
    //                     include("config.php");
    //                     $query = mysqli_query($connect, "SELECT * FROM obat");
    //                     while($data = mysqli_fetch_array($query)){
    //                         echo "'".$data['nama_obat']."',";
    //                     }
    //                 ?>
    //             ],
    //             datasets: [{
    //                 label: 'Jumlah Stok',
    //                 backgroundColor: ['red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink'],
    //                 borderColor: ['red', 'blue', 'green', 'yellow', 'orange', 'purple', 'pink'],
    //                 data: [
    //                     <?php
    //                         include("config.php");
    //                         $query = mysqli_query($connect, "SELECT * FROM obat");
    //                         while($data = mysqli_fetch_array($query)){
    //                             echo $data['stok'].",";
    //                         }
    //                     ?>
    //                 ]
    //             }]
    //         },
    //         options: {
    //             responsive: true,
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     });
    // });
</script>

<script src="chart.js"></script>
