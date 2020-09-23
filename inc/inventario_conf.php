<?php
session_start(); 
//CONEXÂO BANCO DE DADOS
include 'conexao.php';

/*VERIFICANDO SE O USUÁRIO JA EXISTE NO BD*/
if ($_POST['gols1'] != NULL) {
	$query_funcionario = "";//fazendo a query para buscar o funcionario
	$resultado_funcionario = mysqli_query($conn, $query_funcionario);//aplicando a query no bd
	$row_funcionario = mysqli_fetch_assoc($resultado_funcionario);//salvando o resultado da query em uma variavel
	
	$_SESSION['nome_formulario'] = $row_funcionario['nome'];//salvando o nome do funcionario em uma sessão para ser usado no formulario
	$_SESSION['cpf_formulario'] = $row_funcionario['cpf'];//salvando o cfp do funcionario em uma sessão para ser usado no formulario

	header('location: inventario_add.php');//voltando para o formulario com as sessões já preenchidas
	
	mysqli_close($conn);//fechando a conexão com o bd
}else {

	$_SESSION['cpf_vazia'] = $_POST['gols1'];//pegando a informação que o usuario colocou e salvando em uma sessão
	header('location: inventario_add.php');//voltando para o formulario com a informação que o usuario digitou
}


/*INSERINDO NOVO FUNCIONARIO*/

/*EDITANDO NOVO FUNCIONARIO*/

/*EXCLUINDO NOVO FUNCIONARIO*/

?>