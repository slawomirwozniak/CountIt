<?php include('functions/init.php');
?>
<!DOCTYPE html>
<html lang='pl'>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
  <title>Budżet remontu</title>
  <link rel='stylesheet' href='css/bootstrap.min.css'>
  <link rel='stylesheet' href='css/styles.css'>
  <link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
  <script src='js/tether.min.js' async></script>
  <script src="js/jquery.slim.min.js"></script>
  <script src='js/bootstrap.min.js' async></script>
  <script src='js/popper.min.js' async></script>
  <script src='js/loader.js'></script>
  <script src='js/scripts.js'></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.responsive.min.js"></script>
  
  <!--
//-------------------- WYKRES DO OSTATANICH 5 WYDATKÓW---------------------- -->
  <script type='text/javascript'>
    google.charts.load('visualization', '1',  {
      packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawActivity);

    function drawActivity() {
      var data = google.visualization.arrayToDataTable([
        ['wydatek', 'kwota'],
        <?php showLastOutgoingsChart();
        ?>

      ]);

      var options = {
        title: '',
        backgroundColor: 'white',
        pieHole: 0.4,
      };
function changesize(){
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }
  </script>
 
<!-- -------------------- WYKRES NA MAIN DO Podsumowanie/Budzety/wydatki ---------------------- -->
<script type="text/javascript">
    google.charts.load('visualization', '1', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['', 'Kwota'],


        <?php showUserOutgoingsChart(); ?>

      ]);
      
      var options = {
        chart: {
          title: '',
          subtitle: '',
        }
      };
function changesize(){
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }
  </script>

<!--DZIAŁAJA!! NIE RUSZAJ!!
-------------------- WYKRES DO AKTYWNYCH PROJETÓW---------------------- -->

<script type='text/javascript' async>
  google.charts.load('current', {
    packages: ['corechart']
  });
  google.charts.setOnLoadCallback(drawBasic);
  function drawBasic() {
    var data = google.visualization.arrayToDataTable([
      ['Projekt', 'Budżet', ],
      <?php showActiveProjectsChart();
      ?>

    ]);

    var options = {
      backgroundColor: 'white',
      chartArea: {
        width: '50%'
      },
      hAxis: {
        title: '',

        minValue: 0
      },
      vAxis: {

      }
    };
function changesize(){
    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }

</script>
<!-- //-------------------- WYKRES DO NIEAKTYWNYCH PROJETÓW---------------------- -->

<script type='text/javascript' async>
  google.charts.load('current', {
    packages: ['corechart']
  });
  google.charts.setOnLoadCallback(drawInactive);
  function drawInactive() {
    var data = google.visualization.arrayToDataTable([
      ['Projekt', 'Budżet', ],
      <?php showInActiveProjectsChart();
        ?>
    ]);

    var options = {
      title: '',
      curveType: 'function',
      legend: {
        position: 'bottom'
      }
    };
function changesize(){
    var chart = new google.visualization.BarChart(document.getElementById('chart_div_inactive'));
    chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }

</script>
  <!--------------------- WYKRES NA PROJECT VIEW WSZYSTKIE WYDATKI/BUDZET---------------------- -->

  <script type="text/javascript">
    google.charts.load('visualization', '1', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['', 'Kwota'],


        <?php showChartSumOutgoingsBudget(); ?>

      ]);
      
      var options = {
        chart: {
          title: 'Wydatki vs. budżet',
          subtitle: '',
        }
      };
function changesize(){
        var chart = new google.charts.Bar(document.getElementById('chart_outgoings_budget'));
        chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }
  </script>


<!--------------------- WYKRES NA PROJECT VIEW WSZYSTKIE WYDATKI---------------------- -->

  <script type="text/javascript">
  google.charts.load('visualization', '1',{
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawAll);

    function drawAll() {
      var data = google.visualization.arrayToDataTable([
        ['', 'Kwota'],


        <?php showChartColumnOutgoings(); ?>

      ]);

      var options = {
        chart: {
          title: 'Wszystkie wydatki w projekcie',
          subtitle: '',
        }
      };
function changesize(){
        var chart = new google.charts.Bar(document.getElementById('all'));
        chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }
  </script>




<!-------------------- WYKRES NA PROJECT VIEW PODZIAŁ WYDATKÓW NA KATEGORIE------------------------>
<script type='text/javascript'>
    google.charts.load('visualization', '1',  {
      packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawActivity);

    function drawActivity() {
      var data = google.visualization.arrayToDataTable([
        ['kategoria', 'suma wydatków'],
        <?php showChartCategoriesOutgoings();
        ?>

      ]);

      var options = {
        title: 'Podział wydatków na kategorie',
        backgroundColor: 'white',
        pieHole: 0.4,
      };
function changesize(){
        var chart = new google.visualization.PieChart(document.getElementById('podzialNaKategorie'));
        chart.draw(data, options);
    }
    window.onload = changesize();
    $(window).resize(function() {
      changesize();
    });
  }
  </script>
</head>

<body>
  <?php echo display_message();
  ?>
  <div class="container-fluid">