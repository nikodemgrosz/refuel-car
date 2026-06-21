<?php
    if(isset($_POST['submit']))
    {
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];
            $email = $_POST['email'];
            $marka = $_POST['marka'];
            $model = $_POST['model'];
            $zdjecie = $_POST['zdjecie'];

            $hash = password_hash($haslo, PASSWORD_DEFAULT);

            $connect = new PDO(
                'mysql:host=localhost; dbname=refueling',
                'root',
                ''
            );

            $dodaj = $connect->prepare("INSERT INTO users (login, password, email) VALUES (:login, :password,:email)");
            $dodaj->bindValue(':login', $login, PDO::PARAM_STR);
            $dodaj->bindValue(':password', $hash, PDO::PARAM_STR);
            $dodaj->bindValue(':email', $email, PDO::PARAM_STR);
            $dodaj->execute();
            $ownerid = $connect -> lastInsertId();
            $dodajdocar = $connect ->prepare("INSERT INTO cars (brand,model,image,owner_id) VALUES(:brand,:model,:image,:owner_id) ");
            $dodajdocar -> bindValue(':brand',$marka,PDO::PARAM_STR);
            $dodajdocar -> bindValue(':model',$model,PDO::PARAM_STR);
            $dodajdocar -> bindValue(':image',$zdjecie,PDO::PARAM_STR);
            $dodajdocar -> bindValue(':owner_id',$ownerid,PDO::PARAM_STR);
            $dodajdocar -> execute();

            
            header('location:login.php');
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utwórz konto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="log">
         <form action="" method="post">
        <h1>Zarejestruj się</h1>
        <label for="login">Login: </label><br>
        <input type="text" name="login" required><br>

        <label for="haslo">Hasło: </label><br>
        <input type="password" name="haslo" required><br>

        <label for="email">E-mail: </label><br>
        <input type="text" name="email" required><br>

        <label for="marka">Marka pojazdu: </label><br>
        <input type="text" name="marka" required><br>

        <label for="model">Model pojazdu: </label><br>
        <input type="text" name="model" required><br>

        <label for="zdjecie">Zdjęcie: </label><br>
        <input type="text" name="zdjecie" required><br><br>
        <input type="submit" value="ZAREJESTRUJ!" name="submit" id="submit">
    </form>    
    <div>
</body>
</html>