<?php
//abrindo a sessão
session_start();
//banco
require 'conexao.php';
//pegando id 
$id = $_GET['id'];

//montando a query para pegar mais informações do usuário
$query_profile = "SELECT id_profile AS id, profile_deleted AS deletar 
					FROM manager_profile WHERE id_profile = ".$id."";
//aplicando a query no banco
$result_profile = mysqli_query($conn, $query_profile);
//salvando o resultado numa array
$row_profile = mysqli_fetch_assoc($result_profile);
//verificando se está ativo = desativa ou desativa = ativa
// 0 ativado, 1 desativado
if ($row_profile['deletar'] == 0) {//desativando
	$query_desativar = "UPDATE manager_profile SET profile_deleted = 1
						WHERE id_profile = ".$id." LIMIT 1 ";
	$result_desativar = mysqli_query($conn, $query_desativar);
	$row_desativar = mysqli_fetch_assoc($result_desativar);

	$_SESSION['id_user'] = 1;

	header('location: alert_drop_user.php');

}else{//ativando
	$query_desativar = "UPDATE manager_profile SET profile_deleted = 0
						WHERE id_profile = ".$id." LIMIT 1 ";
	$result_desativar = mysqli_query($conn, $query_desativar);

	$row_desativar = mysqli_fetch_assoc($result_desativar);

	$_SESSION['id_user'] = 0;

	header('location: alert_drop_user.php');
}
mysqli_close($conn);
?>