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
            <a href='panel.php' ><li>PANEL UŻYTKOWNIKA</li></a>
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
          <form class="wyszukaj" method="post">
            <label for="imie">Imię: </label><br><input type="text" name="imie"><br>
            <label for="nazwisko">Nazwisko: </label><br><input type="text" name="nazwisko"><br>
            <label for="data">Data Urodzenia: </label><br><input type="date" name="data"><br>
            <input type="submit" name="submit" value="EDYTUJ">
          </form>
          <?php 
            require_once('connect.php');;

            if (isset($_POST["imie"]) && !empty($_POST["imie"]) && isset($_POST["nazwisko"]) && !empty($_POST["nazwisko"]) && isset($_POST["data"]) && !empty($_POST["data"])) {

              $imie = $_POST['imie'];
              $imie = htmlspecialchars($imie, ENT_IGNORE, "UTF-8");
              $nazwisko = $_POST['nazwisko'];
              $nazwisko = htmlspecialchars($nazwisko, ENT_IGNORE, "UTF-8");
              $data = $_POST['data'];
              $data = htmlspecialchars($data, ENT_IGNORE, "UTF-8");

              if (!$baza->query("UPDATE uzytkownik SET Imie = '$imie', Nazwisko = '$nazwisko', DataUrodzenia = '$data' WHERE id_Uzytkownik = '$_SESSION[idU]'")) {
                  echo "Wstawianie danych się nie powiodło: (" . $baza->errno . ") " . $baza->error;
              } 

              else {
                header('Location: panel.php');
              }
            }

            else {
              echo "<p>wypełnij wszystkie pola</p>";
            }
          ?>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>