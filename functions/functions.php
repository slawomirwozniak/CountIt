<?php

//-------------------- FUNKCJE POMOCNICZNE ----------------------

// function clean( $string ) {
//     return htmlentities( $string );
//}

function redirect( $location ) {
    return header( "Location: {$location}" );
}

function set_message( $message ) {
    if ( !empty( $message ) ) {
        $_SESSION['message'] = $message;

    } else {
        $message = '';

    }

}

function display_message() {

    if ( isset( $_SESSION['message'] ) ) {

        echo $_SESSION['message'];

        unset( $_SESSION['message'] );

    }

}

function token_generator() {
    $token = $_SESSION['token'] = md5( uniqid( mt_rand(), true ) );
    return $token;

}

//

function validation_errors( $error_message ) {

    $error_message = <<<DELIMITER
    <div class = 'alert alert-danger alert-dismissible' role = 'alert'>
    <button type = 'button' class = 'close' data-dismiss = 'alert' aria-label = 'Close'><span aria-hidden = 'true'>&times;
    </span></button>
    <strong>Warning!</strong> $error_message
    </div>
    DELIMITER;

    return $error_message;
}

function email_exists( $email ) {
    $sql = "SELECT id_usera FROM users WHERE email='$email'";
    $result = query( $sql );

    if ( row_count( $result ) == 1 ) {
        return true;
    } else {
        return false;
    }
}

function send_email( $email, $subject, $msg, $header ) {

    return mail( $email, $subject, $msg, $header );
}

//-------------------- REJESTRACJA - WYŚWIETLANIE BŁĘDÓW ----------------------

function validate_user_registration() {

    $errors = [];

    $min = 3;
    $max = 20;
    $max_email = 40;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        //     $imie               = clean( $_POST['imie'] );
        //     $email              = clean( $_POST['email'] );
        //     $haslo              = clean( $_POST['haslo'] );
        //     $potwierdz_haslo    = clean( $_POST['potwierdz_haslo'] );
        //     $regulamin           = clean( $_POST['regulamin'] );

        $imie               =  ( $_POST['imie'] ) ;
        $email              = ( $_POST['email'] );
        $haslo              = ( $_POST['haslo'] );
        $potwierdz_haslo    = ( $_POST['potwierdz_haslo'] );
        $regulamin           = ( $_POST['regulamin'] );

        if ( strlen( $imie ) < $min ) {

            $errors[] = "Twoje imię nie może być krótsze niż {$min} znaki :( ";

        }

        if ( strlen( $imie ) > $max ) {

            $errors[] = "Twoje imię nie może być dłuższe niż {$max}
            znaki :( ";

        }

        if ( email_exists( $email ) ) {

            $errors[] = 'Użytkownik o takim adresie email jest już zarejestrowany :(';

        }

        if ( strlen( $email ) > $max_email ) {

            $errors[] = "Twój adres email nie może być dłuższy niż {$max_email} znaków :( ";

        }

        if ( strlen( $haslo ) < $min ) {

            $errors[] = "Twoje hasło musi mieć min. {$min} znaki :( ";

        }
        if ( strlen( $haslo ) > $max ) {

            $errors[] = "Twoje hasło może mieć maksymalnie {$max} znaków :( ";

        }

        if ( $haslo !== $potwierdz_haslo ) {

            $errors[] = 'Podanie przez Ciebie hasła nie są zgodne :(';

        }

        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            if ( register_user( $imie, $email, $haslo ) ) {
                set_message( "<p class='bg-success text-center'>Wysłaliśmy Ci kod aktywacyjny - sprawdź skrzynkę pocztową</p>" );
                redirect( 'index.php' );
            } else {
                set_message( "<p class='bg-success text-center'>Nie mogliśmy zarejestrować użytkownika</p>" );
                redirect( 'index.php' );
            }
        }

    }
}

//-------------------- REJESTRACJA ----------------------

function register_user( $imie, $email, $haslo ) {

    $imie       = escape( $imie );
    $email       = escape( $email );
    $haslo       = escape( $haslo );

    if ( email_exists( $email ) ) {
        return false;

    } else {
        $haslo = md5( $haslo );
        $kod_walidacyjny = md5( $email . microtime() );

        $sql = 'INSERT INTO users(imie, email, haslo, zgoda,kod_walidacyjny,czy_aktywny)';
        $sql .= "VALUES('$imie','$email','$haslo',0,'$kod_walidacyjny',0)";

        $result = query( $sql );
        confirm( $result );

        $subject = 'Potwierdzenie rejestracji';
        $msg = "Kliknij w link aktywacyjny poniżej
         http://localhost/remont/activate.php?email=$email&code=$kod_walidacyjny ";
        $header = 'From: jac.sawinski@gmail.com';
        send_email( $email, $subject, $msg, $header );
        return true;

    }
}

//-------------------- AKTYWACJA UŻYTKOWNIKA, KOD WALIDACYJNY ----------------------

function activate_user() {
    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        if ( isset( $_GET['email'] ) ) {

            // $email = clean( $_GET['email'] );
            // $kod_walidacyjny = clean( $_GET['code'] );

            $email = ( $_GET['email'] );
            $kod_walidacyjny = ( $_GET['code'] );
            $sql = "SELECT id_usera FROM users WHERE email='".escape( $_GET['email'] )."' AND kod_walidacyjny='".escape( $_GET['code'] )."' ";
            $result = query( $sql );
            confirm( $result );
            if ( row_count( $result ) == 1 ) {
                $sql2 = "UPDATE users SET czy_aktywny =1, kod_walidacyjny=0 WHERE email='".escape( $email )."' AND kod_walidacyjny='".escape( $kod_walidacyjny )."' ";
                $result2 = query( $sql2 );
                confirm( $result2 );
                set_message( "<p class='bg-success'>Aktywowałeś swoje konto, zaloguj się</p>" );
                redirect( 'login.php' );
            } else {
                set_message( "<p class='bg-danger'>Twoje konto nie może zostać aktywowane</p>" );
                redirect( 'login.php' );
            }
        }
    }
}

//-------------------- LOGOWANIE - WYŚWIETLANIE BŁĘDÓW ----------------------

function validate_user_login() {

    $errors = [];

    $min = 3;
    $max = 20;
    $max_email = 40;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $email  = clean( $_POST['email'] );
        // $haslo  = clean( $_POST['haslo'] );

        $email  = ( $_POST['email'] );
        $haslo  = ( $_POST['haslo'] );
        $pamietaj = isset( $_POST['pamietaj'] );

        if ( empty( $email ) ) {

            $errors[] = 'Pole email nie może być puste';

        }

        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {

            if ( login_user( $email, $haslo, $pamietaj ) ) {
                redirect( 'main.php' );

            } else {
                echo validation_errors( 'Podane dane są nieprawidłowe' );

            }

        }

    }
}

