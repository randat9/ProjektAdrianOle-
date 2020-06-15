<?php 
  session_start();

  if(!isset($_SESSION['zalogowano'])){
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PRACA</title>
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
      h2, p {
        text-align: center;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="container">
        <h1><a href="index.php">PRACA</a></h1>
        <nav>
          <ul>
            <a href='index.php'><li>PRZEGLĄDAJ</li></a>
            <a href='panel.php' class='activ'><li>PANEL UŻYTKOWNIKA</li></a>
            <a href='wyloguj.php'><li>WYLOGUJ</li></a>
          </ul>
        </nav>
      </div>
    </header>

    <div id="obrazek">
      <div class="container">
        <h1>Znajdź wymarzoną pracę</h1>
        <p>Lorem ipsum dolor sit amet, anim id est laborum.</p>
      </div>
    </div>

    <div class="container">
      <section class="rejestracja">
        <article>
          <h1>Twoje dane:</h1>
          <?php 
            require_once('connect.php');
            $zapytanie = "SELECT Imie, Nazwisko, DataUrodzenia, Login, Email FROM uzytkownik WHERE '$_SESSION[idU]' = id_Uzytkownik";

            if(!$wynik = $baza -> query($zapytanie)){
              echo "Pobranie danych z bazy nie powiodło się";
            }

            else {
              $row = $wynik -> fetch_assoc();
              
              echo "<h2>Imie: </h2><p>" . $row['Imie'] . "</p>";
              echo "<h2>Nazwisko: </h2><p>" . $row['Nazwisko'] . "</p>";
              echo "<h2>Data Urodzenia: </h2><p>" . $row['DataUrodzenia'] . "</p>";
              echo "<h2>Email: </h2><p>" . $row['Email'] . "</p>";
              echo "<br><p><a href='edycja.php?id=" . $_SESSION['idU'] . "' id='red'>Edytuj swoje dane</a></p>";
            }

            $zapytanieAplikacja = "SELECT ofertapracy.Tytul, ofertapracy.idOfertaPracy, aplikacja.idAplikacja FROM ofertapracy INNER JOIN aplikacja ON ofertapracy.idOfertaPracy = aplikacja.OfertaPracy_idOfertaPracy INNER JOIN uzytkownik ON aplikacja.Uzytkownik_id_Uzytkownik = uzytkownik.id_Uzytkownik WHERE '$_SESSION[login]' = Login";

            if(!$wynikAplikacja = $baza -> query($zapytanieAplikacja)){
              echo "Pobranie danych z bazy nie powiodło się";
            }

            else {
              echo "<h1>Oferty na które aplikowałeś: </h1>";
              while($rowAplikacja = $wynikAplikacja -> fetch_assoc()){
                echo "<p><a href='szczegoly.php?id=" . $rowAplikacja['idOfertaPracy'] . "'>" . $rowAplikacja['Tytul'] . "<a></p><p><a class='usun' href='usun.php?idA=" . $rowAplikacja['idAplikacja'] . "'>usuń</a></p><br>";
              }
            }

            echo "<div class='button'><a href='wyloguj.php'><button>Wyloguj</button></a><div>";
          ?>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
