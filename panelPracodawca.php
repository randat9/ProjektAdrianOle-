<?php 
  session_start();

  if(!isset($_SESSION['zalogowanoP'])){
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
            <a href='dodaj.php'><li>DODAJ OFERTE</li></a>
            <a href='panelPracodawca.php' class='activ'><li>PANEL PRACODAWCY</li></a>
            <a href='wyloguj.php'><li>WYLOGUJ</li></a>
          </ul>
        </nav>
      </div>
    </header>

    <div id="obrazek">
      <div class="container">
        <h1>Znajdź wymarzoną pracę</h1>

      </div>
    </div>

    <div class="container">
      <section class="rejestracja">
        <article>
          <h1>Twoje dane:</h1>
          <?php 
            require_once('connect.php');

            $zapytanie = "SELECT NazwaPracodawcy, Login, Email FROM pracodawca WHERE '$_SESSION[idP]' = id_Pracodawca";

            if(!$wynik = $baza -> query($zapytanie)){
              echo "Pobranie danych z bazy nie powiodło się";
            }

            else {
              $row = $wynik -> fetch_assoc();
              
              echo "<h2>Nazwa Pracodawcy: </h2><p>" . $row['NazwaPracodawcy'] . "</p>";
              echo "<h2>Login: </h2><p>" . $row['Login'] . "</p>";
              echo "<h2>Email: </h2><p>" . $row['Email'] . "</p>";
            }

            $zapytanieOferta = "SELECT ofertapracy.Tytul, ofertapracy.idOfertaPracy FROM ofertapracy WHERE '$_SESSION[idP]' = Pracodawca_id_Pracodawca";

            if(!$wynikOferta = $baza -> query($zapytanieOferta)){
              echo "Pobranie danych z bazy nie powiodło się";
            }

            else {
              echo "<h1>Twoje oferty: </h1>";
              while($rowOferta = $wynikOferta -> fetch_assoc()){
                echo "<p><a href='szczegoly.php?id=" . $rowOferta['idOfertaPracy'] . "'>" . $rowOferta['Tytul'] . "</a></p><br>";
              }
            }

            $zapytanieZaaplikowano = "SELECT ofertapracy.Tytul, ofertapracy.idOfertaPracy, uzytkownik.id_Uzytkownik, uzytkownik.imie, uzytkownik.nazwisko, uzytkownik.Email, aplikacja.idAplikacja FROM ofertapracy INNER JOIN aplikacja ON ofertapracy.idOfertaPracy = aplikacja.OfertaPracy_idOfertaPracy INNER JOIN uzytkownik ON aplikacja.Uzytkownik_id_Uzytkownik = uzytkownik.id_Uzytkownik WHERE '$_SESSION[idP]' = ofertapracy.Pracodawca_id_Pracodawca";

            if(!$wynikZaaplikowano = $baza -> query($zapytanieZaaplikowano)){
              echo "Pobranie danych z bazy nie powiodło się";
            }

            else {
              echo "<h1>Użytkownicy którzy aplikowali: </h1><table>";
              echo "<tr><th>Oferta</th><th>Nazwisko</th><th>Imie</th><th>Email</th><th>CV</th></tr>";
              while($rowZaaplikowano = $wynikZaaplikowano -> fetch_assoc()){
                echo "<tr><td>" . $rowZaaplikowano['Tytul'] . "</td><td>" . $rowZaaplikowano['nazwisko'] . "</td><td>" . $rowZaaplikowano['imie'] . "</td><td>" . $rowZaaplikowano['Email'] . "</td><td><a href='pobierz.php?idA=" . $rowZaaplikowano['idAplikacja'] . "' target='_blank'>Pobierz</a></td></tr>";
              }
              echo "</table>";
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