//-------------------- LOGOWANIE ----------------------

function login_user( $email, $haslo, $pamietaj ) {

    $sql = "SELECT imie, haslo, id_usera FROM users WHERE email = '".escape( $email )."' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) == 1 ) {

        $row = fetch_array( $result );
        $db_password = $row['haslo'];
        // $imie =        // $_SESSION['email'] = $email;
        $_SESSION['imie'] = $row['imie'];
        $_SESSION['id_usera'] = $row['id_usera'];
        ;

        // $id = $_SESSION['id_usera'];

        if ( md5( $haslo ) == $db_password ) {

            if ( $pamietaj == 'on' ) {

                setcookie( 'email', $email, time() +  86400 );

            }

            $_SESSION['email'] = $email;
            //   $_SESSION['id_usera'] = $id_usera;

            return true;

        } else {

            return false;
        }

    }

}

//-------------------- TRZYMANIE SESJI ----------------------

function logged_in() {

    if ( isset( $_SESSION['email'] ) || isset( $_COOKIE['email'] ) ) {
        return true;
    } else {

        return false;
    }

}

//-------------------- OZDYSKIWANIE HASŁA ----------------------

function recover_password() {

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        if ( isset( $_SESSION['token'] ) && $_POST['token'] === $_SESSION['token'] ) {

            // $email = clean( $_POST['email'] );

            $email = ( $_POST['email'] );

            $email = ( $_POST['email'] );

            if ( email_exists( $email ) ) {

                $kod_walidacyjny = md5( $email .microtime() );

                setcookie( 'temp_access_code', $kod_walidacyjny, time()+900 );

                $sql = "UPDATE users SET kod_walidacyjny = '".escape( $kod_walidacyjny )."' WHERE email = '".escape( $email )."'";
                $result = query( $sql );
                confirm( $result );

                $subject = 'Zresetuj swoje hasło';
                $message = "Twój kod do resetu hasła {$kod_walidacyjny}



                
                Kliknij tu aby zresetować swoje hasło http://localhost/remont/code.php?email=$email&code=$kod_walidacyjny ";

                $headers = 'From: jac.sawinski@gmail.com';

                if ( send_email( $email, $subject, $message, $headers ) ) {

                } else {

                    echo validation_errors( 'Email nie został wysłany' );

                }

                set_message( "<p class='bg-success'>Sprawdź swoją skrzynkę mailową</p>" );
                redirect( 'index.php' );

            } else {

                echo validation_errors( 'Podany adres email nie istnieje :(' );
            }
        } else {
            redirect( 'index.php' );
        }

    }

}

//-------------------- KOD WALIDACYJNY ----------------------

function kod_walidacyjny() {

    if ( isset( $_COOKIE['temp_access_code'] ) ) {

        if ( !isset( $_GET['email'] ) && !isset( $_GET['code'] ) ) {

            redirect ( 'index.php' );

        } else if ( empty( $_GET['email'] ) || empty( $_GET['code'] ) ) {

            redirect ( 'index.php' );

        } else {

            if ( isset( $_POST['code'] ) ) {

                // $email = clean( $_GET['email'] );

                // $kod_walidacyjny = clean( $_POST['code'] );

                $email = ( $_GET['email'] );

                $kod_walidacyjny = ( $_POST['code'] );

                $sql = "SELECT id_usera FROM users WHERE kod_walidacyjny = '".escape( $kod_walidacyjny )."' AND email = '".escape( $email )."'";
                $result = query( $sql );

                if ( row_count( $result ) == 1 ) {

                    setcookie( 'temp_access_code', $kod_walidacyjny, time()+ 1200 );

                    redirect( "reset.php?email=$email&code=$kod_walidacyjny" );

                } else {

                    echo validation_errors( 'Zły kod' );
                }

            }

        }

    } else {

        set_message( "<p class='bg-success'>Sorki, sesja wygasła</p>" );
        redirect( 'index.php' );

    }

}

//-------------------- RESET HASŁA ----------------------

function password_reset() {

    if ( isset( $_COOKIE['temp_access_code'] ) ) {

        if ( isset( $_GET['email'] ) && isset( $_GET['code'] ) ) {

            if ( isset( $_SESSION['token'] ) && isset( $_POST['token'] ) ) {

                if ( $_POST['token'] === $_SESSION['token'] ) {

                    if ( $_POST['password'] === $_POST['confirm_password'] ) {

                        $updated_password = md5( $_POST['password'] );

                        $sql = "UPDATE users SET haslo = '".escape( $updated_password )."', kod_walidacyjny = 0, czy_aktywny=1 WHERE email = '".escape( $_GET['email'] )."'";

                        $result =  query( $sql );

                        confirm( $result );

                        set_message( "<p class='bg-success text-center'>Hasło zostało zaktualizowne, zaloguj się</p>" );

                        redirect( 'login.php' );

                    } else {

                        echo validation_errors( 'Podałeś inne hasła' );

                    }
                }

            }

        }

    } else {
        set_message( "<p class='bg-success'>Sorki, czas sesji wygasł</p>" );
        redirect( 'recover.php' );
    }
}

//-------------------- DODAWANIE PROJEKÓW - WALIDACJA ----------------------

function validate_project() {

    $minp = 4;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $projekt = clean( $_POST['nazwa'] );
        // $budzetRemontu = clean ( $_POST['budzet'] );

        $projekt = ( $_POST['nazwa'] );
        $budzetRemontu =  ( $_POST['budzet'] );

        if ( strlen( $projekt ) < $minp ) {

            $errors[] = "Nazwa projektu musi mieć min. {$minp} znaki :( ";
        }

        if ( !is_numeric( $budzetRemontu ) ) {
            $errors[] = 'Podaj kwotę';

        }

        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            // TUTAJ COS DZIAŁA NA ODWRÓT....
            if ( addProject( $projekt, $budzetRemontu ) ) {
                //set_message( "<p class='bg-success text-center'>Dodałes projekt</p>" );
                //redirect( 'index.php' );

            } else {
                set_message( "<p class='bg-success text-center'>Dodałeś nowy projekt. <br>Przejdź do <a href='main.php'> projektów </a> lub dodaj kolejny.</p>" );

            }
        }

    }
}

//-------------------- DODAWANIE PROJEKTÓW ----------------------

