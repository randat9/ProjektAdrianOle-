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
            <a href='logowanie.php'><li>LOGOWANIE</li></a>
            <a href='rejestracja.php' class='activ'><li>REJESTRACJA</li></a>
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
          <h1>ZAREJESTUJESZ SIĘ JAKO PRACODAWCA</h1>
          <a href="rejestracja.php"><p>ZAREJESTRUJ SIĘ JAKO UŻYTKOWNIK</p></a><br>
          <form class="wyszukaj" method="post">
            <label for="nazwa">Nazwa pracodawcy: </label><br><input type="text" name="nazwa"><br>
            <label for="email">E-mail: </label><br><input type="email" name="email"><br>
            <label for="Login">Login: </label><br><input type="text" name="login"><br>
            <label for="haslo">Hasło: </label><br><input type="password" name="haslo"><br>
            <label for="powtorz">Powtórz hasło: </label><br><input type="password" name="powtorz"><br>
            <input type="checkbox" name="regulamin" required><label for="regulamin"> Potwierdź <a href="#">regulamin</a></label><br>
            <input type="submit" name="submit" value="REJESTRACJA">
          </form>
            <?php 

            require_once('connect.php');

            if (isset($_POST["nazwa"]) && !empty($_POST["nazwa"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["login"]) && !empty($_POST["login"]) && isset($_POST["haslo"]) && !empty($_POST["haslo"] && isset($_POST["powtorz"]) && !empty($_POST["powtorz"]) && $_POST['haslo'] == $_POST['powtorz'])) {

              $login = $_POST['login'];
              $login = htmlspecialchars($login, ENT_IGNORE, "UTF-8");
              $email = $_POST['email'];
              $email = htmlspecialchars($email, ENT_IGNORE, "UTF-8");
              $haslo = md5($_POST['haslo']);
              $haslo = htmlspecialchars($haslo, ENT_IGNORE, "UTF-8");
              $nazwa = $_POST['nazwa'];
              $nazwa = htmlspecialchars($nazwa, ENT_IGNORE, "UTF-8");

              if (!$baza->query("INSERT INTO pracodawca(id_Pracodawca, NazwaPracodawcy, Login, Haslo, Email, Miejscowosc_idMiejscowosc) VALUES ('NULL', '$nazwa', '$login', '$haslo', '$email', 1)")) {
                  echo "Wstawianie danych się nie powiodło: (" . $baza->errno . ") " . $baza->error;
              } 

              else {
                header('Location: logowaniePracodawca.php');
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
