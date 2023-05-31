<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include("config.php");
$result = mysqli_query($connect, "SHOW COLUMNS FROM obat LIKE 'status'");

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Mendapatkan nilai ENUM dari hasil query
    $enumValues = explode("','", preg_replace("/(enum|set)\('(.+?)'\)/", "\\2", $row['Type']));
}
?>

<select name="status" id="status">
    <?php foreach ($enumValues as $value) : ?>
        <option value="<?php echo $value ?>"><?php echo $value ?></option>
    <?php endforeach; ?>
</select>

</body>
</html>