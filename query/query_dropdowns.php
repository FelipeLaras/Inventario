<?php
require_once('conexao.php');

//tipo de equipamento
$query_equip = "SELECT * FROM manager_dropequipamentos WHERE deletar = 0 ORDER BY nome ASC";
$resultado_equip = $conn -> query($query_equip);

//funcao
$query_funcao = "SELECT * FROM manager_dropfuncao WHERE deletar = 0 ORDER BY nome ASC";
$resultado_funcao = $conn -> query($query_funcao);

//departamento
$query_depart = "SELECT * FROM manager_dropdepartamento WHERE deletar = 0 ORDER BY nome ASC";
$resultado_depart = $conn -> query($query_depart);

//empresa
$query_empresa = "SELECT * FROM manager_dropempresa WHERE deletar = 0 ORDER BY nome ASC";
$resultado_empresa = $conn -> query($query_empresa);

//status
$query_statusFun = "SELECT * from manager_dropstatus WHERE deletar = 0 ORDER BY nome ASC";
$resultado_statusFun = $conn -> query($query_statusFun);

//localização
$query_locacao = "SELECT * from manager_droplocacao where deletar = 0 ORDER BY nome ASC";
$resultado_locacao = $conn -> query($query_locacao);

//situação "Alugado ou comprado"
$query_situacao = "SELECT * from manager_dropsituacao where deletar = 0 ORDER BY nome ASC";
$resultado_situacao = $conn -> query($query_situacao);

//office
$query_office = "SELECT * from manager_dropoffice where deletar = 0 ORDER BY nome ASC";
$resultado_office = $conn -> query($query_office );

//sistma operacional
$query_so = "SELECT * from manager_dropsistemaoperacional where deletar = 0 ORDER BY nome ASC";
$resultado_so = $conn -> query($query_so);

//estado "Novo ou Usado"
$query_status = "SELECT * FROM manager_dropestado WHERE deletar = 0 ORDER BY nome ASC";
$resultado_status = $conn->query($query_status);

//acessorios
$query_acessorio = "SELECT * FROM manager_dropacessorios where deletar = 0 ORDER BY nome ASC";
$resultado_acessorio = $conn->query($query_acessorio);

//operadora
$query_operadora = "SELECT * from manager_dropoperadora where deletar = 0 ORDER BY nome";
$resultado_operadora = $conn->query($query_operadora);

?>