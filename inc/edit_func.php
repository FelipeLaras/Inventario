<?php 
//sessão
session_start();

//conexão com o banco de dados
include 'conexao.php';

//data de hoje

$data = date('d/m/Y G:i:s');

/*_______________________________________________________________________*/

if ($_POST['inativar'] != NULL) {
	/*_______________________________________________________________________*/
	//verifciando se o usuário possui equipamentos antes de ser desativado
	$query_validacao = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$_POST['id_funcionario']."'";
	$resultado_validacao = mysqli_query($conn, $query_validacao);

	if ($row_valid = mysqli_fetch_assoc($resultado_validacao)) {
		/*se ecnontrar algum equipamento volta para a tela informando 
		que deve tirar todos os equipamento primeiros*/
		header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&id_equip='.$row_valid['id_equipamento'].'');
		exit;
	}else{
		$update = "UPDATE manager_inventario_funcionario SET deletar = 1 where id_funcionario = '".$_POST['id_funcionario']."'";

		$resultado_update = mysqli_query($conn,$update) or die(mysqli_error($conn));

		header('location: msn_inativo.php');
	}
}else{
	$query_edit_func = "UPDATE 
							manager_inventario_funcionario
						SET 
							cpf = '".$_POST['cnpj_forne']."',
							nome = '".$_POST['nome']."',
							funcao = '".$_POST['funcao']."', 
							departamento = '".$_POST['setor']."', 
							empresa = '".$_POST['empresa']."',
							status = '".$_POST['status']."'
						WHERE 
							id_funcionario = '".$_POST['id_funcionario']."'";

	$resultado = mysqli_query($conn, $query_edit_func) or die(mysqli_error($conn));

	header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'');
}

/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

$log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_funcionario']."',
						'".$data."',
						'".$_SESSION["id"]."',
						'0')";
$result_log = mysqli_query($conn, $log_query) or die(mysqli_error($conn));

/*_________________________________ FECHANDO O BANCO ______________________________________*/

mysqli_close($conn);

?>