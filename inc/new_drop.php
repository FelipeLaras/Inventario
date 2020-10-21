<?php 
//abrindo a sessaão
session_start();

//conexão com o banco de dados
require_once('../conexao/conexao.php');
/*---------------------------------------------------------------------------------------------*/
/*  CADASTRANDO NOVO DROP-DOWN(MENUS)
	1º ele checara se já existe
	2º se ele existir manda de volta salvando uma sessão com id do menu para forçar o alerta na pagina manager_drop_inventario
	3º caso não exista ele salva o novo menu.
*/

/*FUNÇÃO*/
if ($_POST['name_funcao'] != NULL) {
	$chek_funcao = "SELECT * FROM manager_dropfuncao WHERE nome = '".$_POST['name_funcao']."'";
	$result_chek_funcao = $conn->query($chek_funcao);

	if ($row_funcao = mysqli_fetch_assoc($result_chek_funcao)) {
		$_SESSION['id_menu'] = $row_funcao['id_funcao'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_funcao = "INSERT INTO manager_dropfuncao (nome) VALUES ('".$_POST['name_funcao']."')";
		$result_insert_funcao = $conn->query($insert_funcao) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeFun'] = 1;
		header('location: manager_drop_inventario.php');
	}
}
//DEPARTAMENTO
if ($_POST['name_departamento'] != NULL) {
	$chek_depart = "SELECT * FROM manager_dropdepartamento WHERE nome = '".$_POST['name_departamento']."'";
	$result_chek_depart = $conn->query($chek_depart);

	if ($row_depart = mysqli_fetch_assoc($result_chek_depart)) {
		$_SESSION['id_menu'] = $row_depart['id_depart'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_depart = "INSERT INTO manager_dropdepartamento (nome) VALUES ('".$_POST['name_departamento']."')";
		$result_insert_depart = $conn->query($insert_depart) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeDep'] = 1;
		header('location: manager_drop_inventario.php');
	}
}
//EMPRESA
if ($_POST['name_empresa'] != NULL) {
	$chek_empresa = "SELECT * FROM manager_dropempresa WHERE nome = '".$_POST['name_empresa']."'";
	$result_chek_empresa = $conn->query($chek_empresa);

	if ($row_empresa = mysqli_fetch_assoc($result_chek_empresa)) {
		$_SESSION['id_menu'] = $row_depart['id_empresa'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_empresa = "INSERT INTO manager_dropempresa (nome) VALUES ('".$_POST['name_empresa']."')";
		$result_insert_empresa = $conn->query($insert_empresa) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeEmp'] = 1;
		header('location: manager_drop_inventario.php');
	}
}
//LOCACAO
if ($_POST['name_locacao'] != NULL) {
	$chek_locacao = "SELECT * FROM manager_droplocacao WHERE nome = '".$_POST['name_locacao']."'";
	$result_chek_locacao = $conn->query($chek_locacao);

	if ($row_locacao = mysqli_fetch_assoc($result_chek_locacao)) {
		$_SESSION['id_menu'] = $row_depart['id_empresa'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_locacao = "INSERT INTO manager_droplocacao (nome) VALUES ('".$_POST['name_locacao']."')";
		$result_insert_locacao = $conn->query($insert_locacao) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeLoc'] = 1;
		header('location: manager_drop_inventario.php');
	}
}
//STATUS DO COLABORADOR
if ($_POST['name_status_colaborador'] != NULL) {
	$chek_status_colaborador = "SELECT * FROM manager_dropstatus WHERE nome = '".$_POST['name_status_colaborador']."'";
	$result_chek_status_colaborador = $conn->query($chek_status_colaborador);

	if ($row_status_colaborador = mysqli_fetch_assoc($result_chek_status_colaborador)) {
		$_SESSION['id_menu'] = $row_status_colaborador['id_statusFun'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_status_colaborador = "INSERT INTO manager_dropstatus (nome) VALUES ('".$_POST['name_status_colaborador']."')";
		$result_insert_status_colaborador = $conn->query($insert_status_colaborador) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeSt'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//EQUIPAMENTOS
if ($_POST['name_equipamentos'] != NULL) {
	$chek_equipamento = "SELECT * FROM manager_dropequipamentos WHERE nome = '".$_POST['name_equipamentos']."'";
	$result_equipamento = $conn->query($chek_equipamento);

	if ($row_equipamento = mysqli_fetch_assoc($result_equipamento)) {
		$_SESSION['id_menu'] = $row_equipamento['id_equip'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_equipamento = "INSERT INTO manager_dropequipamentos (nome) VALUES ('".$_POST['name_equipamentos']."')";
		$result_insert_equipamento = $conn->query($insert_equipamento) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeEquip'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//SITUAÇÃO
if ($_POST['name_situacao'] != NULL) {
	$chek_situacao = "SELECT * FROM manager_dropsituacao WHERE nome = '".$_POST['name_situacao']."'";
	$result_situacao = $conn->query($chek_situacao);

	if ($row_situacao = mysqli_fetch_assoc($result_situacao)) {
		$_SESSION['id_menu'] = $row_situacao['id_situacao'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_situacao = "INSERT INTO manager_dropsituacao (nome) VALUES ('".$_POST['name_situacao']."')";
		$result_insert_situacao = $conn->query($insert_situacao) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeSit'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//ESTADO
if ($_POST['name_estado'] != NULL) {
	$chek_estado = "SELECT * FROM manager_dropestado WHERE nome = '".$_POST['name_estado']."'";
	$result_estado = $conn->query($chek_estado);

	if ($row_estado = mysqli_fetch_assoc($result_estado)) {
		$_SESSION['id_menu'] = $row_estado['id'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_estado = "INSERT INTO manager_dropestado (nome) VALUES ('".$_POST['name_estado']."')";
		$result_insert_estado = $conn->query($insert_estado) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeEst'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//ACESSORIOS
if ($_POST['name_acessorios'] != NULL) {
	$chek_acessorios = "SELECT * FROM manager_dropacessorios WHERE nome = '".$_POST['name_acessorios']."'";
	$result_acessorios = $conn->query($chek_acessorios);

	if ($row_acessorios = mysqli_fetch_assoc($result_acessorios)) {
		$_SESSION['id_menu'] = $row_acessorios['id_acessorio'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_acessorios = "INSERT INTO manager_dropacessorios (nome) VALUES ('".$_POST['name_acessorios']."')";
		$result_insert_acessorios = $conn->query($insert_acessorios) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeAce'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//OPERADORA
if ($_POST['name_operadora'] != NULL) {
	$chek_operadora = "SELECT * FROM manager_dropoperadora WHERE nome = '".$_POST['name_operadora']."'";
	$result_operadora = $conn->query($chek_operadora);

	if ($row_operadora = mysqli_fetch_assoc($result_operadora)) {
		$_SESSION['id_menu'] = $row_operadora['id_operadora'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_operadora = "INSERT INTO manager_dropoperadora (nome) VALUES ('".$_POST['name_operadora']."')";
		$result_insert_operadora = $conn->query($insert_operadora) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeOp'] = 1;
		echo "olá";
		header('location: manager_drop_inventario.php');
	}
}

//STATUS EQUIPAMENTO
if ($_POST['name_status_equipamento'] != NULL) {
	$chek_status_equipamento = "SELECT * FROM manager_dropstatusequipamento WHERE nome = '".$_POST['name_status_equipamento']."'";
	$result_status_equipamento = $conn->query($chek_status_equipamento);

	if ($row_status_equipamento = mysqli_fetch_assoc($result_status_equipamento)) {
		$_SESSION['id_menu'] = $row_status_equipamento['id_status'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_status_equipamento = "INSERT INTO manager_dropstatusequipamento (nome) VALUES ('".$_POST['name_status_equipamento']."')";
		$result_status_equipamento = $conn->query($insert_status_equipamento) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeStEquip'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//OFFICE
if ($_POST['name_office'] != NULL) {
	$chek_office = "SELECT * FROM manager_dropoffice WHERE nome = '".$_POST['name_office']."'";
	$result_office = $conn->query($chek_office);

	if ($row_office = mysqli_fetch_assoc($result_office)) {
		$_SESSION['id_menu'] = $row_office['id'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_office = "INSERT INTO manager_dropoffice (nome) VALUES ('".$_POST['name_office']."')";
		$result_office = $conn->query($insert_office) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeOf'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

//WINDOWS
if ($_POST['name_windows'] != NULL) {
	$chek_windows = "SELECT * FROM manager_dropsistemaoperacional WHERE nome = '".$_POST['name_windows']."'";
	$result_windows = $conn->query($chek_windows);

	if ($row_windows = mysqli_fetch_assoc($result_windows)) {
		$_SESSION['id_menu'] = $row_windows['id'];
		header('location: manager_drop_inventario.php');
	}else{
		$insert_windows = "INSERT INTO manager_dropsistemaoperacional (nome) VALUES ('".$_POST['name_windows']."')";
		$result_windows = $conn->query($insert_windows) or die(mysqli_error($conn));
		$_SESSION['salvo'] = 1;
		$_SESSION['activeOs'] = 1;
		header('location: manager_drop_inventario.php');
	}
}

/*FIM*/
/*---------------------------------------------------------------------------------------------*/

//fechando a conexão
$conn->close();
?>