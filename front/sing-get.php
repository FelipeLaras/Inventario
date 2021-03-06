<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Login - CPD</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!--FAVICON-->
	<link href="../img/favicon.ico" rel="icon" type="image/x-icon" />
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

	<link href="../css/font-awesome.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<link href="../css/pages/signin.css" rel="stylesheet" type="text/css">

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
				<a class="brand" href="../index.php">
					<img src="../img/fd_logo.png" id="logo">
				</a>
				<div class="nav-collapse">
					<ul class="nav pull-right">
						<li class="">
							<a href="sing-get.html" class="">
								Você não tem uma conta?
							</a>
						</li>
						<li class="">
							<a href="http://rede.paranapart.com.br/glpi" class="">
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
	</div> <!-- /navbar -->

	<div class="account-container register">

		<?php

		switch ($_GET['msn']) {
			case '1':
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><ul><li>Solicitação Enviada!</li><li>Agora basta aguardar o e-mail de confirmação.</li></ul></div>';
				break;
		}
		?>
		<div class="content clearfix">
			<form action="../inc/email.php" method="post" oninput="outputHash.value = md5(password.value)">

				<h1>Solicite uma conta!</h1>

				<div class="login-fields">

					<p>Preencha os campos abaixo!</p>

					<div class="field">
						<label for="firstname">Nome:</label>
						<input type="text" id="firstname" name="firstname" value="" placeholder="Nome" class="login" required />
					</div> <!-- /field -->

					<div class="field">
						<label for="email">Endereço e-mail:</label>
						<input type="email" id="email" name="email" value="" placeholder="E-mail" class="login" required />
					</div> <!-- /field -->

					<div class="field">
						<label for="perfil">Perfil de Acesso:</label>
						<select name="perfil" class="form-control" required>
							<option value="">Selecione o seu perfil</option>
							<option value="tecnico" title="Telas: Tecnicos">Técnico</option>
							<option value="usuario" title="Telas: Contratos">Usuário</option>
						</select>
					</div> <!-- /field -->

					<div class="field">
						<label for="password">Senha:</label>
						<input type="password" id="password" name="senha" placeholder="Senha" class="login" required />
					</div> <!-- /field -->

					<div class="field">
						<label for="confirm_password">Confirma Senha:</label>
						<input type="password" id="confirm_password" name="confirm_password" value="" placeholder="Confirme Senha" class="login" required />
					</div> <!-- /field -->

					<div class="field">
						<label for="descricao">Motivo do qual você precisa do acesso:</label>
						<textarea rows="4" name="mensagem" placeholder="Motivo do qual você precisa do acesso" style="width: 96%;" required></textarea>
					</div> <!-- /field -->

				</div> <!-- /login-fields -->

				<div class="login-actions">

					<button class="button btn btn-primary btn-large">Solicitar</button>

				</div> <!-- .actions -->

			</form>

		</div> <!-- /content -->

	</div> <!-- /account-container -->


	<!-- Text Under Box -->
	<div class="login-extra">
		Já tem uma conta? <a href="../index.php">Faça login na sua conta</a>
	</div> <!-- /login-extra -->


	<script src="../js/jquery-1.7.2.min.js"></script>
	<script src="../js/bootstrap.js"></script>

	<script src="../js/signin.js"></script>
	<!-- MD5 -->
	<script src="../js/md5.js"></script>

</body>

</html>