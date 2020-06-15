<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PRACA</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <div class="container">
        <h1><a href="#">PRACA</a></h1>
        <nav>
          <ul>
            <?php 
              session_start();
              if(isset($_SESSION['zalogowano'])){
                echo "<a href='index.php' class='activ'><li>PRZEGLĄDAJ</li></a>
                      <a href='panel.php'><li>PANEL UŻYTKOWNIKA</li></a>
                      <a href='wyloguj.php'><li>WYLOGUJ</li></a>";
              }
              elseif (isset($_SESSION['zalogowanoP'])) {
                echo "<a href='index.php' class='activ'><li>PRZEGLĄDAJ</li></a>
                      <a href='dodaj.php'><li>DODAJ OFERTE</li></a>
                      <a href='panelPracodawca.php'><li>PANEL PRACODAWCY</li></a>
                      <a href='wyloguj.php'><li>WYLOGUJ</li></a>";
              }

              else {
                echo "<a href='index.php' class='activ'><li>PRZEGLĄDAJ</li></a>
                    <a href='logowanie.php'><li>LOGOWANIE</li></a>
                    <a href='rejestracja.php'><li>REJESTRACJA</li></a>";
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

    <section class="szukajka">
      <div class="container">
        <form class="wyszukaj" method="get">
          <input type="text" name="szukaj" placeholder="Szukaj">
          <input type="text" name="miejscowosc" placeholder="Miejscowość, Wojewódźtwo">
          <input type="submit" name="submit" value="Szukaj">
        </form>
        <?php
          require_once('connect.php');

          if (isset($_GET['szukaj']) && !empty($_GET['szukaj']) && isset($_GET['miejscowosc']) && !empty($_GET['miejscowosc'])){
            $szukaj = $_GET['szukaj'];
            $szukajMiejscowosc = $_GET['miejscowosc'];
          }

          elseif(isset($_GET['szukaj']) && !empty($_GET['szukaj'])){
            $szukaj = $_GET['szukaj'];
          }

          elseif(isset($_GET['miejscowosc']) && !empty($_GET['miejscowosc'])){
            $szukajMiejscowosc = $_GET['miejscowosc'];
          }
        ?>
      </div>
    </section>
    <div class="container">
      <aside class="filtr">
        <h3>Filtruj wyniki:</h3>
        <form class="filtrowanie" method="get" action="filtr.php">
          <div class="wybor">
            <h4>Miejscowość</h4>
              <?php
                require_once('connect.php');

                $zapytanie = "SELECT NazwaMiejscowosci, NazwaMiejscowosciPZ FROM miejscowosc";
                
                if(!$wynik = $baza -> query($zapytanie)) {
                  echo "Brak danych w tabeli";
                }

                else {
                  while($row = $wynik->fetch_assoc()){

                  echo "<input type = 'checkbox' value = '". $row['NazwaMiejscowosci'] ."'name='ms_". $row['NazwaMiejscowosci'] ."'>" . $row['NazwaMiejscowosciPZ'] . "</label><br>";
                 }
             
                }
              ?>
          </div>
  
        <h4>Wymagany Język</h4>
        
          <div class="wybor">
            <?php 
              require_once('connect.php');

              $zapytaniePracodawca = "SELECT Jezyk FROM wymaganyjezyk";
              
              if(!$wynik = $baza -> query($zapytaniePracodawca)) {
                echo "Brak danych w tabeli";
              }

              else {
                while($row = $wynik->fetch_assoc()){

                echo "<input type = 'checkbox' value = '". $row['Jezyk'] ."' name='jez_". $row['Jezyk'] ."'>" . $row['Jezyk'] . "</label><br>";
               }
               
              }
            ?>
            <input type="submit" name="akcja" value="FILTRUJ">
          </div>
        </form>
      </aside>
    </div>

    <div class="container">
      <section class="oferty">
        <?php 
          require_once('connect.php');

          $zapytanie = "SELECT ofertapracy.idOfertaPracy, ofertapracy.Tytul, ofertapracy.Opis, ofertapracy.DataWygasniecia, miejscowosc.NazwaMiejscowosci, miejscowosc.NazwaMiejscowosciPZ, wymaganyjezyk.Jezyk, pracodawca.NazwaPracodawcy, formazatrudnienia.FormaZatrudnienia, stanowisko.NazwaStanowiska, zawod.NazwaZawodu FROM ofertapracy INNER JOIN miejscowosc ON ofertapracy.Miejscowosc_idMiejscowosc = miejscowosc.idMiejscowosc INNER JOIN wymaganyjezyk ON ofertapracy.WymaganyJezyk_idWymaganyJezyk = wymaganyjezyk.idWymaganyJezyk INNER JOIN pracodawca ON ofertapracy.Pracodawca_id_Pracodawca = pracodawca.id_Pracodawca INNER JOIN formazatrudnienia_has_ofertapracy ON ofertapracy.idOfertaPracy = formazatrudnienia_has_ofertapracy.OfertaPracy_idOfertaPracy INNER JOIN formazatrudnienia ON formazatrudnienia_has_ofertapracy.FormaZatrudnienia_idFormaZatrudnienia = formazatrudnienia.idFormaZatrudnienia INNER JOIN ofertapracy_has_stanowisko ON ofertapracy.idOfertaPracy = ofertapracy_has_stanowisko.OfertaPracy_idOfertaPracy INNER JOIN stanowisko ON ofertapracy_has_stanowisko.Stanowisko_Stanowisko_idStanowisko = stanowisko.Stanowisko_idStanowisko INNER JOIN ofertapracy_has_zawod ON ofertapracy.idOfertaPracy = ofertapracy_has_zawod.OfertaPracy_idOfertaPracy INNER JOIN zawod ON ofertapracy_has_zawod.Zawod_idZawod = zawod.idZawod";

          if(isset($szukaj)){
            $zapytanie .= " AND ofertapracy.Tytul LIKE '%$szukaj%'";
            $szukaj = "";
          }

          if(isset($szukajMiejscowosc)){
            $zapytanie .= " AND miejscowosc.NazwaMiejscowosciPZ LIKE '%$szukajMiejscowosc%'";
          }

          if (isset($_GET["filtrowanie"]) && !empty($_GET["filtrowanie"])) {
            $zapytanie .= $_GET["filtrowanie"];
          }

          if(!$wynik = $baza -> query($zapytanie)) {
            echo "Brak danych w tabeli";
          }

          else{
            while($row = $wynik->fetch_assoc()){
              echo "<article>";
              echo "<h1>" . $row['Tytul'] . "</h1>";
              echo "<h2>Miejscowość: " . $row['NazwaMiejscowosciPZ'] . "</h2>";
              echo "<h2>Pracodawca: " . $row['NazwaPracodawcy'] . "</h2>";
              echo "<p>" . $row['Opis'] . "</p>";
              echo "<small>Data wygaśnięcia: " . $row['DataWygasniecia'] . "</small>";
              echo "<div class='button'><a href='szczegoly.php?id=" . $row['idOfertaPracy'] . "'><button>Więcej Szczegółów</button></a></div>";
              echo "</article>";
            }
          }
        ?>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
