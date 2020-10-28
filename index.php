<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inventario - SERVOPA</title>
    <!--FAVICON-->
    <link href="img/favicon.ico" rel="icon" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/pages/signin.css" rel="stylesheet" type="text/css">
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
                <a class="brand" href="index.php">
                    <img src="img/fd_logo.png" id="logo">
                </a>
                <div class="nav-collapse">
                    <ul class="nav pull-right">
                        <li class="">
                            <a href="front/sing-get.html" class="">
                                Você não tem uma conta?
                            </a>
                        </li>
                        <li class="">
                            <a href="http://10.100.1.217/glpi/index.php" class="">
                                <i class="icon-chevron-left"></i>
                                Ir para o GLPI
                            </a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
            <!-- /container -->
        </div>
        <!-- /navbar-inner -->
    </div>
    <!-- /navbar -->
    <div class="account-container">
        <div class="content clearfix">
            <form action="inc/validation.php" method="POST" oninput="outputHash.value = md5(inputString.value)">
                <h1>Logar</h1>
                <div class="login-fields">
                    <p>Por favor, forneça suas credenciais</p>
                    <div class="field">
                        <label for="username">Usuario:</label>
                        <input type="text" id="username" name="username" value="" placeholder="Usuário"
                            class="login username-field" autofocus />
                    </div>
                    <!-- /field -->
                    <div class="field">
                        <label for="password">senha:</label>
                        <input type="password" id="inputString" name="password" value="" placeholder="Senha"
                            class="login password-field" />
                        <!--MD5-->
                        <input type="text" for="inputString" name="outputHash" id="outputHash" style="display: none;">
                    </div>
                    <!-- /password -->
                    <?= ($_GET['erro'] == 1) ? "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Usuário não localizado</div>" : ""?>
                    <?= ($_GET['erro'] == 2) ? "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Atenção!</strong> Usuário <b style='color: red'>desativado!</b><br /><span style='font-size: 9px;'>Entre em contato com o T.I</span></div>" : ""?>
                    <!-- /alerta -->
                </div>
                <!-- /login-fields -->
                <div class="login-actions">
                    <span class="login-checkbox">
                        <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice"
                            tabindex="4" />
                        <label class="choice" for="Field">
                            <a href="front/forget.html">Esqueci minha senha!</a>
                        </label>
                    </span>
                    <button class="button btn btn-success btn-large">Logar</button>
                </div>
                <!-- .actions -->
            </form>
        </div>
        <!-- /content -->
    </div>
    <!-- /account-container -->
    <div class="login-extra">

    </div>
    <!-- /login-extra -->
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/signin.js"></script>
    <!-- MD5 -->
    <script src="js/md5.js"></script>
</body>
</html>

<?php 
    require_once('inc/coletando_equip_ocs.php');
    require_once('inc/coletando_software_ocs.php');
?>