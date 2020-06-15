<?php 
	require_once('connect.php');

	if (isset($_GET["szukaj"]) && !empty($_GET["szukaj"]) /*&& isset($_GET["miejscowosc"]) && !empty($_GET["miejscowosc"])*/) {

		$szukaj = $_GET['szukaj'];
		$szukaj = htmlspecialchars($szukaj, ENT_IGNORE, "UTF-8");
		// $miejscowosc = $_POST['miejscowosc'];

		$zapytanie = "SELECT Tytul FROM ofertapracy WHERE Tytul LIKE '%$szukaj%'";		

		if (!$wynik = $baza->query($zapytanie)) {
			echo "nie Działa";
		}

		else {
			while($row = $wynik -> fetch_assoc()){
				echo "<article>";
	            echo "<h1>" . $row['Tytul'] . "</h1>";
	            echo "</article>";
			}
		}
	}

?>