<?php

ini_set('short_open_tag', 1);

ini_set('display_errors', 1);

error_reporting(E_ALL);
include('includes/header.php') ?>
<?php include('includes/nav.php') ?>

<?php

if (logged_in()) {
} else {

    redirect('index.php');
}

?>
<div class="content">
    <div class='row col-12 align-items-center' style="background-color:white; min-height:100px;">
        <div class='col-lg-6 d-lg-block d-sm-none d-none d-md-none d-xs-none d-sm-none text-left'>
            <br>
            <h1><?php echo 'Cześć' . ' ' . $_SESSION['imie'] . ', ' ?>
                zacznijmy kalkulować!</h1>
            <br>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 d-block d-sm-block  d-xs-block d-md-block d-lg-none text-center'>
            <br>
            <h1><?php echo 'Cześć' . ' ' . $_SESSION['imie'] . '. ' ?>
                zacznijmy kalkulować!</h1>
            <br>
        </div>

        <div class='col-lg-6 d-lg-block d-sm-none d-md-none d-none d-xs-none d-sm-none text-right'>
            <a href='addProject.php' button type='button' class='btn btn-success align-center text-right'>Dodaj nowy
                projekt</a>
                <?php showButtonAddOutgoing() ?>
        </div>
        <div class='col-12 col-xs-12 col-sm-12 col-md-12 d-sm-block  d-block d-xs-block d-md-block d-lg-none text-center'>
            <a href='addProject.php' button type='button' class='btn btn-success align-center'>Dodaj nowy projekt</a>
            <?php showButtonAddOutgoing() ?>
            </h2>
        </div>

    </div>

    <div class="row col-12 d-xs-block  d-sm-block d-md-block d-lg-block d-none justify-content-around articlecontainer" style="min-height:80px;"></div>
    <div class="row col-12 justify-content-around articlecontainer">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 framebackground">
            <div><b>
                    <h3>Aktywne projekty</h3>
                </b>
                <br>
            </div>

            <div id="chart_div" class="chart"></div>
            <table class='table tabela stripe'>
                <thead>
                    <tr>
                        <th>Nazwa projektu</th>
                        <th>Budżet</th>
                        <th>Podgląd</th>
                    </tr>

                </thead>
                <tbody>
                    <?php echo display_message();
                    ?>
                    <?php showProjectActive();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 framebackground">

            <h3>Ostatnie 5 wydatków</h3>
            </b>
            <br>
            <div id="piechart" class="chart"></div>
            

            <table class='table stripe tabela2' style="width:100%;">
                <thead>
                    <tr>
                        <th>Nazwa wydatku</th>
                        <th>Projekt</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php showLastOutgoings();
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <div class='row col-12 justify-content-around articlecontainer'>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 framebackground">
            <div><b>
                    <h3>Zakończone projekty</h3>

                </b>
                <br>
            </div>
            <div id="chart_div_inactive" class="chart"></div>
            <table class='table tabela stripe'>
                <thead>
                    <tr>
                        <th>Nazwa projektu</th>
                        <th>Budżet</th>
                        <th>Podgląd</th>

                    </tr>
                </thead>
                <tbody>
                    <?php echo display_message(); ?>

                    <?php showProjectInactive(); ?>
                </tbody>
            </table>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-5 framebackground'>

            <div>
                <h3>Podsumowanie</h3>
                </b>
                <br>
                <?php showChartOutgoings() ?>
               
</div>
<br><br><br><br>
                <table class='table' style="width:100%;">


                    <tbody>

                        <th>
                            <p>Suma wszystkich Twoich wydatków:<br>
                                <h2 class="mobile" style="color:#4285f4"><b><?php showUserOutgoings(); ?> zł</p></b></h2>
                        </th>
                        <th>
                            <p>Suma budżetów dla wszystkich projektów:<br>
                            <h2 class="mobile" style="color:#4285f4"><b><?php showProjectsSum(); ?> zł</p></b></h2>
                        </th>

                    </tbody>

                    <tbody>
                        <th>
                            <p>Ilość aktywnych projektów:<br>
                            <h2 class="mobile" style="color:#4285f4"><b> <?php showCountActiveProject(); ?></p></b></h2>
                        </th>
                        <th>
                            <p>Ilośc zakończonych projektów:<br>
                            <h2 class="mobile" style="color:#4285f4"><b> <?php showCountInActiveProject(); ?></p></b></h2>
                        </th>
                    </tbody>



                </table>
            </div>

        </div>

    </div>
</div>
<?php include('includes/footer.php') ?>