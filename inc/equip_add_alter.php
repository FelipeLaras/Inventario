<?php
session_start();
//chamando conexão com o banco
require_once('../conexao/conexao.php');
/*-----------------------------------------------------------------------------------------*/

//1º Alterando o cadastro do funcionario

//caso for inativar um usuário
if($_GET['inativar'] != NULL){
    $update_condenar = " UPDATE manager_inventario_equipamento 
    SET 
    deletar = 1
    WHERE
    id_equipamento = ".$_GET['id_equipamento']." limit 1";

    $result_condenar= $conn -> query($update_condenar);
    /*-----------------------------------------------------------------------------------------*/
    //fechando a coneção com o banco de dados
    $conn -> close();
    /*-----------------------------------------------------------------------------------------*/
    header('location:msn_inativo.php?id_equip='.$_GET['id_equipamento'].'');
    exit;
}else{//edita apenas o funcionário
    $update_funcionario = " UPDATE manager_inventario_funcionario 
    SET 
    nome = '".$_POST['nome']."', 
    cpf = '".$_POST['cnpj_forne']."', 
    funcao = '".$_POST['funcao']."', 
    empresa = '".$_POST['empresa']."', 
    departamento = '".$_POST['setor']."'
    WHERE
    id_funcionario = ".$_POST['id_funcionario']." limit 1";

    $result_funcionario = $conn -> query($update_funcionario);
}
    
/*-----------------------------------------------------------------------------------------*/
//2º alterando o cadastro do equipamento

if($_POST['tipo_equipamento'] == 8){//desktop
    //equipamento
    $update_equip_cpu = "UPDATE manager_inventario_equipamento
    SET
    patrimonio = '".$_POST['num_patrimonio_cpu']."', 
    filial = '".$_POST['empresa_cpu']."', 
    locacao = '".$_POST['locacao_cpu']."', 
    departamento = '".$_POST['depart_cpu']."', 
    hostname = '".$_POST['nome_cpu']."', 
    ip = '".$_POST['ip_cpu']."',
    modelo = '".$_POST['modelo_cpu']."', 
    processador = '".$_POST['processador_cpu']."', 
    hd = '".$_POST['hd_cpu']."', 
    memoria = '".$_POST['memoria_cpu']."', 
    situacao = '".$_POST['situacao_cpu']."', 
    serialnumber = '".$_POST['serie_cpu']."'
    WHERE
    id_equipamento = ".$_POST['id_equipamento']."";

    $result_equip_cpu = $conn -> query($update_equip_cpu);

    //windows
    #verificar se já possui windows
    $queryVerificarWindows = "SELECT id FROM manager_sistema_operacional WHERE id_equipamento = ".$_POST['id_equipamento']."";
    $resultVerificarWindows = $conn->query($queryVerificarWindows);

    if(!empty($verificarWindows = $resultVerificarWindows->fetch_assoc())){
        $update_cpu_so = "UPDATE manager_sistema_operacional
                            SET
                                versao = '".$_POST['so_cpu']."', 
                                serial = '".$_POST['serial_so_cpu']."',
                                fornecedor = '".$_POST['fornecedor_so_cpu']."',
                                locacao = '".$_POST['locacao_cpu']."'
                            WHERE
                                id_equipamento = ".$_POST['id_equipamento']." ";
        $result_cpu_so = $conn -> query($update_cpu_so);
    }else{
        $insertWindows = "INSERT INTO manager_sistema_operacional (id_equipamento, versao, serial, fornecedor) VALUES ('".$_POST['id_equipamento']."', '".$_POST['so_cpu']."','".$_POST['serial_so_cpu']."', '".$_POST['fornecedor_so_cpu']."')";
        if(!$resultWindows = $conn->query($insertWindows)){
            printf("Erro cod[2]: %s\n", $conn->error);
        }
    }

    //office
    if($_POST['id_office'] != NULL){
        $update_cpu_office = "UPDATE manager_office
        SET
        versao = '".$_POST['tipo_office']."', 
        serial = '".$_POST['serial_nota_office_cpu']."', 
        fornecedor = '".$_POST['fornecedor_office_cpu']."',
        locacao = '".$_POST['locacao_office_cpu']."', 
        empresa = '".$_POST['empresa_office_cpu']."'
        WHERE
        id_equipamento = ".$_POST['id_equipamento']."";
        
        $result_cpu_office = $conn -> query($update_cpu_office);
    }//end IF OFFICE CPU
}
    
if($_POST['tipo_equipamento'] == 9){//notebook
    $update_equip_note = "UPDATE manager_inventario_equipamento
    SET
    patrimonio = '".$_POST['num_patrimonio_notebook']."', 
    filial = '".$_POST['empresa_notebook']."', 
    locacao = '".$_POST['locacao_notebook']."', 
    departamento = '".$_POST['depart_notebook']."', 
    hostname = '".$_POST['nome_notebook']."', 
    ip = '".$_POST['ip_notebook']."',
    modelo = '".$_POST['modelo_notebook']."', 
    processador = '".$_POST['processador_notebook']."', 
    hd = '".$_POST['hd_note']."', 
    memoria = '".$_POST['memoria_note']."', 
    situacao = '".$_POST['situacao_note']."', 
    serialnumber = '".$_POST['serie_notebook']."'
    WHERE
    id_equipamento = ".$_POST['id_equipamento']."";

    $result_equip_note = $conn -> query($update_equip_note);

    //windows
    $update_cpu_so = "UPDATE manager_sistema_operacional
    SET
    versao = '".$_POST['so_notebook']."', 
    serial = '".$_POST['serial_so_note']."',
    fornecedor = '".$_POST['fornecedor_so_note']."',
    locacao = '".$_POST['locacao_notebook']."'
    WHERE
    id_equipamento = ".$_POST['id_equipamento']."";

    $result_cpu_so = $conn -> query($update_cpu_so);

    //office
    if($_POST['id_office'] != NULL){
        $update_cpu_office = "UPDATE manager_office
        SET
        versao = '".$_POST['office_note']."', 
        serial = '".$_POST['serial_office_note']."', 
        fornecedor = '".$_POST['fornecedor_office_note']."',
        locacao = '".$_POST['local_note_office']."', 
        empresa = '".$_POST['empresa_note_office']."'
        WHERE
        id_equipamento = ".$_POST['id_equipamento']."";
        $result_cpu_office = $conn -> query($update_cpu_office);
    }//end IF OFFICE NOTEBOOK
}
    
if($_POST['tipo_equipamento'] == 5){//ramal
    $update_equip_ramal = "UPDATE manager_inventario_equipamento
    SET
    modelo = '".$_POST['modelo_ramal']."',
    numero = '".$_POST['numero_ramal']."', 
    filial = '".$_POST['empresa_ramal']."', 
    locacao = '".$_POST['local_ramal']."', 
    ipdi = '".$_POST['ipdi_ramal']."'
    WHERE
    id_equipamento = '".$_POST['id_equipamento']."'; ";
    
    $result_equip_ramal = $conn -> query($update_equip_ramal);
}

/*-----------------------------------------------------------------------------------------*/
//fechando a coneção com o banco de dados
$conn -> close();

/*-----------------------------------------------------------------------------------------*/
//3º Voltando para a tela de edição
header('location: equip_edit.php?id_equip='.$_POST['id_equipamento'].'&id_fun='.$_POST['id_funcionario'].'&tipo='.$_POST['tipo_equipamento'].'');

?>