function addProject( $projekt, $budzetRemontu ) {

    $data = date( 'Y/m/d' );

    $email = $_SESSION['email'];

    $sql = 'INSERT INTO projects(nazwa_projektu, data_utworzenia, budzet, id_usera, czy_aktywny)';
    $sql .= "VALUES('$projekt','$data','$budzetRemontu',(SELECT id_usera FROM users WHERE email = '$email'),1)";

    $result = query( $sql );
    confirm( $result );
}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE AKTYWNYCH PROJEKTÓW----------------------

function showProjectActive () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT id_projektu, nazwa_projektu, budzet, data_utworzenia FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {

                $id_projektu = $row['id_projektu'];
                $_SESSION['id_projektu'] = $row['id_projektu'];
                $_SESSION['biezacy_id'] = $id_projektu;

                echo '<tr>'.'<td width="40%" align="center">'.$row['nazwa_projektu'].'</td>'. '<td>'.$row['budzet']. ' zł '. '</td>'.'<td>'." <a href='projectView.php?id=$id_projektu' button type='button' class='btn btn-success btn-xs'  >Zobacz</a>".'</td>'.'</tr>';

                $_SESSION['biezacy_id'] = $id_projektu;
            }
        }
    } else {

        echo '<b>'.'Nie masz aktywnych projektów.'.' Dodaj nowy projekt!'.'</b>'.'<br><br>';
        echo "<a href='addProject.php' button type='button' class='btn btn-success align-center'>Dodaj nowy projekt</a>";
        echo '<div class="col" style="height:45px;"></div>';

    }

    //print_r( $row['id_projektu'] );
}

//-------------------- STRONA GŁOWNA - CZY WYŚWIETLAC BUTTON DO DODANIA WYDATKU----------------------

function showButtonAddOutgoing () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT id_projektu FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        if ( $row = mysqli_fetch_array ( $result ) ) {

            echo  "<a href='addOutgoing.php' button type='button' class='btn btn-success align-center text-right'>Dodaj nowy wydatek</a>";

        }

    } else {

        echo  "<a href='#' button type='button' class='btn btn-secondary align-center text-right' data-toggle='tooltip' title='Aby dodać wydatek, musisz mieć min. jeden aktywny projekt'>Dodaj nowy wydatek</a>";
    }

    //print_r( $row['id_projektu'] );
}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE NIEAKTYWNYCH PROJEKTÓW----------------------

function showProjectInactive () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT id_projektu, nazwa_projektu, budzet, data_utworzenia FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=0";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            if ( $row = mysqli_fetch_array ( $result ) ) {

                $id_projektu = $row['id_projektu'];
                $_SESSION['id_projektu'] = $row['id_projektu'];
                $_SESSION['biezacy_id'] = $id_projektu;

                echo '<tr>'.'<td>'.$row['nazwa_projektu'].'</td>'. '<td>'.$row['budzet']. ' zł '. '</td>'.'<td>'." <a href='projectView.php?id=$id_projektu' button type='button' class='btn btn-success btn-xs'  >Zobacz</a>".'</td>'.'</tr>';

                $_SESSION['biezacy_id'] = $id_projektu;
            }
        }
    } else {

        echo 'Nie masz jeszcze zakończonych projektów. Oby to się szybko zmieniło! :)';
        echo '<div class="col" style="height:45px;"></div>';

    }

    //print_r( $row['id_projektu'] );
}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE OSTATNICH WYDATKÓW----------------------

function showLastOutgoings () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT
    a.nazwa_wydatku,
    b.nazwa_projektu,
    a.kwota,
    a.data_utworzenia
  FROM
    wydatki a
    INNER JOIN projects b ON a.id_projektu = b.id_projektu
  WHERE
    b.id_usera = $id_usera
    ORDER BY
    a.data_utworzenia ASC
    LIMIT 5";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {

                echo'<tr>';
                echo '<td>'.$row['nazwa_wydatku'].'</td>';
                echo '<td>'.$row['nazwa_projektu'].'</td>';

                echo '<td>'.$row['kwota'].' zł '.'</td>';
                echo '<td>'.$row['data_utworzenia'].'</td>';
                echo'</tr>';

            }
        }
    } else {

        echo 'Nie dodałeś jeszcze żadnych wydatków.';
        echo '<div class="col" style="height:45px;"></div>';

    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE OSTATNICH WYDATKÓW - WYKRES----------------------

function showLastOutgoingsChart () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT
    a.nazwa_wydatku,
    a.kwota
  FROM
    wydatki a
    INNER JOIN projects b ON a.id_projektu = b.id_projektu
  WHERE
    b.id_usera = $id_usera
    ORDER BY
    a.data_utworzenia DESC
    LIMIT 5";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {

                echo "['".$row['nazwa_wydatku']."', ".$row['kwota'].']'.',' ;

                // ['Sleep',    7]

            }
        }
    } else {

        echo 'Brak wydatków';
    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE AKTYWNYCH PROJEKTÓW- CZY MA SIĘ WYŚWIETLAĆ WYKRES----------------------

function showChartActiveProjects () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT nazwa_projektu, budzet FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='chart_div' class='chart'>".'</div>' ;

    } else {echo "blaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";}

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE OSTATNICH WYDATKÓW- CZY MA SIĘ WYŚWIETLAĆ WYKRES----------------------

function showChartLastOutgoings () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT id_wydatku FROM wydatki WHERE id_usera='$id_usera'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='piechart' class='chart'>".'</div>' ;

    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE NIEAKTYWNYCH PROJEKTÓW- CZY MA SIĘ WYŚWIETLAĆ WYKRES----------------------

function showChartInactiveProjects () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT nazwa_projektu, budzet FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=0";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='chart_div_inactive' class='chart'>".'</div>' ;

    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE PODSUMOWANIA - CZY MA SIĘ WYŚWIETLAĆ WYKRES----------------------

function showChartOutgoings () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT id_wydatku FROM wydatki WHERE id_usera='$id_usera'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='columnchart_material' class='chart'>".'</div>' ;

    } else {
        echo 'Aby zobaczyć pełne podsumowanie, dodaj projekt i min. 1 wydatek.';
        echo '<div class="col" style="height:45px;"></div>';


    }
}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE AKTYWNYCH PROJEKTÓW- WYKRES----------------------

function showActiveProjectsChart () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT nazwa_projektu, budzet FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {

                echo "['".$row['nazwa_projektu']."', ".$row['budzet'].']'.',' ;

            }
        }
    } else {

        echo 'Brak wydatków';
    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE NIEAKTYWNYCH PROJEKTÓW- WYKRES----------------------

function showInActiveProjectsChart () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT nazwa_projektu, budzet FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=0";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {

                echo "['".$row['nazwa_projektu']."', ".$row['budzet'].']'.',' ;

            }
        }
    } else {

        echo 'Brak wydatków';
    }

}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE SUMY BUDZETOW----------------------

