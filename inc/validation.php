<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';

//pegando as informações que o usuário digitou
$user = $_POST['username'];
$key = $_POST['outputHash'];

//criando a query de pesquisa
$query_user = "SELECT 
					id_profile AS id, 
					profile_name AS nome, 
					profile_mail AS mail, 
					profile_type AS perfil,
					emitir_check_list,
					editar_historico,
					editar_cadastro_funcionario,
					profile_deleted AS deletado,
					ativar_cpf,
					desativar_cpf
				FROM 
					manager_profile
				WHERE 
					profile_mail like '".$user."' AND 
					profile_password like '".$key."'";

//Aplicando a query
$result = mysqli_query($conn, $query_user);

//salvando em uma array
$row_user = mysqli_fetch_assoc($result);

//verificando se o usuário está ativo no sistema

if(empty($row_user['nome'])){

	header('location: index.php?erro=1');//usuário não encontrado

}else{
	if($row_user['deletado'] == 1){

		header('location: index.php?erro=2');//usuário desativado

	}else{
		//usuário
		$_SESSION["perfil"] = $row_user["perfil"];
		$_SESSION["id"] = $row_user["id"];
		$_SESSION["nome"] = $row_user["nome"];
		$_SESSION["mail"] = $row_user["mail"];

		//permissões
		$_SESSION["emitir_check_list"] = $row_user["emitir_check_list"];
		$_SESSION["editar_historico"] = $row_user["editar_historico"];
		$_SESSION["editar_cadastroFuncionario"] = $row_user["editar_cadastro_funcionario"];
		$_SESSION["ativar_cpf"] = $row_user["ativar_cpf"];
		$_SESSION["desativar_cpf"] = $row_user["desativar_cpf"];
		
		//entra no sistema
		header('location: manager.php');
	}

}

//fecha o banco
mysqli_close($conn);
?>