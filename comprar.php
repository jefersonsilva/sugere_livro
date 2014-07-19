<?php

include 'autoload.php';
$user_id =  $_POST['user_id'];
$produto_id =  $_POST['produto_id'];

$obj = new database();
$venda = new sale();
$produto = new product();



try{
    $venda->add($user_id, $produto_id, $obj);
    echo "compra realizada com sucesso, compre mais "
    . "<a href='http://jefersonsilva.in/projetos/tcc/cria_compra.php' > "
            . "aqui "
    . "</a>";
}  catch (Exception $e){
    echo "houve problemas";
}

