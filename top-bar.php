<div id="top-bar">
    <div id="top-bar1">
        <?php echo "<h3 style='color: #333''>Selamat datang, " . $_SESSION['username']."</h3>";?>
    </div>
    <!-- <div id="top-bar2">
        <h3 id="clock"></h3>
    </div> -->
    <div id="top-bar3">
        <a href="logout.php"><button class="background-delete">Logout</button></a>
    </div>
</div>

<script>
    function checkTime(i)
    {
        if (i < 10) {i = "0" + i};
        return i;
    }

    function startTime()
    {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    // startTime();
</script>