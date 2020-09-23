<?php
session_start();

//chamando o banco de dados
require 'conexao.php';
/*---------------------------------------------------------------------------------*/

//trocando data
$data = $_POST['data'];

//1º incluindo uma nota WINDOWS

if($_POST['tipo'] == 1){
    
   //salvando a nota do windows
   $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
   $nome_db = $_FILES['termo']['name'];
   $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
   $caminho_db = "documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados

   /*VALIDAÇÃO DO FILE*/
   $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

   $result =  mysqli_query($conn, $sql_file);//aplicando a query
   $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel

   if($tipo_file != NULL){
           /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
       if ($row['type'] != NULL) {//se é arquivo valido       
           if (move_uploaded_file($_FILES['termo']['tmp_name'], $caminho )){//aplicando o salvamento
               //echo "Arquivo enviado para = ".$_FILES['termo']['tmp_name'].$uploadfile;
           }else{
           echo "Arquivo não foi enviado!";
           }//se caso não salvar vai mostrar o erro!
       }else{// se o arquivo não é valido vai levar para tela de erro    
           echo "Arquivo Invalido!";
           exit;
       }
   }//end IF validação arquivo
     
   //salvando agora o WINDOWS no banco
   $update_windows = "UPDATE manager_sistema_operacional 
   SET 
       numero_nota = '".$_POST['numero_nota']."', 
       file_nota = '".$caminho_db."',
       file_nota_nome = '".$nome_db."',
       data_nota = '".$data."',
       deletar = 0
   WHERE
       id_equipamento = '".$_POST['id_equip']."';";
   $result_update_windows = mysqli_query($conn, $update_windows) or die(mysqli_error($conn));
}//end teminando de salvar o WINDOWS


/*---------------------------------------------------------------------------------*/


//2º incluindo uma nota OFFICE

if($_POST['tipo'] == 2){
    
    //salvando a nota do OFFICE
    $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['termo']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
    $caminho_db = "documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados
 
    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
 
    $result =  mysqli_query($conn, $sql_file);//aplicando a query
    $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
 
    if($tipo_file != NULL){
            /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['termo']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['termo']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }
    }//end IF validação arquivo
      
    //salvando agora o OFFICE no banco
    $update_office = "UPDATE manager_office 
    SET 
        numero_nota = '".$_POST['numero_nota']."',
        file_nota = '".$caminho_db."',
        file_nota_nome = '".$nome_db."',
        data_nota = '".$data."',
        deletar = 0
    WHERE
        id_equipamento = '".$_POST['id_equip']."';";
    $result_update_office = mysqli_query($conn, $update_office) or die(mysqli_error($conn));
 
 }//end teminando de salvar o OFFICE


/*---------------------------------------------------------------------------------*/


//3º incluindo um TERMO DE RESPONSABILIDADE

if($_POST['tipo'] == 3){
    
    //salvando a nota do TERMO
    $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['termo']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
    $caminho_db = "documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados
 
    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
 
    $result =  mysqli_query($conn, $sql_file);//aplicando a query
    $row = mysqli_fetch_array($result);//salvando o resultado em uma variavel
 
    if($tipo_file != NULL){
            /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
        if ($row['type'] != NULL) {//se é arquivo valido       
            if (move_uploaded_file($_FILES['termo']['tmp_name'], $caminho )){//aplicando o salvamento
                //echo "Arquivo enviado para = ".$_FILES['termo']['tmp_name'].$uploadfile;
            }else{
            echo "Arquivo não foi enviado!";
            }//se caso não salvar vai mostrar o erro!
        }else{// se o arquivo não é valido vai levar para tela de erro    
            echo "Arquivo Invalido!";
            exit;
        }
    }//end IF validação arquivo
      
    //salvando agora o TERMO no banco
    $update_termo = "INSERT INTO manager_inventario_anexo 
                        (id_equipamento,
                        id_funcionario,
                        usuario, 
                        caminho, 
                        nome, 
                        tipo, 
                        data_criacao) 
                    VALUES 
                        ('".$_POST['id_equip']."', 
                        '".$_POST['id_fun']."', 
                        '".$_SESSION['id']."', 
                        '".$caminho_db."', 
                        '".$nome_db."', 
                        '3', 
                        '".$data."')";

    $result_termo = mysqli_query($conn, $update_termo) or die(mysqli_error($conn));

    //Alterar o status do equipamento + funcionario
    $incluir_termo = "UPDATE manager_inventario_equipamento SET termo = 0 WHERE id_equipamento = ".$_POST['id_equip']."";
    $result_termo = mysqli_query($conn, $incluir_termo) or die(mysqli_error($conn));

    //alterando funcionario
    $status_funcionario = "UPDATE manager_inventario_funcionario SET status = 4 where id_funcionario = ".$_POST['id_fun']."";
    $result_funcionario = mysqli_query($conn, $status_funcionario) or die(mysqli_error($conn));

 }//end teminando de salvar o TERMO

 /*---------------------------------------------------------------------------------*/

 
 header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');

 //fechando conexão com o banco de dados
 mysqli_close($conn);