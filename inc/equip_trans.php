<?php
//chamando o banco de dados

require 'conexao.php';

/*------------------------------------------------------------------ */

//1º iremos trocar o dono do office para o novo usuário

$update_office = "UPDATE manager_office 
SET 
    id_equipamento = ".$_POST['new_office']."
WHERE
    id_equipamento = ".$_POST['id_equip']."";

$result_update = mysqli_query($conn, $update_office) or die(mysqli_error($conn));

/*------------------------------------------------------------------ */
//2º voltando para a tela de edição
header('location: equip_edit.php?id_equip='.$_POST['id_equip'].'&id_fun='.$_POST['id_fun'].'&tipo='.$_POST['tipo_equipamento'].'&msn=3');

/*------------------------------------------------------------------ */
//fechando o banco de dados
mysqli_close($conn);
?>