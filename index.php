<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link type="text/css" rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <div id="content">
        <form method="post">
            <div id="login-container">
                <div><h1>Login</h1><div>
                <div>    
                    <label for="username">Username: </label>
                    <input type="text" name="username" placeholder="Username" required></input>
                </div>
                <div>    
                    <label for="username">Password: </label>
                    <input type="text" name="password" placeholder="Password" required></input>
                </div>
                <div>    
                    <button type="submit" name="submit" onclick="disableAlert()" required class="background-detail">Login</button>
                </div>
                <div id="alert"></div>
            </div>
        </form>
    </div>

    <?php
        if(isset($_POST['submit'])){
            include "config.php";
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = mysqli_query($connect, "SELECT * FROM user WHERE username = '$username' AND `password` = '$password'");
            if ($query) {
                $data = mysqli_fetch_array($query);
                if ($data) {
                    if ($data['id_level'] == "1") {
                        header("Location: dashboard.php");
                    } else if ($data['id_level'] == "2") {
                        header("Location: obat.php");
                    }
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['level'] = $data['id_level'];
                } else {
                    echo "<script>document.getElementById('alert').style.display = 'inline';document.getElementById('alert').innerHTML = 'Username atau password salah'</script>";
                }
            }
        }
    ?>
</body>
</html>

<script>
    function disableAlert() {
        document.getElementById('alert').style.display = 'none';
    }
    localStorage.setItem('openDropdown', '');
</script>

<style>
    body {
        background-color: #f1f1f1;
    }

    #content {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }

    #login-container {
        display: flex;
        background-color: #fff;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 30px 50px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.25);
        margin: 0 auto;
    }

    #login-container div {
        margin: 10px 0;
        display: flex;
        flex-direction: column;
    }

    #login-container div h1 {
        text-align: center;
    }

    #login-container div label {
        margin-bottom: 5px;
    }

    #login-container div input {
        padding: 10px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 250px;
    }

    #login-container div button {
        padding-bottom: 12px;
        padding-top: 12px;
        margin: 5px 0px 0px 0px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 250px;
        cursor: pointer;
    }

    #login-container div #alert {
        text-align: center;
        margin-bottom: 0px;
        display: none;
    }
</style>