<?php 
//sessão
session_start();

//conexão com o banco de dados
require_once('../conexao/conexao.php');

//data de hoje

$data = date('d/m/Y G:i:s');

/*_______________________________________________________________________*/

if ($_POST['inativar'] != NULL) {
	/*_______________________________________________________________________*/
	//verifciando se o usuário possui equipamentos antes de ser desativado
	$query_validacao = "SELECT id_equipamento FROM manager_inventario_equipamento WHERE id_funcionario = '".$_POST['id_funcionario']."'";
	$resultado_validacao = $conn -> query($query_validacao);

	if ($row_valid = $resultado_validacao -> fetch_assoc()) {
		/*se ecnontrar algum equipamento volta para a tela informando 
		que deve tirar todos os equipamento primeiros*/
		header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'&id_equip='.$row_valid['id_equipamento'].'');
		exit;
	}else{
		$update = "UPDATE manager_inventario_funcionario SET deletar = 1 where id_funcionario = '".$_POST['id_funcionario']."'";

		$resultado_update = $conn -> query($update);

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

	$resultado = $conn -> query($query_edit_func);

	header('location: inventario_edit.php?id='.$_POST['id_funcionario'].'');
}

/*_________________________________ SALVANDO LOG DE ALTERAÇÃO ______________________________________*/

$log_query = "INSERT manager_log (id_funcionario, data_alteracao, usuario, tipo_alteracao)
				VALUES ('".$_POST['id_funcionario']."',
						'".$data."',
						'".$_SESSION["id"]."',
						'0')";
$result_log = $conn -> query($log_query);

/*_________________________________ FECHANDO O BANCO ______________________________________*/

$conn -> close();

?>