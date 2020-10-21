<?php
 //aplicando para usar varialve em outro arquivo
 session_start();
 unset($_SESSION['id_funcionario']);//LIMPANDO A SESSION
 
 //Aplicando a regra de login
 if($_SESSION["perfil"] == NULL){  
   header('location: ../front/index.html');
 
 }elseif ($_SESSION["perfil"] == 2) {
 
     header('location: ../front/error.php');
 }

header('location: manager.php');
?>