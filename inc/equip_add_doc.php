<?php
session_start();

//chamando o banco de dados
require_once('../conexao/conexao.php');
/*---------------------------------------------------------------------------------*/

//trocando data
$data = date('d/m/yy');

//1º incluindo uma nota WINDOWS

if($_POST['tipo'] == 1){
    
   //salvando a nota do windows
   $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
   $nome_db = $_FILES['termo']['name'];
   $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
   $caminho_db = "../documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados

   /*VALIDAÇÃO DO FILE*/
   $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 

   $result =  $conn -> query($sql_file);//aplicando a query
   $row = $result -> fetch_array();//salvando o resultado em uma variavel

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
       id_equipamento = '".$_POST['id_equip']."'";
   $result_update_windows = $conn -> query($update_windows);
}//end teminando de salvar o WINDOWS


/*---------------------------------------------------------------------------------*/


//2º incluindo uma nota OFFICE

if($_POST['tipo'] == 2){
    
    //salvando a nota do OFFICE
    $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['termo']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
    $caminho_db = "../documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados
 
    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
 
    $result =  $conn -> query($sql_file);//aplicando a query
    $row = $result -> fetch_array();//salvando o resultado em uma variavel
 
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
    $result_update_office = $conn -> query($update_office);
 
 }//end teminando de salvar o OFFICE


/*---------------------------------------------------------------------------------*/


//3º incluindo um TERMO DE RESPONSABILIDADE

if($_POST['tipo'] == 3){
    
    //salvando a nota do TERMO
    $tipo_file = $_FILES['termo']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['termo']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['termo']['name'];//caminho onde será salvo o FILE
    $caminho_db = "../documentos/tecnicos/".$_FILES['termo']['name'];//pasta onde está o FILE para salvar no Bando de dados
 
    /*VALIDAÇÃO DO FILE*/
    $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
 
    $result =  $conn -> query($sql_file);//aplicando a query
    $row = $result -> fetch_array();//salvando o resultado em uma variavel
 
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

    $result_termo = $conn -> query($update_termo);

    //Alterar o status do equipamento + funcionario
    $incluir_termo = "UPDATE manager_inventario_equipamento SET termo = 0 WHERE id_equipamento = ".$_POST['id_equip']."";
    $result_termo = $conn -> query($incluir_termo);

    //alterando funcionario
    $status_funcionario = "UPDATE manager_inventario_funcionario SET status = 4 where id_funcionario = ".$_POST['id_fun']."";
    $result_funcionario = $conn -> query($status_funcionario);

 }//end teminando de salvar o TERMO


 if($_POST['tipo'] == 10){//scanner
     //salvando a nota do TERMO
     $tipo_file = $_FILES['notaFiscal']['type'];//Pegando qual é a extensão do arquivo
     $nome_db = $_FILES['notaFiscal']['name'];
     $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['notaFiscal']['name'];//caminho onde será salvo o FILE
     $caminho_db = "../documentos/tecnicos/".$_FILES['notaFiscal']['name'];//pasta onde está o FILE para salvar no Bando de dados
  
     /*VALIDAÇÃO DO FILE*/
     $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file."'";//query de validação 
  
     $result =  $conn -> query($sql_file);//aplicando a query
     $row = $result -> fetch_array();//salvando o resultado em uma variavel
  
     if($tipo_file != NULL){
             /*TRABALHAMDO COM O RESULTADO DA VALIDAÇÃO*/
         if ($row['type'] != NULL) {//se é arquivo valido       
             if (move_uploaded_file($_FILES['notaFiscal']['tmp_name'], $caminho )){//aplicando o salvamento
             }else{
             echo "Arquivo não foi enviado!";
             }//se caso não salvar vai mostrar o erro!
         }else{// se o arquivo não é valido vai levar para tela de erro    
             echo "Arquivo Invalido!";
             exit;
         }
     }//end IF validação arquivo
       
     //salvando agora A nota no banco
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
                         '4', 
                         '".$data."')";

                         echo $update_termo;
 
     $result_termo = $conn -> query($update_termo);
 
 }

 /*---------------------------------------------------------------------------------*/

/*  switch ($_POST['tipo']) {
     case '10':
         header('location: scan_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');
         break;
     
     default:
        header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');
         break;
 } */

 //fechando conexão com o banco de dados
 $conn -> close($conn);