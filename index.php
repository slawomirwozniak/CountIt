<?php include('includes/header.php') ?>
<!--HEADER -->
<div class="headercontainer">
    <?php include('includes/navindex.php') ?>
    <div class="row align-self-end col-xl-12 d-xl-block d-sm-none d-lg-none d-md-none d-block-none d-none d-xs-none d-sm-none headercontent switchlg" style="height:350px;">
        <br><br><br><h1>Aplikacja do zarządzania budżetem remontu,<br> dzięki której będziesz mieć wszystkie wydatki pod kontrolą!</h1>
        <br><a href='register.php' type="button" class="btn btn-success headerbutton">Załóż darmowe konto</a>
    </div>
    <div class="row align-self-end col-lg-12 d-xl-none d-lg-block d-sm-none d-md-none d-block-none d-none d-xs-none d-sm-none headercontent switchmd" style="height:350px;">
        <br><br><h1>Aplikacja do zarządzania budżetem remontu,<br> dzięki której będziesz mieć wszystkie wydatki pod kontrolą!</h1>
        <br><a href='register.php' type="button" class="btn btn-success headerbutton">Załóż darmowe konto</a>
    </div>
    <div class="row align-self-end col-xs-12 col-sm-12 col-md-12 d-sm-block  d-xs-block d-md-block d-block d-lg-none  headercontent switchsm" style="height:350px">
        <br><h5>Aplikacja do zarządzania budżetem remontu,dzięki której będziesz mieć wszystkie wydatki pod kontrolą!</h5>
        <a href='register.php' type="button" class="btn btn-success">Załóż darmowe konto</a>
    </div>
