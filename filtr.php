<?php 
  require_once('connect.php');
	
  if (isset($_GET["akcja"]) && !empty($_GET["akcja"])) {

    $zapytanie = "SELECT ofertapracy.idOfertaPracy, ofertapracy.Tytul, ofertapracy.Opis, ofertapracy.DataWygasniecia, miejscowosc.NazwaMiejscowosci, miejscowosc.NazwaMiejscowosciPZ, wymaganyjezyk.Jezyk FROM ofertapracy INNER JOIN miejscowosc ON ofertapracy.Miejscowosc_idMiejscowosc = miejscowosc.idMiejscowosc INNER JOIN wymaganyjezyk ON ofertapracy.WymaganyJezyk_idWymaganyJezyk = wymaganyjezyk.idWymaganyJezyk";

    $filtrowanie = " WHERE (";

    if(!$wynik = $baza -> query($zapytanie)) {
      echo "Brak danych w tabeli";
    }

    else{
      while ($row = $wynik -> fetch_assoc()) {

        if(isset($_GET['ms_' . $row['NazwaMiejscowosci']])){
          $spr = true;
          $filtrowanie .= " miejscowosc.NazwaMiejscowosci = '" . $row['NazwaMiejscowosci'] . "' OR ";
        }
      }

      mysqli_data_seek($wynik,0);
      

      while ($row = $wynik -> fetch_assoc()) {
        if (isset($_GET['jez_' . $row['Jezyk']])) {
          if ($spr) {
            $filtrowanie = substr($filtrowanie, 0, -3);
            $filtrowanie .= ") AND (";
            $spr = false;
          }
          $filtrowanie .=  " wymaganyjezyk.Jezyk = '" . $row['Jezyk'] . "' OR";
        }
      }
    }

    $filtrowanie = substr($filtrowanie, 0, -3);
    $filtrowanie .= ")";
    
    header("Location: index.php?filtrowanie=$filtrowanie");
	}

  ?>