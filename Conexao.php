<?php

$conexao =mysqli_connect ('localhost','root','1234');
if (!$conexao) {die('falha na conexao com o banco de dados');} 

if(mysqli_select_db ($conexao,'ShowDoMilhao') === false ){
die ("Falha ao conectar-se ao banco de dados");
}

mysqli_query($conexao,"SET NAMES 'utf8'"); 
mysqli_query($conexao,'SET character_set_connection=utf8');
mysqli_query($conexao,'SET character_set_client=utf8');
mysqli_query($conexao,'SET character_set_results=utf8');
