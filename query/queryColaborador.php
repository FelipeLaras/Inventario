<?php
require_once('../conexao/conexao.php');

//contador
$contador = 0;
//query para a contagem dos itens ativos, faltaTermo e demitido.
$query_f = "SELECT 
                COUNT(status) AS faltaTermo
            FROM
                manager_inventario_funcionario
            WHERE
                status = 3 AND deletar = 0";
$resultado_f = $conn -> query($query_f);

$row_f = $resultado_f -> fetch_assoc();


/*-----------------------------------------------------------------------------*/

$query_a = "SELECT 
                COUNT(status) AS ativo
            FROM
                manager_inventario_funcionario
            WHERE
                status = 4 AND deletar = 0";
$resultado_a = $conn -> query($query_a);
$row_a = $resultado_a -> fetch_assoc();

/*-----------------------------------------------------------------------------*/
         
$query_d = "SELECT 
                COUNT(status) AS demitido
            FROM
                manager_inventario_funcionario
            WHERE
                status = 8 AND deletar = 0";
$resultado_d = $conn -> query($query_d);
$row_d = $resultado_d -> fetch_assoc();


?>

