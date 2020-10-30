<?php
require_once('../conexao/conexao.php');

//editando office
$updateOffice = "UPDATE 
                    manager_office SET versao = '".$_POST['versao']."', 
                    serial = '".$_POST['serial']."', 
                    locacao = '".$_POST['locacao']."', 
                    empresa = '".$_POST['empresa']."', 
                    fornecedor = '".$_POST['fornecedor']."' WHERE id = '".$_POST['id']."'";

if(!$conn -> query($updateOffice)){
    printf("Opa houve alguma coisa de errado, Print essa tela e contate o administrador: %s\n", $conn->erro);
}

header('location: office_edit_disponivel.php?id=1&msn=2');

$conn->close();
?>