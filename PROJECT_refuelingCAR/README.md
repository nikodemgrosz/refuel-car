# Asystent paliwowy 🚗⛽

Mój projekt zaliczeniowy. Służy do kontrolowania wydatki na paliwo – wpisujesz tankowania, a aplikacja sama wylicza statystyki.

## Co to robi?
* **Logowanie i rejestracja** – zakładasz konto, od razu podajesz dane swojego auta (marka, model, zdjęcie) i nikt obcy nie podejrzy Twoich danych.
* **Dodawanie tankowań** – wpisujesz datę, litry, przebieg i cenę. Skrypt sam wyliczy koszt za 1 litr paliwa i zapisze to w historii.
* **Statystyki** – po dodaniu minimum 2 tankowań na stronie głównej zobaczysz swoje średnie spalanie na 100 km oraz ile kosztuje Cię przejechanie 1 km.

## Jak to odpalić?
1. Wrzuć cały folder z plikami do XAMPPa, do folderu `htdocs`.
2. Odpal w XAMPPie **Apache** i **MySQL**.
3. Wejdź na `localhost/phpmyadmin/`, stwórz bazę o nazwie `tankowanie` i zaimportuj do niej plik `refueling.sql`.
4. Otwórz w przeglądarce: `http://localhost/NAZWA_TWOJEGO_FOLDERU/login.php`.

## Zrobione w:
PHP (PDO), MySQL, HTML i CSS.