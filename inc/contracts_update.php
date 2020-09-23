<?php 
//chamando o banco de dados
require 'conexao.php'; 
//salvando variavel para setar na header
$id = $_POST['id_contrato'];

//montando o update para o pai
if ($_POST['cnpj_master'] != NULL) {
	$update = "UPDATE manager_contracts SET cnpj='".$_POST['cnpj_master']."', name='".$_POST['nome']."', number='".$_POST['numero_contrato']."', type='".$_POST['t_contrato']."', type_collection='".$_POST['t_cobranca']."', cnpj_branch='".$_POST['cnpj_forne']."', department='".$_POST['setor']."', date_start='".$_POST['data_contrato']."', contracts_responsible='".$_POST['responsavel']."', mail_responsible='".$_POST['email_v']."', description='".$_POST['desc_resumo']."' WHERE id='".$_POST['id_contrato']."'";
$resultado_update = mysqli_query($conn, $update) or die(mysqli_error($conn));
}
//montando a exclusão do pai

if ($_POST['id_contrato_father'] != NULL) {
  $update_father = "UPDATE manager_contracts SET deleted = 1 WHERE id = ".$_POST['id_contrato_father']."";
  $resultado_father = mysqli_query($conn, $update_father) or die(mysqli_error($conn));
  header('location: contracts.php');
  exit;
}

//montando o update para o filho
if ($_POST['number_son'] != NULL) {
$update_son = "UPDATE manager_contracts_son SET number_contract='".$_POST['number_son']."', cnpj='".$_POST['cnpj_son']."', value='".$_POST['value_son']."', data_due='".$_POST['data_son']."', temp_lack ='".$_POST['temp_son']."' WHERE id_son='".$_POST['id_son']."'";
$resultado_update_sun = mysqli_query($conn, $update_son) or die(mysqli_error($conn));
}

//Montando exclusão do filho
if ($_POST['id_son_deleted'] != NULL) {
  $update_deleted_son = "UPDATE manager_contracts_son SET deleted = 1 WHERE id_son = ".$_POST['id_son_deleted']."";
  $resultado_deleted_son = mysqli_query($conn, $update_deleted_son) or die(mysqli_error($conn));
}

//Montando o Isert para o filho
if ($_POST['number_new_son'] != NULL) {
  if ($_FILES['file_new_son'] != NULL) {
     //Pegando qual é a extensão do arquivo
      $tipo_file_son = $_FILES['file_new_son']['type'];
      $caminho_file_son = "/var/www/html/ti/documentos/";//caminho para onde vai o arquivo
      $caminho_db_son = "documentos/".$_FILES['file_new_son']['name'];// esse caminho será usado para salvar no banco de dados
      
       //montando a query de validação
       $sql_file = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file_son."'";
       //aplicando a query
       $result =  mysqli_query($conn, $sql_file);
       $row_file_son = mysqli_fetch_array($result);

       //aplicando a regra e salvando no servidor
       if ($row_file_son['type'] != NULL) {
           /* Insira aqui a pasta que deseja salvar o arquivo*/
           $uploaddir = $caminho_file_son;
           $uploadfile = $uploaddir . $_FILES['file_new_son']['name'];//juntado o caminha mais arquivo           

               //aplicando o salvamento
               if (move_uploaded_file($_FILES['file_new_son']['tmp_name'], $uploadfile)){
                //echo "Arquivo Enviado";
                }else {echo "Arquivo não enviado";}
        }else{
          header("Location: error.html");
           exit;
       }

       /*DEPOIS QUE SALVOU NO SERVIDOR VAMOS AGORA SALVAR NO BANCO DE DADOS*/
       /*1º*/
       //Salvar no banco de dados manager_contracts_file 
       //Primeiro vamos pegar o ultimo ID
       $query_max = "SELECT max(id_son) AS id_filho FROM manager_contracts_son";
       $resultado_max = mysqli_query($conn, $query_max);
       $row_max_filho = mysqli_fetch_assoc($resultado_max);
       $contracts_son = $row_max_filho['id_filho'];


       //criando a query
        $insert_bd_file = "INSERT INTO manager_contracts_file(name, number_contract, cnpj ,contracts_father, contracts_son, type, file_way) 
    VALUES ('".$_FILES['file_new_son']['name']."','".$_POST['number_new_son']."','".$_POST['new_cnpj_son']."', '".$id."','".$contracts_son++."','".$_FILES['file_new_son']['type']."','".$caminho_db_son."')";
       //aplicando a query
      $resultado_insert_file = mysqli_query($conn, $insert_bd_file) or die(mysqli_error($conn));

  } 
  /*2º*/
  //Salvar no banco de dados manager_contracts_son
  $insert_bd_son = "INSERT INTO manager_contracts_son(number_contract, cnpj, value,data_due,temp_lack,son_file,contracts_father) VALUES ('".$_POST['number_new_son']."', '".$_POST['new_cnpj_son']."', '".$_POST['value_new']."', '".$_POST['date_new']."', '".$_POST['temp_new']."', '".$contracts_son++."', '".$id."')";

  $resultado_insert_son = mysqli_query($conn, $insert_bd_son) or die(mysqli_error($conn));
}

