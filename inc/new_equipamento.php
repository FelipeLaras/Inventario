<?php 
//iniciando a sessão
session_start();
//Inciando conxão com o banco
require_once('../conexao/conexao.php');

$query_new = "SELECT 
				MIF.cpf, 
				MIF.nome, 
				MIF.departamento AS id_departamento, 
				MIF.funcao AS id_funcao, 
				MIF.empresa AS id_empresa, 
				MDF.nome AS funcao, 
				MDD.nome AS departamento, 
				MDE.nome AS empresa
			FROM 
				manager_inventario_funcionario MIF
			LEFT JOIN 
				manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
			LEFT JOIN
				manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
			LEFT JOIN
				manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa 
			WHERE  MIF.id_funcionario = ".$_GET['id_func']."";

$resultado_new = $conn->query($query_new);

$row_new = mysqli_fetch_assoc($resultado_new) or die(mysqli_error($conn));

//aplicando as session
$_SESSION['new_cpf'] = $row_new['cpf'];

$_SESSION['new_nome'] = $row_new['nome'];

$_SESSION['new_funcao'] = $row_new['funcao'];
$_SESSION['id_funcao'] = $row_new['id_funcao'];


$_SESSION['new_departamento'] = $row_new['departamento'];
$_SESSION['id_departamento'] = $row_new['id_departamento'];

$_SESSION['new_empresa'] = $row_new['empresa'];
$_SESSION['id_empresa'] = $row_new['id_empresa'];

$conn->close();

header('location: inventario_add.php?id_funcio='.$_GET['id_func'].'&id_equip='.$_GET['id_equip'].'');
?>