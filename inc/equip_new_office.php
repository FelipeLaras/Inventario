<?php
    //chamando manager
    require_once('../conexao/conexao.php');
    //chamando ocsweb
    require_once('../conexao/conexao_ocs.php');
    /*---------------------------------------------------------------------*/



    

    //1º vamos salvar no OCS
    //pegando o patrimonio
    $buscar_patrimonio = "SELECT patrimonio FROM manager_inventario_equipamento WHERE id_equipamento = ".$_POST['id_equip']."";
    $result_patrimonio = $conn->query($buscar_patrimonio);
    $patrimonio = $result_patrimonio->fetch_assoc();

    //pegando o hardware_id
    $buscando_harwareID = "SELECT HARDWARE_ID FROM accountinfo WHERE TAG = '".$patrimonio['patrimonio']."'";
    $result_harwareID= $conn_ocs->query($buscando_harwareID);
    $harwareID = $result_harwareID->fetch_assoc();

    //pegando o nome office
    $office = "SELECT nome FROM manager_dropoffice where id = ".$_POST['tipo_office']."";
    $result_office= $conn->query($office);
    $office_row = $result_office->fetch_assoc();

    //juntando todos os ingredientes acimas e fazendo o bolo!!
    $inserindo_ocs = "INSERT INTO ocsweb.officepack 
        (HARDWARE_ID, PRODUCT, OFFICEKEY, INSTALL)
        VALUES
        ('".$harwareID['HARDWARE_ID']."', '".$office_row['nome']."', '".$_POST['serial_office']."',0)";

    $resultado_ocs = $conn_ocs->query($inserindo_ocs) or die(mysqli_error($conn_ocs));

    /*---------------------------------------------------------------------*/
    //2º agora vamos salvar no MANAGER


    //pegando o arquivo e salvando no servidor
    //salvando a nota do windows
    $tipo_file = $_FILES['file_nota']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file_nota']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/".$_FILES['file_nota']['name'];//caminho onde será salvo o FILE
    $caminho_db = "../documentos/tecnicos/".$_FILES['file_nota']['name'];//pasta onde está o FILE para salvar no Bando de dados

    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

    $result =  $conn->query($sql_file);//aplicando a query
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
    $result_new_office = $conn->query($new_office) or die(mysqli_error($conn));

/*---------------------------------------------------------------------*/
//fechando o banco manager
$conn->close();
//fechando o banco OCS
$conn_ocs->close();
//Voltando para a tela
header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&tipo='.$_POST['tipo_equipamento'].'&msn=2');
?>