<?php
//chamando o banco
require_once('../conexao/conexao.php');

//iniciando as sessões
session_start();

/*-----------------------------------------------------------*/

//restaurando funcionário e forçando a troca do status para "Sem Equipamento" = 9

if($_GET['tela'] == 1){// tela = 1 vem dos tecnicos

    //1ª ativando o funcionário
    $update_funcionario = "UPDATE manager_inventario_funcionario SET deletar = 0, status = 9 WHERE id_funcionario = ".$_GET['id_fun']."";
    $result_funcionario = mysqli_query($conn, $update_funcionario) or die(mysqli_error($conn));

    //2ª criando sessões para voltar a tela de cadastro com os campos preenchidos
    $existe_cpf_cadastrado = "SELECT 
    MIF.id_funcionario,
    MIF.cpf, 
    MIF.nome, 
    MDF.nome AS funcao,
    MIF.funcao AS id_funcao,
    MDD.nome AS departamento,
    MIF.departamento AS id_departamento,
    MDE.nome AS empresa,
    MIF.empresa AS id_empresa
    FROM manager_inventario_funcionario MIF
    LEFT JOIN manager_dropfuncao MDF ON MIF.funcao = MDF.id_funcao
    LEFT JOIN manager_dropdepartamento MDD ON MIF.departamento = MDD.id_depart
    LEFT JOIN manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa WHERE MIF.id_funcionario = ".$_GET['id_fun']."";
    $resultado_cpf = mysqli_query($conn, $existe_cpf_cadastrado);
    $row_cpf = mysqli_fetch_assoc($resultado_cpf);
    //criando as sessões
    $_SESSION['cpf_cadastrado'] = $row_cpf['cpf'];
    $_SESSION['nome_cadastrado'] = $row_cpf['nome'];
    $_SESSION['funcao_cadastrado'] = $row_cpf['id_funcao'];
    $_SESSION['nome_funcao_cadastrado'] = $row_cpf['funcao'];
    $_SESSION['departamento_cadastrado'] = $row_cpf['id_departamento'];
    $_SESSION['nome_departamento_cadastrado'] = $row_cpf['departamento'];
    $_SESSION['empresa_cadastrado'] = $row_cpf['id_empresa'];
    $_SESSION['nome_empresa_cadastrado'] = $row_cpf['empresa'];    

    //agora iremos enviar para tela de cadastro de equipamento
    header('location: equip_add.php');

}else{
    $update_funcionario = "UPDATE manager_inventario_funcionario SET deletar = 0, status = 9 WHERE id_funcionario = ".$_GET['id_fun']."";
    $result_funcionario = mysqli_query($conn, $update_funcionario) or die(mysqli_error($conn));

    //agora iremos enviar para tela de cadastro de equipamento
    header('location: msn_inativo.php?id='.$_GET['id_fun'].'');
}
?>