function showProjectsSum () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT SUM(budzet) AS 'suma' FROM projects WHERE id_usera='$id_usera'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $sumabudzetow = $row['suma'];

            // $_POST['suma_budzetu'] = $sumabudzetow;

            if ( $sumabudzetow > 0 ) {

                echo $sumabudzetow;
            } else {

                echo '0';
            }
        }
    }
}

//-------------------- STRONA GŁOWNA - WYŚWIETLANIE SUMY WSZYSTKICH WYDATKÓW----------------------

function showUserOutgoings () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT 
    SUM(kwota) AS 'suma' 
    FROM wydatki
    WHERE  id_projektu IN 
    (SELECT id_projektu 
    FROM projects 
    WHERE id_usera = '$id_usera')";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        while ( $row = mysqli_fetch_array ( $result ) ) {
            $sumaWszystkichWydatkow = $row['suma'];

            // $_POST['suma_wszystkich_wydatkow'] = $sumaWszystkichWydatkow;

            if ( $sumaWszystkichWydatkow > 0 ) {

                echo $sumaWszystkichWydatkow;
            } else {
                echo '0';
            }

        }

    }
}

//-------------------- STRONA GŁOWNA - WYKRES Z BUDŻETEM I WYDATKAMI----------------------

function showUserOutgoingsChart () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT 
    SUM(kwota) AS 'suma_wydatkow' 
    FROM wydatki
    WHERE  id_projektu IN 
    (SELECT id_projektu 
    FROM projects 
    WHERE id_usera = '$id_usera')";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $sumaWydatkowWykres = $row['suma_wydatkow'];

            $sql2 = "SELECT SUM(budzet) AS 'suma_budzetow' FROM projects WHERE id_usera='$id_usera'";

            $result2 = query( $sql2 );

            if ( row_count( $result2 ) > 0 ) {

                if ( $row = mysqli_fetch_array ( $result2 ) ) {
                    $sumaBudzetowWykres = $row['suma_budzetow'];

                    // echo $sumaWydatkowWykres.' '. $sumaBudzetowWykres;
                    echo "['Suma wszystkich wydatków', $sumaWydatkowWykres]".','."['Suma wszystkich budżetów', $sumaBudzetowWykres]".',';

                } else {

                    echo 'Nie masz jeszcze żadnych wydatkóów';
                }
            }
        }
    }
}

//-------------------- STRONA GŁOWNA - ILOŚĆ AKTYWNYCH PRPOJEKTÓW---------------------

function showCountActiveProject () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT COUNT(*) AS suma FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        if ( $row = mysqli_fetch_array ( $result ) ) {

            $iloscAktywnychProjektow = $row['suma'];

            echo $iloscAktywnychProjektow;

        }

    } else {

        echo 'Brak aktywnych projektów';
    }

    //print_r( $row['id_projektu'] );
}

//-------------------- STRONA GŁOWNA - SUMA NIEAKTYWNYCH PRPOJEKTÓW---------------------

function showCountInActiveProject () {

    $id_usera = $_SESSION['id_usera'];

    //echo $id_usera;

    $sql = "SELECT COUNT(*) AS suma FROM projects WHERE id_usera='$id_usera' AND czy_aktywny=0";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        if ( $row = mysqli_fetch_array ( $result ) ) {

            $iloscAktywnychProjektow = $row['suma'];

            echo $iloscAktywnychProjektow;

        }

    } else {

        echo 'Brak aktywnych projektów';
    }

    //print_r( $row['id_projektu'] );
}

//-------------------- SZCZEGÓŁY PROJEKTU- WYŚWIETLANIE PROJEKTÓW----------------------

function showProjectDetails () {

    // unset( $row['nazwa_projektu'] );

    $id_projektu = $_GET['id'];

    $sql = "SELECT SUM( kwota ) AS 'suma' FROM wydatki WHERE id_projektu = '$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $sumaWydatkow = $row['suma'];

        }
    }

    $sql = "SELECT nazwa_projektu, budzet, data_utworzenia, czy_aktywny FROM projects WHERE id_projektu = '$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $nazwaProjektu = $row['nazwa_projektu'];
            $budzet = $row['budzet'];
            $status = $row['czy_aktywny'];

            $pozostalyBudzet = $budzet - $sumaWydatkow;

            if ( $pozostalyBudzet  > 0 ) {
                $statusBudzetu = 'Pozostały budżet: ';
            } else {
                $statusBudzetu = 'Przekroczony budżet: ';

            }

            if ( $status == 1 ) {

                //  echo 'Projekt: '. '  '. $row['nazwa_projektu']. ' |'.'   Budżet: ' .$row['budzet']. ' zł '. '|'.'  Data: '. $row['data_utworzenia'].' | '.'Status: aktywny'.'<br><br>'."<a href = 'projectModification.php?id=$id_projektu&nazwa=$nazwaProjektu&budzet=$budzet' button type = 'button' class = 'btn btn-success' > Modyfikuj projekt</a>". '  '. "<a href = 'manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu' button type = 'button' class = 'btn btn-success' > Zarządzaj kategoriami wydatków</a>";

                echo '<p>'.'<b>'.$row['nazwa_projektu'].'</b>'.'</p>'.'';
                echo '<p>'.'Data utworzenia: '. $row['data_utworzenia'].'</p>'.'';
                echo '<p>'.'Status: aktywny'.'</p>'.'';
                echo '<p>'.'Budżet: '.$row['budzet'].'</p>';
                echo '<p>'.'Wydano: '.$sumaWydatkow.'</p>'.'';
                echo '<p>'.$statusBudzetu.$pozostalyBudzet.'</p>'.'';

            } else {
                // echo 'Projekt: '. '  '. $row['nazwa_projektu']. ' |'.'   Budżet: ' .$row['budzet']. ' zł '. '|'.'  Data: '. $row['data_utworzenia'].' | '.'Status: zakończony'.'<br><br>'."<form method = 'post'><input type = 'submit' name = 'wznow' id = 'wznow' class = 'btn btn-info' value = 'wznów projekt'></form>";

                echo '<p>'.'<b>'. 'Projekt: '.$row['nazwa_projektu'].'</b>'.'</p>';
                echo '<p>'.'Budżet: '.$row['budzet'].'</p>';
                echo '<p>'.'Data utworzenia: '. $row['data_utworzenia'].'</p>';
                echo '<p>'.'Wydano: '.$sumaWydatkow.'</p>'.'';
                echo '<p>'.'Status: zakończony'.'</p>';

            }

        }

    }

    $nazwa = $row['nazwa_projektu'];
    $_GET['nazwaProjektu'] = $nazwa;

    //echo  $_GET['nazwaProjektu'];

    //echo ( $id_projektu );
    projectActive( $id_projektu );

}
//-------------------- WYŚWIETLANIE BUTTONÓW - NA PROJECT_VIEW ----------------------

