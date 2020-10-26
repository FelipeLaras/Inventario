<?php
//montando critérios para o banco
$local = "localhost";
$user = "root";
$pass = "qtbvar03";
$bd = "ocsweb";
$port = "3306";

$conn_ocs = mysqli_connect($local, $user, $pass, $bd, $port);

$conn_ocs->query("SET NAMES 'utf8'");

if ($conn_ocs == false) {
	echo "<!DOCTYPE html>
<html>  
<?php
<head>
    <meta charset='utf-8'>
    <title>CPD - SERVOPA</title>
    <!--FAVICON-->
    <link href='favicon.ico' rel='icon' type='image/x-icon' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'>
    <meta name='apple-mobile-web-app-capable' content='yes'>    
    <link href='css/bootstrap.min.css' rel='stylesheet'>
    <link href='css/bootstrap-responsive.min.css' rel='stylesheet'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600'
            rel='stylesheet'>
    <link href='css/font-awesome.css' rel='stylesheet'>
    <link href='css/style.css' rel='stylesheet'>
    <link href='css/pages/dashboard.css' rel='stylesheet'>
    <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='css/bootstrap-responsive.min.css' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='css/pages/signin.css' rel='stylesheet' type='text/css'>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
          <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
        <![endif]-->
    <style type='text/css'>
      .painel {
      margin-left: 22%;
      margin-top: 9%;
      }
    </style>
  </head>
<div class='container'>
	
	<div class='row'>
		
		<div class='span12'>
			
			<div class='error-container'>
				<h1>404</h1>
				
				<h2>Opa! Alguma coisa de ruim aconteceu.</h2>
				
				<div class='error-details'>
					Me desculpe, ou você não tem permissão ou a pagina não existe.
					
				</div> <!-- /error-details -->
				
				<div class='error-actions'>
				</div> <!-- /error-actions -->
							
			</div> <!-- /error-container -->			
			
		</div> <!-- /span12 -->
		
	</div> <!-- /row -->
	
</div>

</body>

</html>";
}$conn_ocs->query("SET NAMES 'utf8'");
?>