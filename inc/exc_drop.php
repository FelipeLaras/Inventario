<?php
//chamando a sessão
session_start(); 
//chamando o banco de dados
require_once('../conexao/conexao.php');

/*----------------------------------------------------------------------------------------------*/

/*EXCLUINDO OS MENUS*/

//FUNCÃO
if ($_POST['id_funcao'] != NULL) {
	$update_funcao = "UPDATE manager_dropfuncao SET deletar = 1 WHERE id_funcao = '".$_POST['id_funcao']."'";
	$result_funcao = $conn->query($update_funcao);
	$_SESSION['exc'] = $_POST['id_funcao'];
	header('location: manager_drop_inventario.php');
}

//DEPARTAMENTO
if ($_POST['id_depart'] != NULL) {
	
	$update_departamento = "UPDATE manager_dropdepartamento SET deletar = 1 WHERE id_depart = '".$_POST['id_depart']."'";
	$result_departamento = $conn->query($update_departamento);
	$_SESSION['exc'] = $_POST['id_depart'];
	header('location: manager_drop_inventario.php');
}

//EMPRESA
if ($_POST['id_empresa'] != NULL) {
	$update_empresa = "UPDATE manager_dropempresa SET deletar = 1 WHERE id_empresa = '".$_POST['id_empresa']."'";
	$result_empresa = $conn->query($update_empresa);
	$_SESSION['exc'] = $_POST['id_empresa'];
	header('location: manager_drop_inventario.php');
}

//LOCACAO
if ($_POST['id_locacao'] != NULL) {
	$update_locacao = "UPDATE manager_droplocacao SET deletar = 1 WHERE id_empresa  = '".$_POST['id_locacao']."'";
	$result_locacao = $conn->query($update_locacao);
	$_SESSION['exc'] = $_POST['id_locacao'];
	header('location: manager_drop_inventario.php');
}


//STATUS DO COLABORADOR
if ($_POST['id_status'] != NULL) {
	$update_status_colaborador = "UPDATE manager_dropstatus SET deletar = 1 WHERE id_status = '".$_POST['id_status']."'";
	$result_status_colaborador = $conn->query($update_status_colaborador);
	$_SESSION['exc'] = $_POST['id_status'];
	header('location: manager_drop_inventario.php');
}

//EQUIPAMENTOS
if ($_POST['id_equip'] != NULL) {
	$update_equip = "UPDATE manager_dropequipamentos SET deletar = 1 WHERE id_equip = '".$_POST['id_equip']."'";
	$result_equip = $conn->query($update_equip);
	$_SESSION['exc'] = $_POST['id_equip'];
	header('location: manager_drop_inventario.php');
}

//SITUACAO
if ($_POST['id_situacao'] != NULL) {
	$update_situacao = "UPDATE manager_dropsituacao SET deletar = 1 WHERE id_situacao = '".$_POST['id_situacao']."'";
	$result_situacao = $conn->query($update_situacao);
	$_SESSION['exc'] = $_POST['id_situacao'];
	header('location: manager_drop_inventario.php');
}

//ESTADO
if ($_POST['id_estado'] != NULL) {
	$update_estado= "UPDATE manager_dropestado SET deletar = 1 WHERE id = '".$_POST['id_estado']."'";
	$result_estado = $conn->query($update_estado);
	$_SESSION['exc'] = $_POST['id_estado'];
	header('location: manager_drop_inventario.php');
}

//ACESSORIOS
if ($_POST['id_acessorio'] != NULL) {
	$update_acessorios = "UPDATE manager_dropacessorios SET deletar = 1 WHERE id_acessorio = '".$_POST['id_acessorio']."'";
	$result_acessorios = $conn->query($update_acessorios);
	$_SESSION['exc'] = $_POST['id_acessorio'];
	header('location: manager_drop_inventario.php');
}

//OPERADORA
if ($_POST['id_operadora'] != NULL) {
	$update_operadora = "UPDATE manager_dropoperadora SET deletar = 1 WHERE id_operadora = '".$_POST['id_operadora']."'";
	$result_operadora = $conn->query($update_operadora);
	$_SESSION['exc'] = $_POST['id_operadora'];
	header('location: manager_drop_inventario.php');
}

//STATUS DO EQUIPAMENTO
if ($_POST['id_status'] != NULL) {
	$update_status_equipamento = "UPDATE manager_dropstatusequipamento SET deletar = 1 WHERE id_status = '".$_POST['id_status']."'";
	$result_status_equipamento = $conn->query($update_status_equipamento);
	$_SESSION['exc'] = $_POST['id_status'];
	header('location: manager_drop_inventario.php');
}

//OFFICE
if ($_POST['id_office'] != NULL) {
	$update_office = "UPDATE manager_dropoffice SET deletar = 1 WHERE id = '".$_POST['id_office']."'";
	$result_office = $conn->query($update_office);
	$_SESSION['exc'] = $_POST['id_office'];
	header('location: manager_drop_inventario.php');
}

//SISTEMA OPERACIONAL (WINDOWS)
if ($_POST['id_windows'] != NULL) {
	$update_windows = "UPDATE manager_dropsistemaoperacional SET deletar = 1 WHERE id = '".$_POST['id_windows']."'";
	$result_windows = $conn->query($update_windows);
	$_SESSION['exc'] = $_POST['id_windows'];
	header('location: manager_drop_inventario.php');
}

/*----------------------------------------------------------------------------------------------*/
//fechando conexao com o banco
$conn->close();
?>