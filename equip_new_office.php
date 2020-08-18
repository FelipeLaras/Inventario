<?php
    //chamando manager
    require 'conexao.php';
    /*---------------------------------------------------------------------*/
    //chamando ocsweb
    require 'conexao_ocs.php';
    /*---------------------------------------------------------------------*/

    //1º vamos salvar no OCS
    //pegando o patrimonio
    $buscar_patrimonio = "SELECT patrimonio FROM manager_inventario_equipamento WHERE id_equipamento = ".$_POST['id_equip'].";";
    $result_patrimonio = mysqli_query($conn, $buscar_patrimonio);
    $patrimonio = mysqli_fetch_assoc($result_patrimonio);

    //pegando o hardware_id
    $buscando_harwareID = "SELECT HARDWARE_ID FROM accountinfo WHERE TAG = '".$patrimonio['patrimonio']."'";
    $result_harwareID= mysqli_query($conn_ocs, $buscando_harwareID);
    $harwareID = mysqli_fetch_assoc($result_harwareID);

    //pegando o nome office
    $office = "SELECT nome FROM manager_dropoffice where id = ".$_POST['tipo_office']."";
    $result_office= mysqli_query($conn, $office);
    $office_row = mysqli_fetch_assoc($result_office);

    //juntando todos os ingredientes acimas e fazendo o bolo!!
    $inserindo_ocs = "INSERT INTO ocsweb.officepack 
        (HARDWARE_ID, PRODUCT, OFFICEKEY, INSTALL)
        VALUES
        ('".$harwareID['HARDWARE_ID']."', '".$office_row['nome']."', '".$_POST['serial_office']."',0)";

    $resultado_ocs = mysqli_query($conn_ocs, $inserindo_ocs) or die(mysqli_error($conn_ocs));

    /*---------------------------------------------------------------------*/
    //2º agora vamos salvar no MANAGER


    //pegando o arquivo e salvando no servidor
    //salvando a nota do windows
    $tipo_file = $_FILES['file_nota']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file_nota']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/".$_FILES['file_nota']['name'];//caminho onde será salvo o FILE
    $caminho_db = "documentos/tecnicos/".$_FILES['file_nota']['name'];//pasta onde está o FILE para salvar no Bando de dados

    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

    $result =  mysqli_query($conn, $sql_file);//aplicando a query
    $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

    if($tipo_file != NULL){
            /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['file_nota']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['file_nota']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }
    }
   
     /*CASO NÃO INFORME UMA DATA PARA A NOTA FISCAL*/
    if($_POST['data_nota'] != NULL){
        $data_nota = $_POST['data_nota'];
    }else{
        $data_nota = 'not date';
    }  
    
    //salvando agora o office no banco
    $new_office = "INSERT INTO manager_office
            (id_equipamento, locacao, empresa, versao, serial, fornecedor, numero_nota, file_nota, file_nota_nome, data_nota)
            VALUES
            ('".$_POST['id_equip']."', 
            '".$_POST['local_office']."',
            '".$_POST['empresa_office']."',
            '".$_POST['tipo_office']."',
            '".$_POST['serial_office']."',
            '".$_POST['fornecedor_office']."',
            '".$_POST['num_nota']."',
            '".$caminho_db."',
            '".$nome_db."',
            '".$data_nota."')";
    $result_new_office = mysqli_query($conn, $new_office) or die(mysqli_error($conn));

/*---------------------------------------------------------------------*/
//fechando o banco manager
mysqli_close($conn);
//fechando o banco OCS
mysqli_close($conn_ocs);
//Voltando para a tela
header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&tipo='.$_POST['tipo_equipamento'].'&msn=2');
?>