<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';
//Aplicando a regra de login
if($_SESSION["perfil"] == NULL){  
     header('location: index.html');
 }
/*Esta regra não deixa que os perfils que seja diferente do administrador possa alterar dados dos usuários que não seja apenas o seu proprio perfil*/
if ($_SESSION["perfil"] == 0) {
	$usuario_edit = $_GET['id'];
}else{
	$usuario_edit = $_SESSION["id"];
}
//montando a query
$query_edit_user = "SELECT 
						MP.id_profile AS id, 
						MP.profile_name AS nome, 
						MP.profile_mail AS email, 
						MP.profile_password AS senha, 
						MPT.type_name AS perfil,
						MP.emitir_check_list AS list,
						MP.editar_historico,
						MP.editar_cadastro_funcionario,
						MP.ativar_cpf,
						MP.desativar_cpf
                  	FROM 
					  	manager_profile MP
                  	LEFT JOIN 
					  	manager_profile_type MPT ON MP.profile_type = MPT.type_profile 
                  	WHERE 
					  	MP.id_profile = ".$usuario_edit."";
//aplicando a query
$resultado_edit = mysqli_query($conn, $query_edit_user);
//salvando em uma variavel
$row_edit = mysqli_fetch_assoc($resultado_edit);

#trocando string do profile por ID
$query_profile = "SELECT type_profile AS profile 
					FROM manager_profile_type WHERE type_name LIKE '".$row_edit['perfil']."'";

$resultado_profile = mysqli_query($conn, $query_profile);
$row_profile = mysqli_fetch_assoc($resultado_profile);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>EDITAR - <?= $row_edit['nome'] ?></title>
    <!--FAVICON-->
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
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
	<?php  
	//chamando a header
	require 'header.php';	
	/* -------------------  ALERTAS -------------------  */
	if($_GET['msn'] == 1){
		echo "
			<div class='alert alert-success'>
				<button type='button' class='close' data-dismiss='alert'>×</button>
				<strong>Atenção!</strong> Dados alterados alterado com sucesso!
			</div>";
	}
	?>
    <!--Chamando a Header-->
    <div class="account-container register">

        <div class="content clearfix">
            <form action="edit_back.php" method="post" oninput="outputHash.value = md5(password.value)">

                <h1>Alterar Dados</h1>

                <div class="login-fields">

                    <p>Edite os campos abaixo!</p>
                    <?php
												
				echo "<div class='field'>
						<input type='text' name='id' value='".$row_edit['id']."' style='display: none;'/>
						<label for='firstname'>Nome:</label>
						<input type='text' id='firstname' name='firstname' value='".$row_edit['nome']."' class='login'></input>
					  </div>				
					
					<div class='field'>
						<label for='email'>Endereço e-mail:</label>
						<input type='text' id='email' name='email' value='".$row_edit['email']."' class='login'/>
					</div>";
					if ($_SESSION["perfil"] == 0) {	// se for administrador						
					echo "<div class='field'>
							<label for='perfil'>Perfil:</label>
							<select name='perfil'>
								<option value='".$row_profile['profile']."'>".$row_edit['perfil']."</option>";

								$query_perfil = "SELECT * FROM manager_profile_type";
				                $resultado_perfil = mysqli_query($conn, $query_perfil);
				                while ($row_perfil = mysqli_fetch_assoc($resultado_perfil)) {

				                   echo "<option value='".$row_perfil['type_profile']."'>".$row_perfil['type_name']."</option>";
				                 }
				                 mysqli_close($conn);			                 
						echo	"</select>
						</div>
						<div class='field'>
						<label for='password'>Senha:</label>
						<input type='password' id='password'  name='password value='".$row_edit['senha']."' placeholder='Senha' class='login'/>
						<!--MD5-->
	                    <input type='text' for='password' name='outputHash' id='outputHash' style='display:none;'>
					</div>";
					}else{					
					echo "<div class='field'>
						<label for='password'>Senha:</label>
						<input type='text' name='perfil' value='".$row_profile['profile']."' style='display: none;'/>
						<input type='password' id='password'  name='password value='".$row_edit['senha']."' placeholder='Senha' class='login'/>
						<!--MD5-->
	                    <input type='text' for='password' name='outputHash' id='outputHash' style='display:none;'>
					</div>";
				}
				?>

				</div> <!-- /login-fields -->
				<div class="control-group">											
					<p>Permissões</p>
					<div class="controls">
						<ul style="list-style-type:none;">
							<li>								
								<label class='checkbox inline'>
									<input type='checkbox' name='check_list' value='1' <?= ($row_edit['list'] == 0) ?: "checked" ?>/> Emitir check-list
								</label>
							</li>
							<li>								
								<label class='checkbox inline'>
									<input type='checkbox' name='editar_historico' value='1' <?= ($row_edit['editar_historico'] == 0) ?: "checked" ?>/> Editar Histórico
								</label>
							</li>
							<li>								
								<label class='checkbox inline'>
									<input type='checkbox' name='editar_cadastro_funcionario' value='1' <?= ($row_edit['editar_cadastro_funcionario'] == 0) ?: "checked" ?>/> Editar cadastro funcionário
								</label>
							</li>
							<li>								
								<label class='checkbox inline'>
									<input type='checkbox' name='ativar_cpf' value='1' <?= ($row_edit['ativar_cpf'] == 0) ?: "checked" ?>/> Ativar cadastro de funcionário
								</label>
							</li>
							<li>								
								<label class='checkbox inline'>
									<input type='checkbox' name='desativar_cpf' value='1' <?= ($row_edit['desativar_cpf'] == 0) ?: "checked" ?>/> Desativar cadastro de funcionário
								</label>
							</li>
						</ul>					
					</div>	
				</div>

                <div class="login-actions">

                    <button class="button btn btn-primary btn-large">Alterar</button>

                </div> <!-- .actions -->

            </form>

        </div> <!-- /content -->

    </div> <!-- /account-container -->


    <!-- Text Under Box -->
    <div class="login-extra">
        Já tem uma conta? <a href="index.html">Faça login na sua conta</a>
    </div> <!-- /login-extra -->

    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <script src="js/signin.js"></script>
    <!-- MD5 -->
    <script src="js/md5.js"></script>
</body>

</html>