function showProjectDetailsButtons () {

    $id_projektu = $_GET['id'];

    $sql = "SELECT nazwa_projektu, budzet, czy_aktywny FROM projects WHERE id_projektu='$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $nazwaProjektu = $row['nazwa_projektu'];
            $budzet = $row['budzet'];
            $status = $row['czy_aktywny'];

            if ( $status == 1 ) {

                echo ' '."<a href='addOutgoing.php?id=$id_projektu' button type='button' class='btn btn-success' > Dodaj <br> wydatek</a>";
                echo ' '."<a href='manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu' button type='button' class='btn btn-success' > Zarządzaj <br> kategoriami</a>";
                echo ' '."<a href='projectModification.php?id=$id_projektu&nazwa=$nazwaProjektu&budzet=$budzet' button type='button' class='btn btn-success' > Modyfikuj <br> projekt</a>";
            } else {
                echo "<form method = 'post'><input type = 'submit' name = 'wznow' id = 'wznow' class = 'btn btn-success' value = 'Wznów projekt'></form>";
            }

        }
    }
}

//-------------------- NAZWA PROJEKTU- NA PROJECT_VIEW ----------------------

function showProjectName() {

    $id_projektu = $_GET['id'];

    $sql = "SELECT nazwa_projektu FROM projects WHERE id_projektu='$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {

            echo $row['nazwa_projektu'];

        }

    }

}

//-------------------- SZCZEGÓŁY PROJEKTU- MODYFIKACJA PROJEKTÓW----------------------

function projectModification() {

    $nazwa = $_GET['nazwa'];
    $budzet = $_GET['budzet'];
    $id_projektu = $_GET['id'];

    projectDeactive ( $id_projektu );
    projectActive ( $id_projektu );

    //    / print_r ( $_GET['budzet'] );
}

function validateProjectModification() {

    $id_projektu = $_GET['id'];

    $minp = 4;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $nazwa = clean( $_POST['nazwa'] );
        // $budzetRemontu = clean ( $_POST['budzet'] );

        $nazwa = ( $_POST['nazwa'] );
        $budzetRemontu =  ( $_POST['budzet'] );

        if ( strlen( $nazwa ) < $minp ) {

            $errors[] = "Nazwa projektu musi mieć min. {
                    $minp}
                    znaki :( ";
        }

        if ( !is_numeric( $budzetRemontu ) ) {
            $errors[] = 'Podaj kwotę';

        }

        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            // TUTAJ COS DZIAŁA NA ODWRÓT....
            if ( addProjectModification( $nazwa, $budzetRemontu, $id_projektu ) ) {
                // set_message( "<p class = 'bg-success text-center'>Zmieniłeś projekt</p>" );
                //redirect( "projectView.php?id = $id_projektu.php" );

            } else {
                set_message( "<p class = 'bg-success text-center'>Zmieniłeś projekt</p>" );
                redirect( "projectView.php?id=$id_projektu" );

            }
        }

    }

}

function addProjectModification( $nazwa, $budzetRemontu, $id_projektu ) {

    $sql = "UPDATE projects SET nazwa_projektu = '$nazwa', budzet = '$budzetRemontu' WHERE id_projektu = '$id_projektu'";
    $result = query( $sql );
    confirm( $result );

    // redirect( "projectView.php?id = $id_projektu" );
    // set_message( "<p class = 'bg-success'>Zmieniłeś dane projektu</p>" );

}
//-------------------- SZCZEGÓŁY PROJEKTU - ZAKOŃCZENIE PROJEKTU----------------------

function projectDeactive ( $id_projektu ) {

    if ( isset( $_POST['zakoncz'] ) ) {

        $sql = "UPDATE projects SET czy_aktywny = 0 WHERE id_projektu = '$id_projektu'";
        $result = query( $sql );
        confirm( $result );

        set_message( "<p class = 'bg-success'>Zmieniłeś dane projektu</p>" );
        redirect( 'main.php' );
    }

}

//-------------------- SZCZEGÓŁY PROJEKTU - WZNOWIENIE PROJEKTÓW----------------------

function projectActive ( $id_projektu ) {

    if ( isset( $_POST['wznow'] ) ) {

        $sql = "UPDATE projects SET czy_aktywny = 1 WHERE id_projektu = '$id_projektu'";
        $result = query( $sql );
        confirm( $result );

        set_message( "<p class = 'bg-success'>Zmieniłeś dane projektu</p>" );
        redirect( 'main.php' );
    }

}

//-------------------- PROJECT VIEW - WYKRESY--------------------------------------------------------------------------

//-------------------- PROJECT VIEW - WYKRES Z SUMĄ WYDATKÓW I BUDŻETEM----------------------

function showChartSumOutgoingsBudget () {

    $id_usera = $_SESSION['id_usera'];
    $id_projektu = $_GET['id'];

    $sql = "SELECT 
    SUM(kwota) AS 'suma_wydatkow' 
    FROM wydatki
    WHERE id_projektu =$id_projektu";

    $result = query( $sql );

    if ( row_count( $result ) == 1 ) {
        while ( $row = mysqli_fetch_array ( $result ) ) {
            $sumaWydatkowWykres = $row['suma_wydatkow'];

            if ( $sumaWydatkowWykres != 0 ) {

                $sql2 = "SELECT budzet FROM projects WHERE id_projektu=$id_projektu";

                $result2 = query( $sql2 );

                if ( row_count( $result2 ) > 0 ) {

                    if ( $row = mysqli_fetch_array ( $result2 ) ) {
                        $budzet = $row['budzet'];

                        // echo $sumaWydatkowWykres.' '. $sumaBudzetowWykres;
                        echo "['Suma wydatków', $sumaWydatkowWykres]".','."['Budżet', $budzet]".',';

                    } else {

                        echo 'Nie masz jeszcze żadnych wydatkóów';
                    }
                }
            } else {

                $sql2 = "SELECT budzet FROM projects WHERE id_projektu=$id_projektu";

                $result2 = query( $sql2 );

                if ( row_count( $result2 ) > 0 ) {

                    if ( $row = mysqli_fetch_array ( $result2 ) ) {
                        $budzet = $row['budzet'];

                        // echo $sumaWydatkowWykres.' '. $sumaBudzetowWykres;
                        echo "['Suma wydatków', 0]".','."['Budżet', $budzet]".',';
                    }
                }

            }

        }

    }
}



