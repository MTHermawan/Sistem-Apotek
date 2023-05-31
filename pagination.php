<div id="pagination">
    <?php
        $result = mysqli_query($connect, "SELECT COUNT(*) AS total FROM kategori");
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
