<?php 
	//banco
	require_once('../conexao/conexao.php');
	//Recebendo as variaveis

	$id = $_POST['id'];
	$nome = $_POST['firstname'];
	$email = $_POST['email'];
	$perfil = $_POST['perfil'];
	$senha = $_POST['outputHash'];
	$senha_branco = "d41d8cd98f00b204e9800998ecf8427e";

	/*checando o usuário antes da atualização*/
	$query ="SELECT profile_name AS nome, profile_mail AS email, profile_password AS senha
	FROM manager_profile WHERE id_profile = ".$id."";
	$resultado = $conn -> query($query);
	$row = $resultado -> fetch_assoc();
	/*--------------------------------------------------------------------------------------*/
	//nome
	if ($nome == NULL) {
		$nome = $row['nome'];
	}
	//email
	if ($email == NULL) {
		$email = $row['email'];
	}
	//senha
	if ($senha == $senha_branco) {
		$senha = $row['senha'];
	}
	/*-------------------------------- EDITAR FUNCIONÁRIO ------------------------------------------*/
	$query_update ="UPDATE manager_profile 
					SET profile_name = '".$nome ."', profile_password = '".$senha."', profile_mail = '".$email."', profile_type = ".$perfil." 
					WHERE id_profile = ".$id."";
	$result_premissao = $conn -> query($query_update);


	/*--------------------------------------- PERMISSÃO --------------------------------------------*/
	//EMIT CHECK-LIST
	if($_POST['check_list'] == 1){
		$premissao = "UPDATE manager_profile SET emitir_check_list = 1 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}else{
		$premissao = "UPDATE manager_profile SET emitir_check_list = 0 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}

	//EDITAR TODOS OS HISTÓRICOS
	if($_POST['editar_historico'] == 1){
		$premissao = "UPDATE manager_profile SET editar_historico = 1 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}else{
		$premissao = "UPDATE manager_profile SET editar_historico = 0 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}

	//EDITAR TODOS OS CADASTROS DE FUNCIONÁRIOS
	if($_POST['editar_cadastro_funcionario'] == 1){
		$premissao = "UPDATE manager_profile SET editar_cadastro_funcionario = 1 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}else{
		$premissao = "UPDATE manager_profile SET editar_cadastro_funcionario = 0 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}

	//ATIVAR CADASTRO FUNCIONÁRIO
	if($_POST['ativar_cpf'] == 1){
		$premissao = "UPDATE manager_profile SET ativar_cpf = 1 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}else{
		$premissao = "UPDATE manager_profile SET ativar_cpf = 0 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}

	//DESATIVAR CADASTRO FUNCIONÁRIO
	if($_POST['desativar_cpf'] == 1){
		$premissao = "UPDATE manager_profile SET desativar_cpf = 1 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}else{
		$premissao = "UPDATE manager_profile SET desativar_cpf = 0 WHERE id_profile =  '".$id."'";
		$result_premissao = $conn -> query($premissao);
	}

	/*---------------------------------------- FINALIZANDO ----------------------------------------*/
	//voltando informando que deu tudo certo
	header('location: edit_front.php?id='.$id.'&msn=1');

	//FECHANDO O BANCO DE DADOS
	$conn -> close();
?>