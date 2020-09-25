
<?php 
session_start();
//chamando o banco de dados
require_once('../conexao/pesquisa_condb.php');

//fechando a conexão com o banco
$conn_db->close();

header('location: search.php');

?>