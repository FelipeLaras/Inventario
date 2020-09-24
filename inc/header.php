<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>REDE-PARANAPART</title>
  <!--FAVICON 5-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!--FAVICON 5 END-->
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
  <link href="css/font-awesome.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/pages/dashboard.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/pages/signin.css" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="css/style_tabela.css">
  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <style type="text/css">
    .painel {
      margin-left: 22%;
      margin-top: 9%;
    }
  </style>
</head>

<body>

  <div class="navbar navbar-fixed-top">

    <div class="navbar-inner">

      <div class="container">

        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <a class="brand" href="manager.php">
          <img src="fd_logo.png" id="logo">
        </a>

        <div class="nav-collapse">
          <!--Aplicando a regra de perfil 0 = admnistrador 1 = usuario padrão-->
          <?php
          if ($_SESSION["perfil"] == 0) {

            echo "<ul class='nav pull-right'>
            <li class='dropdown'><a href='dit_front.php' class='dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["nome"] . "<b class='caret'></b></a>
            <ul class='dropdown-menu'>
            <li><a href='manager_conf.php'>Configurações</a></li>
            <li><a href='edit_front.php?id=" . $_SESSION["id"] . "'>Perfil</a></li>
            <li><a href='unset.php'>Sair</a></li>
            </ul>
            </li>";
          } else {
            echo "<ul class='nav pull-right'>
            <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["nome"] . " <b class='caret'></b></a>
            <ul class='dropdown-menu'>
            <li><a href='edit_front.php?id=" . $_SESSION["id"] . "'>Perfil</a></li>
            <li><a href='unset.php'>Sair</a></li>
            </ul>
            </li>
            </ul>";
          }
          ?>
          </ul>

        </div>
        <!--/.nav-collapse -->

      </div> <!-- /container -->

    </div> <!-- /navbar-inner -->

  </div> <!-- /navbar -->