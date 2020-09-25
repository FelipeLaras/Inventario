<?php
//banco
include ('../conexao/conexao.php');

//montando a query para pegar mais informações do usuário
$query_profile = "SELECT id_profile AS id, profile_deleted AS deletar FROM manager_profile WHERE id_profile = ".$_GET['id']."";
//aplicando a query no banco
$result_profile = $conn -> query($query_profile);
//salvando o resultado numa array
$row_profile = $result_profile -> fetch_assoc();
//verificando se está ativo = desativa ou desativa = ativa

	$query_desativar = "UPDATE manager_profile SET profile_deleted = ";

	if ($row_profile['deletar'] == 0) {//desativando
		$query_desativar .= "1";
		
		$ativando = 1;
	}else{
		$query_desativar .= "0";

		$ativando = 0;
	}

	$query_desativar .= " WHERE id_profile = ".$_GET['id']."";
	
	$result_desativar = mysqli_query($conn, $query_desativar);
	$row_desativar = mysqli_fetch_assoc($result_desativar);

	header('Location: alert_drop_user.php?id='.$ativando.'');
?>