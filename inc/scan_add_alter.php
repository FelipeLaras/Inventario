<?php
//aplicando para usar varialve em outro arquivo
session_start();
//chamando conexão com o banco
require 'conexao.php';

//alterando formato da data
$data_fim = date('Y-m-d',  strtotime($_POST['data_fim_scan']));
/*-----------------------------------------------------------------------------------------*/

//1º Alterando o cadastro do funcionario
    //inativando um usuário
    if($_GET['inativar'] != NULL){
        $update_condenar = " UPDATE manager_inventario_equipamento 
        SET 
        deletar = 1
        WHERE
        id_equipamento = ".$_GET['id_equipamento']." limit 1";
    
        $result_condenar= $conn->query($update_condenar) or die(mysqli_error($conn));
        /*-----------------------------------------------------------------------------------------*/
        //fechando a coneção com o banco de dados
        mysqli_close($conn);
        /*-----------------------------------------------------------------------------------------*/
        header('location:msn_inativo.php?id_equip='.$_GET['id_equipamento'].'');
        exit;
    }

    $update_funcionario = " UPDATE manager_inventario_funcionario 
    SET 
    nome = '".$_POST['nome']."', 
    cpf = '".$_POST['cnpj_forne']."', 
    funcao = '".$_POST['funcao']."', 
    empresa = '".$_POST['empresa']."', 
    departamento = '".$_POST['setor']."'
    WHERE
    id_funcionario = ".$_POST['id_funcionario']." limit 1";

    $result_funcionario = $conn->query($update_funcionario) or die(mysqli_error($conn));
/*-----------------------------------------------------------------------------------------*/
//2º alterando o cadastro do equipamento

    /*ALUGADO*/
    if($_POST['id_situacao'] == 4){//Alugado
        //equipamento
        $update_equip_scan = "UPDATE manager_inventario_equipamento
        SET
        patrimonio = '".$_POST['num_patrimonio_scan']."', 
        filial = '".$_POST['empresa_scan']."', 
        locacao = '".$_POST['locacao_scan']."',
        situacao = '".$_POST['situacao_scan']."', 
        serialnumber = '".$_POST['serie_scan']."',
        fornecedor_scan = '".$_POST['fornecedor_scan']."',
        data_fim_contrato = '".$data_fim."'
        WHERE
        id_equipamento = ".$_POST['id_equipamento']."";

        $result_equip_scan = $conn->query($update_equip_scan) or die(mysqli_error($conn));        
    }//end IF ALUGADO

    /*COMPRADO*/
    if($_POST['id_situacao'] == 5){//Comprado
        //equipamento
        $update_equip_scan = "UPDATE manager_inventario_equipamento
        SET
        patrimonio = '".$_POST['num_patrimonio_scan']."', 
        filial = '".$_POST['empresa_scan']."', 
        locacao = '".$_POST['locacao_scan']."',
        situacao = '".$_POST['situacao_scan']."', 
        serialnumber = '".$_POST['serie_scan']."',
        numero_nota = '".$_POST['numero_nota_scan']."'
        WHERE
        id_equipamento = ".$_POST['id_equipamento']."";

        $result_equip_scan = $conn->query($update_equip_scan) or die(mysqli_error($conn));        
    }//end IF ALUGADO

/*-----------------------------------------------------------------------------------------*/

//3º Voltando para a tela de edição
header('location: scan_edit.php?id_equip='.$_POST['id_equipamento'].'&tipo='.$_POST['id_situacao'].'');

/*-----------------------------------------------------------------------------------------*/
//fechando a coneção com o banco de dados
$conn->clone();
?>