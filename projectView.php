<?php

ini_set('display_errors', 1);

error_reporting(E_ALL);

include('includes/header.php') ?>

<?php

if (logged_in()) {
} else {

    redirect('index.php');
}

?>

<?php include('includes/nav.php') ?>
<div class="content">
<div class='row col-12 align-items-center' style="background-color:white; min-height:100px;">
        <div class='col-lg-6 d-lg-block d-sm-none d-none d-md-none d-xs-none d-sm-none text-left'>
            <br>
            <h3>Projekt: <?php showProjectName();
                            ?></h3>
            <br>
        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 d-block d-sm-block  d-xs-block d-md-block d-lg-none text-center'>
            <br>
            <h1><?php showProjectName();
                ?></h1>
            <br>
        </div>
        <div class='col-lg-6 d-lg-block d-sm-none d-md-none d-none d-xs-none d-sm-none text-right'>
            <?php showProjectDetailsButtons();
            ?>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 d-sm-block  d-block d-xs-block d-md-block d-lg-none text-center'>
            <?php showProjectDetailsButtons();
            ?>
        </div>

    </div>


    <div class='row col-12 justify-content-around articlecontainer'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-4 framebackground'>

            <div>
                <h3 class='text-left'>

                    <?php showProjectDetails();
                    ?>
                </h3>

                </table>
            </div>
            <?php displayChartSumOutgoings (); ?>
            <?php displayChartCategoriesOutgoings(); ?>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-7 framebackground'>
            <div><b>
                    <h3>Wydatki</h3>

                </b><br>

                <table class='table tabela stripe'>
                    <thead>
                        <tr>
                            <th>Nazwa wydatku</th>
                            <th>Kategoria wydatków</th>
                            <th>Kwota</th>
                            <th>Data</th>
                            <th>Komentarz</th>
                        </tr>
                        <thead>
                        <tbody>
                            <?php showOutgoings();
                            ?>
                        </tbody>
                </table>
            </div>
            <?php displayChartActiveProjects(); ?>
        </div>
        
        <?php echo display_message();
        ?>
    </div>
</div>
<?php include('includes/footer.php') ?>