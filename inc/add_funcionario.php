<?php
//conexao banco
require_once('../conexao/conexao.php');
require_once('../query/query_dropdowns.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Adicionando Funcionário</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
	form {
		background-color: #a9a9a9c4;
		padding: 2px 21px 2px 21px;
		border-radius: 10px;
	}
	body{
		width: 70%;
		margin-left: 14%;
		margin-top: 7%;
	}
	.btn{
		padding: 0px 25px 2px 25px;
		float: right;
		margin-top: 12px;
	}
</style>

<body>
	<!--ALERTAS-->
	<?php
		if($_GET['msn'] != NULL){
			echo "
			<div class='alert' style='background-color: #bd3434;color: #fff;'>
				<strong>Alerta!</strong> CPF já cadastrado.
			</div>";
		}
	?>
	<form action="insert_funcionario.php" method="POST">
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-2 col-form-label">Nome:</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="inputEmail3" onkeyup="maiuscula(this)" name="nome">
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPassword3" class="col-sm-2 col-form-label">CPF:</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" style="width: 136px;" id="inputPassword3" placeholder="000.000.000-00" class="cpfcnpj" onkeydown="javascript: fMasc( this, mCPF );" name="cpf"/>
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPassword3" class="col-sm-2 col-form-label">Função:</label>
			<div class="col-sm-10">
				<select id="inputState" class="form-control" name="funcao" style="width: 286px;">
					<option selected>Selecione...</option>
					<?php
						while($row_funcao = $resultado_funcao -> fetch_assoc()){
							echo "<option value='".$row_funcao['id_funcao']."'>".$row_funcao['nome']."</option>";	
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPassword3" class="col-sm-2 col-form-label">Departamento:</label>
			<div class="col-sm-10">
				<select id="inputState" class="form-control" name="departamento" style="width: 286px;">
					<option selected>Selecione...</option>
					<?php
						while($row_depart = $resultado_depart -> fetch_assoc()){
							echo "<option value='".$row_depart['id_depart']."'>".$row_depart['nome']."</option>";	
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="inputPassword3" class="col-sm-2 col-form-label">Empresa/Filial:</label>
			<div class="col-sm-10">
				<select id="inputState" class="form-control" name="empresa" style="width: 286px;">
					<option selected>Selecione...</option>
					<?php
						while($row_empresa = $resultado_empresa -> fetch_assoc()){
							echo "<option value='".$row_empresa['id_empresa']."'>".$row_empresa['nome']."</option>";	
						}
					?>
				</select>
			</div>
		</div>		
		<div class="form-group row">
			<div class="col-sm-10">
			<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
		</div>
	</form>
	
</body>
</html>
<!--MASCARA MAIUSCULA-->
<script type="text/javascript">
// INICIO FUNÇÃO DE MASCARA MAIUSCULA
function maiuscula(z) {
    v = z.value.toUpperCase();
    z.value = v;
}
//FIM DA FUNÇÃO MASCARA MAIUSCULA
</script>
<!--CNPJ MASCARA-->
<script src="../js/cnpj.js"></script>