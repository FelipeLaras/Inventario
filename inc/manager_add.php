<?php 
session_start();
//chamando o banco
require_once('../conexao/conexao.php');

//variaveis
$nome = $_POST['name_user'];
$email = $_POST['email_user'];
$senha = $_POST['outputHash'];
$perfil = $_POST['perfil_user'];

$query_insert = "INSERT INTO manager_profile(profile_name, profile_mail, profile_password, profile_type) 
                VALUES ('".$nome."','".$email."','".$senha."','".$perfil."')";

$resultado_insert = mysqli_query($conn, $query_insert);
$row = mysqli_fetch_assoc($resultado_insert);

if ($row != NULL) {
    echo "Aconteceu algo de errado:". mysqli_error($conn);
}else{
  $conn->close();
  $_SESSION['usuario'] = $nome;
  header('location: manager_conf.php');
}
?>