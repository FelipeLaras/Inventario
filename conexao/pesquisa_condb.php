<?php
  //variaveis para conexao
  $servername = "10.100.1.65";
  $username = "pesquisa";
  $password = "Pesquisa2020#";
  $dbname = "pesquisa";
  $port = "3306";

  //conexao
  $conn_db = mysqli_connect($servername, $username, $password, $dbname, $port);

  //validando
  if (!$conn_db) {
    echo "Errorrrr: não foi possível conectar-se ao MySQL." . PHP_EOL . "<br />";
    echo "Depurando erro no: " . mysqli_connect_errno() . PHP_EOL . "<br />";
    echo "Depurando erro: " . mysqli_connect_error() . PHP_EOL;
    exit;
  }else{
   /*  echo "Sucesso: Foi feita uma conexão adequada ao MySQL!<br />" . PHP_EOL;
    echo "Informações do Host: " . mysqli_get_host_info($conn_db) . PHP_EOL; */
  }      
?>