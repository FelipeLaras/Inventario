<?php
//abrindo a sessão
session_start();
//banco
require_once('../conexao/conexao.php');

//pegando id 
$id = $_GET['id'];

//montando a query para pegar mais informações do usuário
$query_profile = "SELECT id_profile AS id, profile_deleted AS deletar 
					FROM manager_profile WHERE id_profile = ".$id."";
//aplicando a query no banco
$result_profile = $conn -> query($query_profile);
//salvando o resultado numa array
$row_profile = $result_profile -> fetch_assoc();
//verificando se está ativo = desativa ou desativa = ativa
// 0 ativado, 1 desativado
if ($row_profile['deletar'] == 0) {//desativando
	$query_desativar = "UPDATE manager_profile SET profile_deleted = 1
						WHERE id_profile = ".$id." LIMIT 1 ";
	$result_desativar = $conn -> query($query_desativar);
	$row_desativar = $result_desativar -> fetch_assoc();

	$_SESSION['id_user'] = 1;

	header('location: alert_drop_user.php');

}else{//ativando
	$query_desativar = "UPDATE manager_profile SET profile_deleted = 0
						WHERE id_profile = ".$id." LIMIT 1 ";
	$result_desativar = $conn -> query($query_desativar);

	$row_desativar = $result_desativar -> fetch_assoc();

	$_SESSION['id_user'] = 0;

	header('location: alert_drop_user.php');
}
$conn -> close();
?>