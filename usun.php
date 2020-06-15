<?php 
	require_once('connect.php');

	$idUsun = $_GET['idA'];

	$zapytanieUsun = "DELETE FROM aplikacja WHERE idAplikacja = '$idUsun'";

	if(!$wynik = $baza -> query($zapytanieUsun)){
		echo "Nie udało się usunąć twojej oferty";
	}

	else{
		header("location:panel.php");
	}


?>