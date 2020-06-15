<?php 
  require_once('connect.php');
  session_start();

	if (isset($_GET["tytul"]) && !empty($_GET["tytul"]) && isset($_GET["opis"]) && !empty($_GET["opis"])) {

    $idP = $_SESSION['idP'];
    $idP = htmlspecialchars($idP, ENT_IGNORE, "UTF-8");
		$tytul = $_GET['tytul'];
    $tytul = htmlspecialchars($tytul, ENT_IGNORE, "UTF-8");
		$opis = $_GET['opis'];
    $opis = htmlspecialchars($opis, ENT_IGNORE, "UTF-8");
		$data = $_GET['data'];
    $data = htmlspecialchars($data, ENT_IGNORE, "UTF-8");
		$miejscowosc = $_GET['miejscowosc'];
    $miejscowosc = htmlspecialchars($miejscowosc, ENT_IGNORE, "UTF-8");
    $jezyk = $_GET['jezyk'];
    $jezyk = htmlspecialchars($jezyk, ENT_IGNORE, "UTF-8");
    $formaZatrudnienia = $_GET['formaZatrudnienia'];
    $formaZatrudnienia = htmlspecialchars($formaZatrudnienia, ENT_IGNORE, "UTF-8");
    $zawod = $_GET['zawod'];
    $zawod = htmlspecialchars($zawod, ENT_IGNORE, "UTF-8");
    $stanowisko = $_GET['stanowisko'];
    $stanowisko = htmlspecialchars($stanowisko, ENT_IGNORE, "UTF-8");


    $zapytaniedodaj = "INSERT INTO ofertapracy (idOfertaPracy, Tytul, Opis, DataWygasniecia, miejscowosc_idMiejscowosc, WymaganyJezyk_idWymaganyJezyk, Pracodawca_id_Pracodawca) VALUES ( '', '$tytul', '$opis', '$data', '$miejscowosc' , '$jezyk', '$idP')";

    if ($baza -> query($zapytaniedodaj)) {
      $pobierz = "SELECT idOfertaPracy FROM ofertapracy WHERE Tytul = '$tytul' AND Pracodawca_id_Pracodawca = '$idP'";

      $wynik = $baza -> query($pobierz);
      $row = $wynik -> fetch_assoc();

      $zapytanieforma = "INSERT INTO formazatrudnienia_has_ofertapracy(FormaZatrudnienia_idFormaZatrudnienia, OfertaPracy_idOfertaPracy) VALUES ('$formaZatrudnienia', '$row[idOfertaPracy]')";

      $baza -> query($zapytanieforma);

      $zapytanieZawod = "INSERT INTO ofertapracy_has_zawod(OfertaPracy_idOfertaPracy, Zawod_idZawod) VALUES ('$row[idOfertaPracy]', '$zawod')";

      $baza -> query($zapytanieZawod);

      $zapytanieStanowisko = "INSERT INTO ofertapracy_has_stanowisko(OfertaPracy_idOfertaPracy, Stanowisko_Stanowisko_idStanowisko) VALUES ('$row[idOfertaPracy]', '$stanowisko')";

      $baza -> query($zapytanieStanowisko);

      header("Location: index.php");

    }
  }

?>