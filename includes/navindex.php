<?php if (logged_in()) : ?>
  <!--Navbar-->
  <div class="nav">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent row col">

      <!-- Navbar brand -->
      <a class="navbar-brand" href="index.php"><b class="align-center" style="font-size:25px;"><img src="img/grupa.png" alt="Strona główna" width="40" height="40">ount it!</b></a>

      <!-- Collapse button -->
      <button class="navbar-toggler collapsed" id="button" type="button" onclick="toggleFunction()" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse" id="navbarNav">

        <!-- Links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="main.php"><b>Projekty</b></a>
          </li>
          <li class="nav-item active">
          <a class="nav-link" href="settings.php"><b>Ustawienia</b></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="logout.php"><b>Wyloguj się</b></a>
          </li>

          <!-- Dropdown -->

        </ul>
        <!-- Links -->

      </div>
      <!-- Collapsible content -->

    </nav>
  </div>
  <!--/.Navbar-->

<?php else : ?>
  <!--Navbar-->
  <div class="nav">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent row col">

      <!-- Navbar brand -->
      <a class="navbar-brand" href="index.php"><b class="align-center" style="font-size:25px"><img src="img/grupa.png" alt="Strona główna" width="40" height="40">ount it!</b></a>

      <!-- Collapse button -->
      <button class="navbar-toggler collapsed" id="button" onclick="toggleFunction()" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse" id="navbarNav">

        <!-- Links -->
        <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
      <a class="nav-link ml-auto" href="register.php"><b>Rejestracja</b></a> 
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="login.php"><b>Logowanie</b></a>
    </li>

          <!-- Dropdown -->

        </ul>
        <!-- Links -->

      </div>
      <!-- Collapsible content -->

    </nav>
  </div>
  <!--/.Navbar-->
<?php endif; ?>