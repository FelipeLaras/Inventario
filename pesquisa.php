
<?php 
session_start();
//chamando o banco de dados
require 'pesquisa_condb.php';
//query de pesquisa dentro do banco


//fechando a conexão com o banco
mysqli_close($conn_db);

header('location: search.php');



?>