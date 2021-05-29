<?php

//-------------------- DODAWANIE WYDATKÓW - ŁADOWANIE KATEGORII DO PROJEKTU----------------------

include_once 'db.php';

if ( !empty( $_POST['id_projektu'] ) ) {

    $id_projektu = $_POST['id_projektu'];

    $sql = "SELECT id_kw, nazwa FROM kat_wydatkow WHERE id_projektu = '$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            $row = fetch_array( $result );
            $id_kw = $row['id_kw'];
            $nazwa_kat = $row['nazwa'];

            // echo "<option value='".$row['id_kw']."'>".$row['nazwa'].'</option>';

            echo '<option value="'.$row['id_kw'].'">'.$row['nazwa'].'</option>';
            // echo "<option value='1'>".test.'</option>';
        }

    } else {
        echo '<option>Brak dodanych kategorii</option>';

    }

}

?>