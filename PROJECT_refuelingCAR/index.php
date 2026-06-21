
<?php
session_start();

if(!isset($_SESSION['zalogowany'])
|| $_SESSION['zalogowany'] == false){

    echo "Strona dla zalogowanych użytkowników.<br>";
    echo "<a href='login.php'>Zaloguj się jeszcze raz!</a></div>";
    exit();
}

$connect = new PDO(
    'mysql:host=localhost; dbname=refueling',
    'root',
    ''
);
$zapytanie = $connect -> prepare("SELECT id FROM cars WHERE owner_id =:id" );
$zapytanie -> bindValue(':id',$_SESSION['userid'],PDO::PARAM_INT);
$zapytanie -> execute();
$fetch = $zapytanie -> fetch();
$_SESSION['carid'] = $fetch['id'];
//1
    $marka = $connect -> prepare("SELECT brand FROM cars WHERE owner_id = :idcara");
    $marka -> bindValue(':idcara', $_SESSION['userid'],PDO::PARAM_INT);
    $marka -> execute();
    $marka1 = $marka -> fetch();
//2
    $model= $connect -> prepare("SELECT model FROM cars WHERE owner_id = :idcara");
    $model-> bindValue(':idcara', $_SESSION['userid'],PDO::PARAM_INT);
    $model -> execute();
    $model1 = $model-> fetch();
//3
    $image= $connect -> prepare("SELECT image FROM cars WHERE owner_id = :idcara");
    $image-> bindValue(':idcara', $_SESSION['userid'],PDO::PARAM_INT);
    $image -> execute();
    $image1 = $image-> fetch();

    //odejmowanie przebiegu

    // $przebieg1 = $connect -> prepare("SELECT * FROM refuelings WHERE car_id = :carIdZsesji ORDER BY date DESC LIMIT 1;");
    // $przebieg1 -> bindValue(':carIdZsesji', $_SESSION['carid'],PDO::PARAM_INT);
    // $przebieg1 -> execute();
    // $przeb1 = $przebieg1 -> fetch();

    // $przebieg2 = $connect -> prepare("SELECT * FROM refuelings WHERE car_id = :carIdZsesjidwa ORDER BY date  LIMIT 1;");
    // $przebieg2 -> bindValue(':carIdZsesjidwa', $_SESSION['carid'],PDO::PARAM_INT);
    // $przebieg2 -> execute();
    // $przeb2 = $przebieg2 -> fetch();

    // $dystans = $przeb2['mileage'] - $przeb1['mileage'];
    $danetabelki = $connect -> prepare("SELECT `date` , `amount`, `mileage`, `cost`, `cost_per_liter` FROM `refuelings` WHERE car_id = :idzsesji ORDER BY `date`;");
    $danetabelki -> bindValue(':idzsesji',$_SESSION['carid'],PDO::PARAM_STR);
    $danetabelki -> execute();

        $tabela = $danetabelki -> fetchAll(PDO::FETCH_ASSOC);
      
    //statystyki
    $statystyki = $connect -> prepare("SELECT 
        SUM(amount)-amount AS `spalonepaliwo`,
        SUM(cost)-cost AS `iletankowan`,
        MAX(mileage)-MIN(mileage) AS `dystans`,
        COUNT(id) AS `liczba`
        FROM `refuelings` WHERE car_id = :aktualneid ORDER BY `date` ASC;");

         $statystyki -> bindValue(':aktualneid',$_SESSION['carid']);
        $statystyki -> execute();
        $stats = $statystyki -> fetchAll();
        

       




?>  



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
   <link rel="stylesheet" href="glowna.css">
</head>
<body>

    <nav>
        <p>
        <?php
            echo "Witaj ".$_SESSION['login']." !";
        ?>
        </p>
        <a href="wyloguj.php" id="wyloguj">Wyloguj się!</a>
    </nav>
    <main>
        <div>
            <div id="image">
                <img src=" <?php
                        echo $image1['image'];
                    ?>"

             
                alt="car">
            </div>
            <div>
                <h2 id="danepojazdu">Dane pojazdu:</h2><br>
                <h2 id="marka">Marka: </h2>
                <p id="inline">
                    <?php
                        echo $marka1['brand'];
                    ?>
                </p>
                <br> <br>  <br>
                <h2 id="marka2">Model: </h2>
                <p id="inline">
                <?php
                        echo $model1['model'];
                ?>
                </p>
            </div>
            <div>
                <?php
                   foreach($stats as $dane){
                    echo "<p id='stats'>STATYSTYKI:</p>";
                    if($dane['liczba'] >= 2){
                    echo "<p id='srednie'>ŚREDNIE SPALANIE NA 100KM WYNOSI: ".'<p id="licz">'.round($dane['spalonepaliwo']/$dane['dystans']*100,1).'</p>'." <p id='srednie'>litra<p/>";
                    echo "<p id='srednie'>ŚREDNIE CENA ZA 1 KM JAZDY: ".'<p id="licz">'.round($dane['iletankowan']/$dane['dystans'],2).'</p>'." <p id='srednie'>zł<p/>";
                }
                else{
                    echo "BRAK  DANYCH NA TEMAT AUTA!";
                }
            };
            
                ?>
            </div>
            <div>
                <a href="tankowanie.php" id="zatankuj">Zatankuj!</a>
                <a href="rejestracja.php" id="zatankuj">Zarejestruj się!</a>
            </div>
        </div>
        <div>
             <table id="tabelka">
            <th>DATA</th><th>ILOŚĆ</th><th>STAN LICZNIKA</th><th>SUMA</th><th>CENA ZA LITR</th>
                <?php
                      foreach($tabela as $info){
                        echo '<tr>';
                        echo "<td>".$info['date']."</td>";
                        echo "<td>".$info['amount']."</td>";
                        echo "<td>".$info['mileage']."</td>";
                        echo "<td>".$info['cost']."</td>";
                        echo "<td>".$info['cost_per_liter']."</td>";
                    }
                ?>
            </table>
        </div>
    </main>

   
 
</body>
</html>