</div>
<div class="content">
<?php echo display_message();
  ?>
    <div class="row col-12 justify-content-center align-items-center zoomopacity">
        <div class="col-4"></div>
        <div class="col-4">
            <br>
            <h2>Jak to działa?</h2>
            <br>
        </div>
        <div class="col-4"></div>
    </div>
    <!--JAK TO DZIAŁA/-->
    <!--FICZERY-->
    <!--TWORZ PROJEKTY-->
    <div class="row col-12 justify-content-center">
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3"> <img src="img/tworz.svg" alt="projekty" width="90" height="90">
            <h3>Twórz projekty</h3>
            <p>Nie ważne, czy budujesz dom od podstaw, czy planujesz przemalować salon. Z Count It zarządzasz całą inwestycją!
            </p>
        </div>
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY TWORZENIEM PROJEKTOW A BUDZETEM TYLKO NA LG-->
        </div>

        <!--KONIEC TWORZ PROJEKTY-->
        <!--PLANUJ BUDZET-->

        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3"><img src="img/planuj.svg" alt="budzet" width="90" height="90">
            <h3>Planuj budżet</h3>
            <p>Planuj i zarządzaj budżetem. Niespodziewany przypływ gotówki, a może nieplanowany wydatek? Nie ma problemu, w każdym momencie możesz zmienić zakładany budżet.</p>
        </div>
        <!--KONIEC PLANUJ BUDZET-->
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY BUDZETEM A WYDATKAMI TYLKO NA LG DEVICACH-->
        </div>
        <!--PRZEGLADAJ WYDATKI-->

        <div class="col-xs-8 col-md-10 col-sm-8 col-lg-3"><img src="img/przegladaj.svg" alt="biale tlo" width="90" height="90">
            <h3>Przeglądaj wydatki</h3>
            <p>Wprowadzaj do projektu wydatki związane z projektem. Aplikacja umożliwi wgląd do wszystkich poniesionych kosztów. </p>
        </div>
        <!--KONIEC PRZEGLADAJ WYDATKI-->
    </div>
    <div class="col-lg-1">
        <!--PRZERWA MIEDZY PRZEDLADANIEM WYDATKOW A FILTROWANIEM TYLKO NA LG-->
    </div>
    <!--FILTRUJ WYDATKI-->
    <div class="row col-12 justify-content-center">

        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3"> <img src="img/filtruj.svg" alt="biale tlo" width="90" height="90">
            <h3>Filtruj wydatki</h3>
            <p>Zastanawiasz się, jak rozkładają się proporcje poszczególnych wydatków? Count It odfiltruje koszty różnych kategorii. </p>
        </div>
        <!--KONIEC FILTRUJ WYDATKI-->
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY FILTRUJ WYDATKI A HISTORIĄ TYLKO NA LG -->
        </div>
        <!--HISTORIA-->
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3"><img src="img/historia.svg" alt="historia" width="90" height="90">
            <h3>Historia</h3>
            <p>Count It odnotuje datę wprowadzenia każdego kosztu, dzięki temu nigdy nie będziesz miał wątpliwości, kiedy dokonałes zakupu.</p>
        </div>
        <!--KONIEC HISTORIA-->
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY HISTORIA A ZARZADZANIEM PROJEKTAMI TYLKO NA LG-->
        </div>
        <!--ZARZĄDZAJ PROJEKTAMI-->

        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3"><img src="img/zarzadzaj.svg" alt="biale tlo" width="90" height="90">
            <h3>Zarządzaj projektami</h3>
            <p>Zrealizowane i zakończone projekty możesz trwale zarchiwizować. </p>
        </div>
        <!--prawybok-->
    </div>
    <!--KONIEC ZARZĄDZAJ PROJEKTAMI-->
    <!--FICZERY/-->
    <div class="row col-12 align-items-center justify-content-center preview">
    </div>
    <div class="row col-12 align-items-center justify-content-center" style="min-height:180px;">
        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-12 ">
                <h2>Przekonaj się, jaki remont może być przyjemny!</h2><br>
            <a href='register.php' type="button" class="btn btn-success">Załóż darmowe konto</a>
        </div>
    </div>
    <div class="row col-12 justify-content-center">
        <!--BUTTON ZALOZ DARMOWE KONTO-->
        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-12 align-items-center">
           
        </div>
    </div>

    <div class="row col-12 justify-content-center countit">

        <div class="col-xs-12 col-md-12 col-sm-12 col-md-12 col-lg-12 ">
            <h2>COUNT IT! to:</h2>
        </div>
        <div class="col-xs-12 col-md-12 col-sm-12 col-md-12 col-lg-4">
            <h4>Ponad 15 000 użytkowników</h4>
        </div>

        <div class="col-xs-12 col-md-12 col-sm-12 col-md-12 col-lg-4">
            <h4>Ponad 15 000 projektów</h4>
        </div>
        <div class='col-xs-12 col-md-12 col-sm-12 col-md-12 col-lg-4'>
            <h4>Łączna kwota budżetów <br>37 500 000 zł</h4>
        </div>

    </div>
    <div class="row col-12 justify-content-center">
        <!--POZNAJ OPINIE-->
        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-12 ">
            <br>
            <h2>Poznaj opinie naszych użytkowników:</h2>
            <br>
        </div>
        <!--POZNAJ OPINIE/-->
        <!--1 OPINIA-->
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3 framebackground">
            <img src="https://i.ibb.co/Svs4Pg9/krzysiek.jpg" alt="krzysiek" class="imgrounded" width="150" height="150">
            <br>
            <br>
            <p><i>"Zastanawiasz się, jak rozkładają się proporcje poszczególnych wydatków? Count It odfiltruje koszty
                    różnych kategorii."</i>
                <br>Krzysiek </p>
        </div>
        <!--1 OPINIA/-->
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY OPINIA 1 A OPINIA 2 TYLKO NA LG -->
        </div>
        <!--2 OPINIA-->
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3 framebackground">
            <img src="https://i.ibb.co/FqHdhPt/salma.jpg" class="imgrounded" alt="salma" width="150" height="150">
            <br>
            <br>
            <p><i>"Count It odnotuje datę wprowadzenia każdego kosztu, dzięki temu nigdy nie będziesz miał wątpliwości,
                    kiedy dokonałes zakupu."</i>
                <br>Asia</p>
        </div>
        <!--2 OPINIA/-->
        <div class="col-lg-1">
            <!--PRZERWA MIEDZY OPINIA 1 A OPINIA 2 TYLKO NA LG -->
        </div>
        <!--3 OPINIA-->
        <div class="col-xs-8 col-sm-8 col-md-10 col-lg-3 framebackground">
            <img src="https://i.ibb.co/Zzryh6m/marcin.jpg" class="imgrounded" alt="salma" width="150" height="150">
            <br>
            <br>
            <p><i>"Zrealizowane i zakończone projekty możesz trwale zarchiwizować. "</i>
                <br>Marcin </p>
        </div>
        <!--3 OPINIA/-->

    </div>
    <!--KONIEC BUTTON ZALOZ DARMOWE KONTO-->
    <!--KONIEC INDEX-->
</div>
<?php include('includes/footer.php') ?>