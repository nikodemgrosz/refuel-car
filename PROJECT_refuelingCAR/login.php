<?php
session_start();
if(isset($_POST['submit'])){
    $_SESSION['login'] = $_POST['login'];
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $connection = new PDO('mysql:host=localhost;dbname=refueling;',
    'root',
    '');

    $zapytanie = $connection -> prepare("SELECT password,id FROM users WHERE login = :login");
    $zapytanie -> bindValue(':login',$login,PDO::PARAM_STR);
    $zapytanie -> execute();
    $hash = $zapytanie -> fetch();
    if(password_verify($haslo,$hash['password'])){
        $_SESSION['zalogowany'] = true;
        $_SESSION['userid'] = $hash['id']; 
        header('location:index.php');
        exit();
    }
    else{
        $_SESSION['niezalogowany']="Blędnie podane hasło";
        echo $_SESSION["niezalogowany"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="log">
         <form action="" method="post">
        <h1 id="login">Zaloguj się</h1>  <a href="rejestracja.php" id="zatankuj">Zarejestruj się!</a><br><br>
        <label for="login">Login: </label><br>
        <input type="text" name="login"><br><br>
        <label for="haslo">Hasło: </label><br>
        <input type="password" name="haslo"><br><br>
        <input type="submit" value="ZALOGUJ SIĘ!" name="submit" id="submit">
    </form>  
    
</body>
</html>