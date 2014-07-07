<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'autoload.php';
$user_id =  $_POST['user_id'];

$obj = new database();
$venda = new sale();
$produto = new product();

if($venda->find_user($user_id, $obj) == null){
    echo "Veja os produtos disponíveis";
    $listagem_produtos = $produto->list_product($obj)
    ?>
<table>
    <th>Título</th>
    <?php
        foreach($listagem_produtos as $produtos){
            echo "<tr><td>".$produtos['name']."</td></tr>";
        }
    ?>
</table>
<?php  
}else{
    echo "veja se esses títulos te interessam";
}