//-------------------- PROJECT VIEW - WYKRES Z SUMĄ WYDATKÓW I BUDŻETEM - CZY MA SIĘ WYŚWIETLAĆ----------------------

function displayChartSumOutgoings () {

    $id_projektu = $_GET['id'];

    $sql = "SELECT nazwa_wydatku FROM wydatki WHERE id_projektu='$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        

        echo "<div id='chart_outgoings_budget' class='chart'>".'</div>' ;

    }

}

//-------------------- PROJECT VIEW - WYKRES - WSZYSTKIE WYDATKI----------------------

function showChartColumnOutgoings () {

    $id_projektu = $_GET['id'];

    $sql = "SELECT 
    nazwa_wydatku, kwota
    FROM wydatki
    WHERE id_projektu =$id_projektu";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            if ( $row = mysqli_fetch_array ( $result ) ) {
                $nazwaWydatku = $row['nazwa_wydatku'];
                $kwota = $row['kwota'];

                echo "['$nazwaWydatku', $kwota]".',';
            }
        }
    }
}


//-------------------- PROJECT VIEW - WSZSYTKIE WYDATKI- CZY MA SIĘ WYŚWIETLAĆ WYKRES----------------------

function displayChartActiveProjects () {

    $id_projektu = $_GET['id'];

    $sql = "SELECT nazwa_wydatku FROM wydatki WHERE id_projektu='$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='all' class='chart'>".'</div>' ;

    }

}


//-------------------- PROJECT VIEW - WYKRES KOŁOWY- WYDATKI NA KATEGORIE----------------------

function showChartCategoriesOutgoings () {

    $id_projektu = $_GET['id'];


    $sql =
    "SELECT SUM(wydatki.kwota) AS suma, kat_wydatkow.nazwa
    FROM wydatki
    LEFT JOIN kat_wydatkow ON kat_wydatkow.id_kw=wydatki.id_kw
    WHERE wydatki.id_projektu=$id_projektu
    GROUP BY kat_wydatkow.nazwa
    ORDER BY kat_wydatkow.nazwa ASC";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            if ( $row = mysqli_fetch_array ( $result ) ) {
                $nazwaKategoriiWydatku= $row['nazwa'];
                $SumaWydatkowKategorii = $row['suma'];

                echo "['".$row['nazwa']."', ".$row['suma'].']'.',' ;
            }
        }
    }
}


//-------------------- PROJECT VIEW - WYKRES KOŁOWY- CZY MA SIĘ WYŚWIETLAĆ----------------------

function displayChartCategoriesOutgoings () {
    $id_projektu = $_GET['id'];

    $sql = "SELECT nazwa_wydatku FROM wydatki WHERE id_projektu='$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        echo "<div id='podzialNaKategorie' class='chart'></div>" ;

    }

}


//-------------------- STRONA Z KATEGORIAMI - WYŚWIETLANIE KATEGORII----------------------

function showCategories () {

    $id_projektu = $_GET['id'];
    $nazwaProjektu = $_GET['nazwa'];

    //echo $id_usera;

    $sql = "SELECT id_kw, nazwa FROM kat_wydatkow WHERE id_projektu = '$id_projektu'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            while ( $row = mysqli_fetch_array ( $result ) ) {
                $nazwakategorii = $row['nazwa'];
                $idKW = $row['id_kw'];

                echo "<form method = 'post'>";
                echo "<table class = 'table '>";
                echo '<tr>';
                echo '<td width="70%" align="left">'.$row['nazwa'].'</td>'."<td align = 'right'><a href = 'categoryName.php?id=$id_projektu&nazwa=$nazwaProjektu&idkat=$idKW&nazkat=$nazwakategorii' button type = 'button' class = 'btn btn-success btn-xs'  >Zmień nazwę</a>".'</td>'."<td align = 'right'><input type = 'submit' name = 'usun[$idKW]' id = 'usun' class = 'btn btn-success btn-xs' value = 'Usuń'></td>";
                echo '</tr>';
                echo '</table>';

                $_SESSION['biezacy_id'] = $id_projektu;
            }
        }
    } else {

        echo 'Nie dodałeś jeszcze żadnej kategorii.';
    }

    //echo $_POST['usun'];

    if ( isset( $_POST['usun'] ) ) {

        foreach ( $_POST['usun'] as $key => $value ) {
            deleteCategory( $key );
        }

    }

}

//-------------------- STRONA Z KATEGORIAMI - WYŚWIETLANIE PRZYCISKU [WRÓC]----------------------

function showBackButton () {

    $id_projektu = $_GET['id'];

    echo ' '."<a href='projectview.php?id=$id_projektu' button type='button' class='btn btn-success' > Wróć do projektu</a>";
}

//-------------------- STRONA Z DODANIEM WYDATKU - WYŚWIETLANIE PRZYCISKU [WRÓC] JESLI WEJŚCIE Z PROJEKTU----------------------

function showBackButtonAddOutgoing () {

    if ( isset( $_GET['id'] ) ) {

        $id_projektu = $_GET['id'];

        echo ' '."<a href='projectview.php?id=$id_projektu' button type='button' class='btn btn-success' > Wróć do projektu</a>";
    } else {

        echo ' '."<a href='main.php' button type='button' class='btn btn-success' > Wróć do projektów</a>";
    }
}

//-------------------- STRONA Z KATEGORIAMI - USUWANIE KATEGORII----------------------

function deleteCategory ( $key ) {

    // echo $rowDelete;

    $id_projektu = $_GET['id'];
    $nazwaProjektu = $_GET['nazwa'];

    $sql = "DELETE FROM kat_wydatkow WHERE id_kw = '$key'";
    $result = query( $sql );

    $sql2 = "UPDATE wydatki SET id_kw=0 WHERE id_kw=$key";
    $result2 = query($sql2);

    redirect( "manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu" );



}

//-------------------- ZMIANA NAZWY KATEGORII - WALIDACJA----------------------