//Montando exclusão do file
if ($_POST['id_file_deleted'] != NULL) {
  $update_deleted_file = "UPDATE manager_contracts_file SET deleted = 1 WHERE id_file = ".$_POST['id_file_deleted']."";
  $resultado_deleted_file = mysqli_query($conn, $update_deleted_file) or die(mysqli_error($conn));
}

//Montando adicionando um novo documento


if ($_FILES['file_new'] != NULL) {

  //Pegando qual é a extensão do arquivo
  $tipo_file_new = $_FILES['file_new']['type'];
  $caminho_new = "/var/www/html/ti/documentos/";//caminho para onde vai o arquivo
  $caminho_db_new = "documentos/".$_FILES['file_new']['name'];// esse caminho será usado para salvar no banco de dados
  
   //montando a query de validação
   $sql_file_new = "SELECT type FROM manager_file_type WHERE type LIKE '".$tipo_file_new."'";
   //aplicando a query
   $result_new =  mysqli_query($conn, $sql_file_new);
   $row_new = mysqli_fetch_array($result_new);

   //aplicando a regra e salvando no servidor

   if ($row_new['type'] != NULL) {
       /* Insira aqui a pasta que deseja salvar o arquivo*/
       $uploaddir = $caminho_new; 
       $uploadfile = $uploaddir . $_FILES['file_new']['name'];//juntado o caminha mais arquivo
     //aplicando o salvamento
     if (move_uploaded_file($_FILES['file_new']['tmp_name'], $uploadfile)){
      //echo "Arquivo Enviado";
      }else {echo "Arquivo não enviado";}
    }else{
       //echo $tipo_file;
       header("Location: error.html");
       exit;
   }
   /*DEPOIS QUE SALVOU NO SERVIDOR VAMOS AGORA SALVAR NO BANCO DE DADOS*/
   /*1º*/
   //Salvar no banco de dados manager_contracts_file 
   //criando a query

   if ($_POST['contrato_filho_new'] == '') {//se o arquivo for do pai

    $query_pai = "SELECT id, cnpj, number FROM manager_contracts WHERE id = ".$_POST['id_contrato']."";
    $resultado_pai = mysqli_query($conn, $query_pai);
    $row_pai = mysqli_fetch_assoc($resultado_pai);

    $insert_bd_file = "INSERT INTO manager_contracts_file(name, number_contract, cnpj ,contracts_father, contracts_son, type, file_way) 
VALUES ('".$_FILES['file_new']['name']."','".$row_pai['number']."','".$row_pai['cnpj']."', '".$row_pai['id']."','0','".$_FILES['file_new']['type']."','".$caminho_db_new."')";
   //aplicando a query
  $resultado_insert_file = mysqli_query($conn, $insert_bd_file) or die(mysqli_error($conn));
   }else{// se não é do filho

    $query_filho = "SELECT id_son, cnpj FROM manager_contracts_son WHERE number_contract = '".$_POST['contrato_filho_new']."'";
    $resultado_filho = mysqli_query($conn, $query_filho);
    $row_filho = mysqli_fetch_assoc($resultado_filho);
    $insert_bd_file = "INSERT INTO manager_contracts_file(name, number_contract, cnpj ,contracts_father, contracts_son, type, file_way) 
VALUES ('".$_FILES['file_new']['name']."','".$_POST['contrato_filho_new']."','".$row_filho['cnpj']."', '".$id."','".$row_filho['id_son']."','".$_FILES['file_new']['type']."','".$caminho_db_new."')";
   //aplicando a query
  $resultado_insert_file = mysqli_query($conn, $insert_bd_file) or die(mysqli_error($conn));
  }
}


mysqli_close($conn);
//Depois que fez as alterações volta para o contrato pai
header("location: contracts_edit.php?id=$id");
?>