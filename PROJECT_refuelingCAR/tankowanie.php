<?php
session_start();
if(!isset($_SESSION['zalogowany'])
|| $_SESSION['zalogowany'] == false){
    echo "<p>Strona dla zalogowanych!!! </p><br>";
    echo "<a href='login.php'>Zaloguj się jeszcze raz!</a>";
    exit();
}
if(isset($_POST['submit'])){
    $connection = new PDO('mysql:host=localhost;dbname=refueling;', 'root', '');
    $data = $_POST['data'];
    $ilosclitrow = $_POST['ilosc'];
    $przebieg = $_POST['przebieg'];
    $koszt = $_POST['koszt'];
    $litr = $koszt/$ilosclitrow;

    $carQuery = $connection->prepare("SELECT id FROM cars WHERE owner_id = :id");
    $carQuery->bindValue(':id', $_SESSION['userid'], PDO::PARAM_INT);
    $carQuery->execute();
    $carFetch = $carQuery->fetch();
    $carid = $carFetch['id'];

    $query = $connection -> prepare('INSERT INTO `refuelings`(`date`,`amount`,`mileage`,`cost`,`cost_per_liter`,`car_id`)
                        VALUES(:date,:amount,:mileage,:cost,:costperliter,:carid)');
    $query -> bindValue(':date',$data,PDO::PARAM_STR);
    $query -> bindValue(':amount',$ilosclitrow,PDO::PARAM_INT);
    $query -> bindValue(':mileage',$przebieg,PDO::PARAM_INT);
    $query -> bindValue(':cost',$koszt,PDO::PARAM_INT);
    
    
    $query -> bindValue(':costperliter',$litr,PDO::PARAM_STR); 
    
    $query -> bindValue(':carid',$carid,PDO::PARAM_INT);
    $query -> execute();
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj tankowanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="log">
        <form action="" method="POST">
    <h1>Dodaj tankowanie</h1>
    <label for="data">Data tankowania</label><br>
    <input type="date" name="data"><br>

    <label for="ilosc">Ilośc paliwa [l]</label><br>
    <input type="number" name="ilosc"><br>

    <label for="przebieg">Przebieg pojazdu</label><br>
    <input type="number" name="przebieg"><br>

    <label for="koszt">Koszt tankowania</label><br>
    <input type="number" name="koszt"><br><br>
    <input type="submit" value="DODAJ!" name="submit">
</div>
</form>

</body>
</html>