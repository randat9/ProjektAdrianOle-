<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PRACA</title>
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
      a {
        color: #e8491d;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="container">
        <h1><a href="index.php">PRACA</a></h1>
        <nav>
          <ul>
            <?php 
              session_start();
              if(isset($_SESSION['zalogowanoP'])){
                echo "<a href='index.php' class='activ'><li>PRZEGLĄDAJ</li></a>
                      <a href='dodaj.php'><li>DODAJ OFERTE</li></a>
                      <a href='panel.php'><li>PANEL UŻYTKOWNIKA</li></a>
                      <a href='wyloguj.php'><li>WYLOGUJ</li></a>";
              }

              elseif(isset($_SESSION['zalogowano'])){
                echo "<a href='index.php' class='activ'><li>PRZEGLĄDAJ</li></a>
                      <a href='panel.php'><li>PANEL UŻYTKOWNIKA</li></a>
                      <a href='wyloguj.php'><li>WYLOGUJ</li></a>";
              }

              else {
                echo "<a href='index.php'><li>PRZEGLĄDAJ</li></a>
                    <a href='logowanie.php' ><li>LOGOWANIE</li></a>
                    <a href='rejestracja.php' ><li>REJESTRACJA</li></a>";
              }
            ?>
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
          <?php 
            require_once('connect.php');

            $idOferty = $_GET['id'];

            $zapytanie = "SELECT ofertapracy.idOfertaPracy, ofertapracy.Tytul, ofertapracy.Opis, ofertapracy.DataWygasniecia, miejscowosc.NazwaMiejscowosci, miejscowosc.NazwaMiejscowosciPZ, wymaganyjezyk.Jezyk, pracodawca.NazwaPracodawcy, formazatrudnienia.FormaZatrudnienia, stanowisko.NazwaStanowiska, zawod.NazwaZawodu FROM ofertapracy INNER JOIN miejscowosc ON ofertapracy.Miejscowosc_idMiejscowosc = miejscowosc.idMiejscowosc INNER JOIN wymaganyjezyk ON ofertapracy.WymaganyJezyk_idWymaganyJezyk = wymaganyjezyk.idWymaganyJezyk INNER JOIN pracodawca ON ofertapracy.Pracodawca_id_Pracodawca = pracodawca.id_Pracodawca INNER JOIN formazatrudnienia_has_ofertapracy ON ofertapracy.idOfertaPracy = formazatrudnienia_has_ofertapracy.OfertaPracy_idOfertaPracy INNER JOIN formazatrudnienia ON formazatrudnienia_has_ofertapracy.FormaZatrudnienia_idFormaZatrudnienia = formazatrudnienia.idFormaZatrudnienia INNER JOIN ofertapracy_has_stanowisko ON ofertapracy.idOfertaPracy = ofertapracy_has_stanowisko.OfertaPracy_idOfertaPracy INNER JOIN stanowisko ON ofertapracy_has_stanowisko.Stanowisko_Stanowisko_idStanowisko = stanowisko.Stanowisko_idStanowisko INNER JOIN ofertapracy_has_zawod ON ofertapracy.idOfertaPracy = ofertapracy_has_zawod.OfertaPracy_idOfertaPracy INNER JOIN zawod ON ofertapracy_has_zawod.Zawod_idZawod = zawod.idZawod WHERE '$idOferty' = ofertapracy.idOfertaPracy";

            $wynik = $baza -> query($zapytanie);

            $row = $wynik -> fetch_assoc();


            echo "<article>";
            echo "<h1>" . $row['Tytul'] . "</h1>";
            echo "<h2>Miejscowość: " . $row['NazwaMiejscowosciPZ'] . "</h2>";
            echo "<h2>Wymagany Język: " . $row['Jezyk'] . "</h2>";
            echo "<h2>Pracodawca: " . $row['NazwaPracodawcy'] . "</h2>";
            echo "<h2>Forma Zatrudnienia: " . $row['FormaZatrudnienia'] . "</h2>";
            echo "<h2>Nazwa stanowiska: " . $row['NazwaStanowiska'] . "</h2>";
            echo "<h2>Nazwa Zawodu: " . $row['NazwaZawodu'] . "</h2>";
            echo "<p>" . $row['Opis'] . "</p>";
            echo "<small>Data wygaśnięcia: " . $row['DataWygasniecia'] . "</small>";

            if(isset($_SESSION['zalogowano'])){
              $idU = $_SESSION['idU'];
              $zapytaniePonownaAplikacja = "SELECT aplikacja.OfertaPracy_idOfertaPracy as idOferta FROM uzytkownik INNER JOIN aplikacja ON uzytkownik.id_Uzytkownik = aplikacja.Uzytkownik_id_Uzytkownik INNER JOIN ofertapracy ON ofertapracy.idOfertaPracy = aplikacja.OfertaPracy_idOfertaPracy WHERE uzytkownik.id_Uzytkownik = '$idU' AND aplikacja.OfertaPracy_idOfertaPracy = '$idOferty'";

              $wynik = $baza -> query($zapytaniePonownaAplikacja);
              $zlicz = $wynik -> num_rows;

              if($zlicz > 0){
                echo "<div class='button'><h2>Aplikowałeś już na tą ofertę<br><a href='panel.php'>Przejrzyj swoje aplikacje</a><h2></div>";
              }

              else{
                echo "<div class='button'><a href='aplikuj.php?id=" . $idOferty . "'><button>Aplikuj</button></a></div>";
              }
            }

            else{
              echo "<div class='button'><h2><a href='logowanie.php'>Zaloguj się</a> aby aplikować</h2></div>";
            }
            echo "</article>";
            

          ?>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
