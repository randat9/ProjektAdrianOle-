<?php 
  session_start();

  if(!isset($_SESSION['zalogowano']) || isset($_SESSION['zalogowanoP'])){
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
      article p {
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
            <a href='panel.php'><li>PANEL UŻYTKOWNIKA</li></a>
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
          <form enctype="multipart/form-data" class="wyszukaj" method="post">
            <label for="email">Napisz coś o sobie: </label><br><textarea name="oSobie"></textarea><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="512000">
            <label>Wyślij swoje CV: </label><br><input type="file" name="CV"><br>
            <br><input type="checkbox" name="regulamin" required><label for="regulamin"> Potwierdź <a href="#">regulamin</a></label><br>
            <input type="submit" name="submit" value="REJESTRACJA">
          </form>
          <?php 

            require_once('connect.php');

            if (isset($_POST["oSobie"]) && !empty($_POST["oSobie"])) {

              $opis = $_POST['oSobie'];
              $opis = htmlspecialchars($opis, ENT_IGNORE, "UTF-8");
              $idU = $_SESSION['idU'];
      			  $idO = $_GET['id'];
              $idO = htmlspecialchars($idO, ENT_IGNORE, "UTF-8");

              $lokalizacja = "pliki/" . $idU . "_" . $idO . ".pdf";

              if(is_uploaded_file($_FILES['CV']['tmp_name']))
              {
                if(!move_uploaded_file($_FILES['CV']['tmp_name'], $lokalizacja))
                {
                  echo 'problem: Nie udało się skopiować pliku do katalogu.';
                }
              }
              else{
                echo "Błąd";
              }

      			  $zapytaniePonownaAplikacja = "SELECT aplikacja.OfertaPracy_idOfertaPracy AS idOferta FROM uzytkownik INNER JOIN aplikacja ON uzytkownik.id_Uzytkownik = aplikacja.Uzytkownik_id_Uzytkownik INNER JOIN ofertapracy ON ofertapracy.idOfertaPracy = aplikacja.OfertaPracy_idOfertaPracy WHERE uzytkownik.id_Uzytkownik = '$idU'";

      			  $wynikPA = $baza -> query($zapytaniePonownaAplikacja);

      			  $zapytanieAplikacja = "INSERT INTO aplikacja VALUES('NULL', '$opis', '$lokalizacja' , '$idU', '$idO')";

      			  $wynik = $baza -> query($zapytanieAplikacja);

      			  header("location: panel.php");
            }
          ?>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
	