function validateCategoryName () {

    $minp = 4;
    $nazwaProjektu = $_GET['nazwa'];
    $id_projektu = $_GET['id'];
    $nazwaProjektu = $_GET['nazwa'];
    $idKategorii = $_GET['idkat'];

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $nazwakategorii = clean( $_POST['nazwakategorii'] );

        $nazwakategorii = ( $_POST['nazwakategorii'] );

        if ( strlen( $nazwakategorii ) < $minp ) {

            $errors[] = "Nazwa projektu musi mieć min. {
                        $minp}
                        znaki :( ";
        }
        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            // TUTAJ COS DZIAŁA NA ODWRÓT....
            if ( changeCategoryName ( $idKategorii, $nazwakategorii ) ) {
                set_message( "<p class = 'bg-success text-center'>Dodałes projekt</p>" );
                //redirect( 'index.php' );

            } else {
                set_message( "<p class = 'bg-success text-center'>Dodałeś projekt, przejdź do projektów</p>" );

            }
        }

    }
}
//-------------------- STRONA ZE ZMIANĄ NAZWY KATEGORII - ZMIANA ----------------------

function changeCategoryName ( $idKategorii, $nazwakategorii ) {
    $nazwaProjektu = $_GET['nazwa'];

    $id_projektu = $_GET['id'];

    $sql = "UPDATE kat_wydatkow SET nazwa = '$nazwakategorii' WHERE id_kw = '$idKategorii'";

    $result = query( $sql );
    confirm( $result );

    //location.reload();
    redirect( "manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu" );
    set_message( "<p class = 'bg-success text-center'>Nazwa zmieniona</p>" );
}

//-------------------- STRONA Z KATEGORIAMIA - WALIDACJA DODANIA NOWEJ KATEGORII----------------------

function validateCategory () {

    $minp = 4;
    $nazwaProjektu = $_GET['nazwa'];

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $nazwakategorii = clean( $_POST['nazwakategorii'] );
        $nazwakategorii = ( $_POST['nazwakategorii'] );

        if ( strlen( $nazwakategorii ) < $minp ) {

            $errors[] = "Nazwa kategorii musi mieć min. {$minp} znaki ";
        }
        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            // TUTAJ COS DZIAŁA NA ODWRÓT....
            if ( addNewCategory ( $nazwakategorii, $nazwaProjektu ) ) {

                set_message( "<p class = 'bg-success text-center'>Dodałes projektt</p>" );

            } else {

                $id_projektu = $_GET['id'];
                redirect( "manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu" );
                set_message( "<p class = 'bg-success text-center'>Dodałeś nową kategorię</p>" );

            }
        }

    }
}

//-------------------- STRONA Z KATEGORIAMI - DODANIE NOWEJ KATEGORII----------------------

function addNewCategory ( $nazwakategorii, $nazwaProjektu ) {

    $id_projektu = $_GET['id'];

    $sql = 'INSERT INTO kat_wydatkow(nazwa, id_projektu)';
    $sql .= "VALUES( '$nazwakategorii', '$id_projektu' )";

    $result = query( $sql );
    confirm( $result );

    // //location.reload();
    // redirect( "manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu" );
    // set_message( "<p class = 'bg-success text-center'>Dodałeś projekt</p>" );
}

//-------------------- STRONA Z WYDATKAMI DODANIEM WYDATKU - POBIERANIE PROJEKTÓW Z BAZY----------------------

function loadProjects() {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT id_projektu, nazwa_projektu FROM projects WHERE id_usera = '$id_usera' AND czy_aktywny = 1";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {

        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            $row = fetch_array( $result );
            $id_projektu = $row['id_projektu'];
            $nazwa_projektu = $row['nazwa_projektu'];

            echo "<option value = '".$row['id_projektu']."'>".$row['nazwa_projektu'].'</option>';

        }

    }
}

//-------------------- DODAWANIE WYDATKÓW - WALIDACJA ----------------------

function validate_outgoing() {

    $minp = 4;
    $maxp = 40;
    $maxk = 70;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // $nazwaWydatku = clean( $_POST['nazwaWydatku'] );
        // $kwotaWydatku = clean ( $_POST['kwotaWydatku'] );

        $nazwaWydatku = ( $_POST['nazwaWydatku'] );
        $kwotaWydatku =  ( $_POST['kwotaWydatku'] );
        $wybranyProjekt = $_POST['projekt'];

        if ( strlen( $nazwaWydatku ) < $minp ) {

            $errors[] = "Nazwa wydatku musi mieć min. {$minp} znaki ";
        }

        if ( strlen( $nazwaWydatku ) > $maxp ) {

            $errors[] = "Nazwa wydatku może mieć maksymalnie {$maxp} znaków ";
        }

        if ( !is_numeric( $kwotaWydatku ) ) {
            $errors[] = 'Podaj kwotę';

        }

        if ( !isset( $_POST['projekt'] ) ) {
            $errors[] = 'Musisz wybrać projekt';

        }

        if ( isset( $_POST['komentarz'] ) ) {
            $komentarz = $_POST['komentarz'];

            if ( strlen( $komentarz ) > $maxp ) {

                $errors[] = "Komentarz może mieć maksymalnie {$maxk} znaków ";
            }

        }

        if ( !empty( $errors ) ) {

            foreach ( $errors as $error ) {

                echo validation_errors( $error );

            }

        } else {
            // TUTAJ COS DZIAŁA NA ODWRÓT....
            if ( addNewOutgoing( $nazwaWydatku, $kwotaWydatku, $wybranyProjekt ) ) {
                //set_message( "<p class = 'bg-success text-center'>Dodałes projekt</p>" );
                //redirect( 'index.php' );

            } else {

                if ( isset( $_GET['id'] ) ) {
                    $id_projektu = $_GET['id'];
                    set_message( "<p class = 'bg-success text-center'>Dodałeś wydatek.<br> Dodaj kolejny lub wróć do <a href='projectview.php?id=$id_projektu'> projektu</a>.</p>" );

                } else {

                    set_message( "<p class='bg-success text-center'>Dodałeś nowy wydatek. <br>Przejdź do <a href='main.php'> projektów </a> lub dodaj kolejny.</p>" );
                }

            }
        }

    }
}
//-------------------- DODAWANIE WYDATKÓW - DODANIE DO BAZY ----------------------

function addNewOutgoing ( $nazwaWydatku, $kwotaWydatku, $wybranyProjekt ) {

    $id_usera = $_SESSION['id_usera'];
    $data = date( 'Y/m/d' );
    $komentarz = $_POST['komentarz'];

    if ( $_POST['kategoria'] == 'Brak dodanych kategorii' ) {
        $wybranaKategoria = '0';

    } else {
        $wybranaKategoria = $_POST['kategoria'];

    }

    $sql = 'INSERT INTO wydatki(nazwa_wydatku, kwota, komentarz, data_utworzenia, id_kw, id_projektu, id_usera )';
    $sql .= "VALUES( '$nazwaWydatku', $kwotaWydatku, '$komentarz', '$data', $wybranaKategoria, $wybranyProjekt, $id_usera )";

    $result = query( $sql );
    confirm( $result );

    //location.reload();
    // redirect( 'addOutgoing.php' );
    // set_message( "<p class = 'bg-success text-center'>Dodałeś projekt</p>" );
}

