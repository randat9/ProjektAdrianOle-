<?php 
	require_once('connect.php');
	$idA = $_GET['idA'];
	$idA = htmlspecialchars($idA, ENT_IGNORE, "UTF-8");
	$zapytanie = "SELECT cv FROM aplikacja WHERE idAplikacja = '$idA'";
	$wynik = $baza -> query($zapytanie);
	$row = $wynik -> fetch_assoc();

	if (!file_exists($row['cv']))
    { 
    echo "Na serwerze nie ma pliku";
    }
    else
    {
    echo "Plik został odnaleziony.<br><br>W ciągu kilku sekund powinno rozpocząć się pobieranie pliku. <META HTTP-EQUIV='Refresh' CONTENT='2; URL=" . $row['cv'] . "'>";
    }


?>