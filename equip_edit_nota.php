<?php
//chamando o banco de dados

include 'conexao.php';

if($_POST['programa'] == 1){//Windows

    //salvando a nota
    //pegando o arquivo e salvando no servidor
    //salvando a nota do windows
    $tipo_file = $_FILES['file_nota']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file_nota']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota']['name'];//caminho onde será salvo o FILE
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

    //salvando agora o office no banco
    $edit_win = "UPDATE manager_sistema_operacional SET file_nota = '".$caminho_db."', file_nota_nome = '".$nome_db."', data_nota = '".$_POST['data_nota']."' WHERE id = ".$_POST['id_win']." ";
    $result_edit_win = mysqli_query($conn, $edit_win) or die(mysqli_error($conn));
   
    header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');
}//end IF windows


/*------------------------------------------------------------------------------------------------------------*/


if($_POST['programa'] == 2){//Office

    //salvando a nota
    //pegando o arquivo e salvando no servidor
    //salvando a nota do windows
    $tipo_file = $_FILES['file_nota']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file_nota']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota']['name'];//caminho onde será salvo o FILE
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

    //salvando agora o office no banco
    $edit_off = "UPDATE manager_office SET file_nota = '".$caminho_db."', file_nota_nome = '".$nome_db."', data_nota = '".$_POST['data_nota']."' WHERE id = ".$_POST['id_win']." ";
    $result_edit_off = mysqli_query($conn, $edit_off) or die(mysqli_error($conn));
    
    header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');
}//end IF windows


/*------------------------------------------------------------------------------------------------------------*/

if($_POST['programa'] == 3){//Termo

    //salvando a nota
    //pegando o arquivo e salvando no servidor
    //salvando a nota do windows
    $tipo_file = $_FILES['file_nota']['type'];//Pegando qual é a extensão do arquivo
    $nome_db = $_FILES['file_nota']['name'];
    $caminho = "/var/www/html/ti/documentos/tecnicos/" . $_FILES['file_nota']['name'];//caminho onde será salvo o FILE
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

    //salvando agora o termo no banco
    $edit_termo = "UPDATE manager_inventario_anexo SET caminho = '".$caminho_db."', nome = '".$nome_db."', data_criacao = '".$_POST['data_nota']."' WHERE id_anexo = ".$_POST['id_win']." ";
    $result_edit_termo = mysqli_query($conn, $edit_termo) or die(mysqli_error($conn));

    header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&msn=1');
}//end IF windows


/*------------------------------------------------------------------------------------------------------------*/
//fechando o banco de dados
mysqli_close($conn);
?>