//-------------------- PRZEGLĄD WYDATKÓW - NA PROJECT_VIEW ----------------------

function showOutgoings() {

    $id_projektu = $_GET['id'];

    $sql = "SELECT
    a.nazwa_wydatku,
    a.kwota,
    b.nazwa,
    a.data_utworzenia,
    a.komentarz
    FROM
    wydatki a
    LEFT JOIN kat_wydatkow b ON a.id_kw = b.id_kw
    WHERE
    a.id_projektu = $id_projektu
    ORDER BY
    a.data_utworzenia DESC";

    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        for ( $i = 0; $i < row_count( $result );
        $i++ ) {

            if ( $row = mysqli_fetch_array ( $result ) ) {

                // echo 'Nazwa: '.$row['nazwa_wydatku'].$row['nazwa'].$row['kwota'].$row['data_utworzenia'].$row['komentarz'].'<br>';

                // echo '<tr>'.'<td width="40%' align = 'left">'.$row['nazwa_projektu'].'</td>'. '<td>'.$row['budzet']. ' zł '. '</td>'.'<td>'." <a href = 'projectView.php?id=$id_projektu' button type = 'button' class = 'btn btn-info btn-xs'  >Zobacz</a>".'</td>'.'</tr>';

                echo'<tr>';
                echo '<td>'.$row['nazwa_wydatku'].'</td>';
                echo '<td>'.$row['nazwa'].'</td>';
                echo '<td>'.$row['kwota'].'</td>';
                echo '<td>'.$row['data_utworzenia'].'</td>';
                echo '<td>'.$row['komentarz'].'</td>';
                echo'</tr>';

            }
        }
    } else {

        $sql = "SELECT nazwa_projektu FROM projects WHERE id_projektu = '$id_projektu'";
        $result = query( $sql );

        if ( row_count( $result ) > 0 ) {
            if ( $row = mysqli_fetch_array ( $result ) ) {
                $nazwaProjektu = $row['nazwa_projektu'];

                echo '<h5>Dodaj kategorię i pierwszy wydatek</h5>'."<a href='manageCategories.php?id=$id_projektu&nazwa=$nazwaProjektu' button type='button' class='btn btn-success' > Dodaj kategorię</a>&nbsp;<a href='addOutgoing.php?id=$id_projektu' button type='button' class='btn btn-success' > Dodaj wydatek</a>";
            }
        }
    }

}

//-------------------- USTAWIENIA - ZMIANA HASŁA ----------------------

function changePassword() {

    $errors = [];

    $min = 3;
    $max = 20;

    if ( isset( $_POST['changePassword-submit'] ) ) {

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            $obecneHaslo            =  ( $_POST['currentPassword'] ) ;
            $noweHaslo              = ( $_POST['newPassword'] );
            $noweHasloPotwierdzenie = ( $_POST['newPasswordConfirmation'] );

            if ( strlen( $noweHaslo ) < $min ) {

                $errors[] = "Twoje hasło musi mieć min. {$min} znaki :( ";

            }
            if ( strlen( $noweHaslo ) > $max ) {

                $errors[] = "Twoje hasło może mieć maksymalnie {$max} znaków :( ";

            }

            if ( $noweHaslo !== $noweHasloPotwierdzenie ) {

                $errors[] = 'Podanie przez Ciebie hasła nie są zgodne :(';

            }

            $id_usera = $_SESSION['id_usera'];

            $sql = "SELECT haslo FROM users WHERE id_usera=$id_usera";
            $result = query( $sql );

            if ( row_count( $result ) == 1 ) {

                $row = fetch_array( $result );
                $db_password = $row['haslo'];

                if ( md5( $obecneHaslo ) != $db_password ) {

                    $errors[] = 'Nieprawidłowe aktualne hasło :(';
                }
            }

            if ( !empty( $errors ) ) {

                foreach ( $errors as $error ) {

                    echo validation_errors( $error );

                }

            } else {

                $noweHaslo = md5( $noweHaslo );

                $sql = "UPDATE users SET haslo = '$noweHaslo' WHERE id_usera=$id_usera";
                $result = query( $sql );

                set_message( 'Hasło zostało zmienione' );

            }

        }

    }
}

//-------------------- USTAWIENIA - AKTUALNY ADRES EMAIL ----------------------

function showEmail () {

    $id_usera = $_SESSION['id_usera'];

    $sql = "SELECT email AS 'email' FROM users WHERE id_usera='$id_usera'";
    $result = query( $sql );

    if ( row_count( $result ) > 0 ) {
        if ( $row = mysqli_fetch_array ( $result ) ) {
            $email = $row['email'];

            // $_POST['suma_budzetu'] = $sumabudzetow;

            echo $email;
        } else {

            echo 'Nie dodałeś wskazałeś jeszcze żadnego budżetu';
        }
    }
}

//-------------------- USTAWIENIA - ZMIANA ADRESU EMAIL ----------------------

function changeEmail () {

    if ( isset( $_POST['changeEmail-submit'] ) ) {

        $id_usera = $_SESSION['id_usera'];

        $max_email = 40;
        $min_email = 6;

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            $email            =  ( $_POST['newEmail'] ) ;

            if ( email_exists( $email ) ) {

                $errors[] = 'Użytkownik o takim adresie email jest już zarejestrowany :(';

            }

            if ( strlen( $email ) > $max_email ) {

                $errors[] = "Twój adres email nie może być dłuższy niż {$max_email} znaków :( ";

            }

            if ( strlen( $email ) < $min_email ) {

                $errors[] = "Twój adres email nie może być krótszy niż {$min_email} znaków :( ";

            }

            if ( !empty( $errors ) ) {

                foreach ( $errors as $error ) {

                    echo validation_errors( $error );

                }

            } else {

                $sql = "UPDATE users SET email = '$email' WHERE id_usera=$id_usera";
                $result = query( $sql );

                redirect( 'settings.php' );

            }

        }

    }
}

//-------------------- USTAWIENIA - USUWANIE KONTA ----------------------

function deleteAccount () {

    if ( isset( $_POST['deleteaccount-submit'] ) ) {

        $id_usera = $_SESSION['id_usera'];

        if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

            if ( !empty ( $_POST['deleteaccount'] ) ) {

                $sql = "DELETE FROM users WHERE id_usera=$id_usera";
                $result = query( $sql );

                redirect( 'logout.php' );

            }

        }
    }
}