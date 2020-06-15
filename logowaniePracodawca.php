<?php 
  session_start();

  if(isset($_SESSION['zalogowano']) || isset($_SESSION['zalogowanoP'])){
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
            <a href='logowanie.php' class='activ'><li>LOGOWANIE</li></a>
            <a href='rejestracja.php' ><li>REJESTRACJA</li></a>
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
          <h1>LOGUJESZ SIĘ JAKO PRACODAWCA</h1>
          <a href="logowanie.php"><p>ZALOGUJ SIĘ JAKO UŻYTKOWNIK</p></a><br>
          <form class="wyszukaj" method="post">
            <label for="Login">Login: </label><br><input type="text" name="login"><br>
            <label for="haslo">Hasło: </label><br><input type="password" name="haslo"><br>
            <input type="submit" name="submit" value="ZALOGUJ">
          </form>
          <?php 
            require_once('connect.php');

            if (isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["haslo"]) && !empty($_POST["haslo"])) {
              $login = $_POST['login'];
              $login = htmlspecialchars($login, ENT_IGNORE, "UTF-8");
              $haslo = md5($_POST['haslo']);
              $haslo = htmlspecialchars($haslo, ENT_IGNORE, "UTF-8");

              $zapytanie = "SELECT Login, Haslo FROM pracodawca WHERE Login = '$login' AND Haslo = '$haslo'";

              if($wynik = $baza -> query($zapytanie)){
                $zlicz = $wynik -> num_rows;
              }

              if ($zlicz != 1) {
                echo "<p>Podane dane są nieprawidłowe lub konto nie istnieje</p>";
              }

              else{

                $zapytanieUzytkownik = "SELECT id_Pracodawca FROM pracodawca WHERE Login = '$login'";

                if(!$wynik = $baza -> query($zapytanieUzytkownik)){
                  echo "Nie działa";
                }

                else {
                  $row = $wynik -> fetch_assoc();

                  $_SESSION['zalogowanoP'] = true;
                  $_SESSION['login'] = $login;
                  $_SESSION['idP'] = $row['id_Pracodawca'];

                  header("location: index.php");
                }
              }
            }

            else {
              echo "<p>Wprowadź dane</p>";
            }
          ?>
        </article>
      </section>
    </div>

    <div class="clr"></div>
    <footer>Copyright &copy; 2020 Adrian Oleś</footer>
  </body>
</html>
