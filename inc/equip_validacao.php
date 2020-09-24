<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o bancoF
require_once('../conexao/conexao.php');

//1º vamos validar o CPF

if ($_POST['gols1'] != NULL) {

    $existe_cpf_cadastrado = "SELECT 
    MIF.id_funcionario,
    MIF.deletar, 
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
    LEFT JOIN manager_dropempresa MDE ON MIF.empresa = MDE.id_empresa WHERE MIF.cpf = '".$_POST['gols1']."'";
    $resultado_cpf = $conn->query($existe_cpf_cadastrado);

    //iniciando a validação
    if($row_cpf = $resultado_cpf->fetch_assoc()){

        if($row_cpf['deletar'] == 1){
            /*--- VOLTANDO PARA A TELA - ERRO 1 FUNCIONÁRIO DESATIVADO ---*/
            header('location: equip_add.php?error=1&id='.$row_cpf['id_funcionario'].'');
        }else{
            $_SESSION['cpf_cadastrado'] = $row_cpf['cpf'];
            $_SESSION['nome_cadastrado'] = $row_cpf['nome'];
            $_SESSION['funcao_cadastrado'] = $row_cpf['id_funcao'];
            $_SESSION['nome_funcao_cadastrado'] = $row_cpf['funcao'];
            $_SESSION['departamento_cadastrado'] = $row_cpf['id_departamento'];
            $_SESSION['nome_departamento_cadastrado'] = $row_cpf['departamento'];
            $_SESSION['empresa_cadastrado'] = $row_cpf['id_empresa'];
            $_SESSION['nome_empresa_cadastrado'] = $row_cpf['empresa'];
            /*---VOLTANDO PARA A TELA---*/
            header('location: equip_add.php');
        }//end if = deletar: 1
    }else{
        $_SESSION['cpf_nao_encontrado'] = $_POST['gols1'];
        $_SESSION['nome_nao_cadastrado'] = $_POST['nome_funcionario'];
        $_SESSION['funcao_nao_cadastrado'] = $_POST['funcao_funcionario'];
        $_SESSION['departamento_nao_cadastrado'] = $_POST['depart_funcionario'];
        $_SESSION['empresa_nao_cadastrado'] = $_POST['empresa_funcionario'];
        header('location: equip_add.php');
    }//end fim busca cpf
}//end IF = validação cpf

/*------------------------------------------------------------------------------------------------ */

//fechando o banco de dados
$conn->close();
?>