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
            <a href='dodaj.php' class='activ'><li>DODAJ OFERTE</li></a>
            <a href='panelPracodawcy.php' ><li>PANEL PRACODAWCY</li></a>
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
          <h1>Dodaj ofertę:</h1>
          <form class="wyszukaj" method="get" action="dodaj1.php">
            <label for="tytul">tytuł: </label><br><input type="text" name="tytul"><br>
            <label for="miejscowosc">Data Wygaśnięcia: </label><br><input type="date" name="data"><br>   
            <label for="miejscowosc">Miejscowosść: </label><br>
            <select name="miejscowosc">
              <?php  
                require_once('connect.php');

                $zapytanie = "SELECT idMiejscowosc, NazwaMiejscowosci, NazwaMiejscowosciPZ FROM miejscowosc";

                if(!$wynik = $baza -> query($zapytanie)){
                  echo "Brak danych";
                }

                else{
                  while($row = $wynik -> fetch_assoc()){
                    echo "<option value='" . $row['idMiejscowosc'] ."'>" . $row['NazwaMiejscowosciPZ'] . "</option>";
                  }
                }
                

              ?>
              </select> <br>  
            <label for="jezyk">Wymagany Język: </label><br>
            <select name="jezyk">
              <?php  
                require_once('connect.php');

                $zapytanie = "SELECT idWymaganyJezyk, Jezyk FROM wymaganyjezyk";

                if(!$wynik = $baza -> query($zapytanie)){
                  echo "Brak danych";
                }

                else{
                  while($row = $wynik -> fetch_assoc()){
                    echo "<option value='" . $row['idWymaganyJezyk'] . "'>" . $row['Jezyk'] . "</option>";
                  }
                }
              ?>
            </select> <br>  
            <label for="jezyk">Forma zatrudnienia: </label><br>
            <select name="formaZatrudnienia">
              <?php  
                require_once('connect.php');

                $zapytanie = "SELECT idFormaZatrudnienia, FormaZatrudnienia FROM formazatrudnienia";

                if(!$wynik = $baza -> query($zapytanie)){
                  echo "Brak danych";
                }

                else{
                  while($row = $wynik -> fetch_assoc()){
                    echo "<option value='" . $row['idFormaZatrudnienia'] . "'>" . $row['FormaZatrudnienia'] . "</option>";
                  }
                }
              ?>
              </select> <br>
              <label for="jezyk">Zawód: </label><br>
              <select name="zawod">
              <?php  
                require_once('connect.php');

                $zapytanie = "SELECT idZawod, NazwaZawodu FROM zawod";

                if(!$wynik = $baza -> query($zapytanie)){
                  echo "Brak danych";
                }

                else{
                  while($row = $wynik -> fetch_assoc()){
                    echo "<option value='" . $row['idZawod'] . "'>" . $row['NazwaZawodu'] . "</option>";
                  }
                }
              ?>
              </select> <br>
              <label for="jezyk">Stanowisko: </label><br>
              <select name="stanowisko">
              <?php  
                require_once('connect.php');

                $zapytanie = "SELECT Stanowisko_idStanowisko, NazwaStanowiska FROM stanowisko";

                if(!$wynik = $baza -> query($zapytanie)){
                  echo "Brak danych";
                }

                else{
                  while($row = $wynik -> fetch_assoc()){
                    echo "<option value='" . $row['Stanowisko_idStanowisko'] . "'>" . $row['NazwaStanowiska'] . "</option>";
                  }
                }
              ?>
              </select> <br>
            <label for="opis">Opis oferty: </label><br><textarea name="opis" rows="10"></textarea><br>
            <input type="checkbox" name="regulamin" required><label for="regulamin"> Potwierdź <a href="#">regulamin</a></label><br>
            <input type="submit" name="oferta" value="Dodaj Oferte">
          </form>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
