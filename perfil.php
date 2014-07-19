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
<pre>
<?php    var_dump($listagem_produtos); ?>
</pre>
<table border="1">
    <th>Título</th>
    <th></th>
    <?php foreach($listagem_produtos as $produtos): ?>
            <tr>
                <td> <?php echo $produtos['name'] ?></td>
                <td>
                    <form method="post" action="comprar.php">
                       
                        <input type="hidden" name="produto_id" value="<?php echo $produtos['id'] ?>" />
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                        <input type="submit" value="comprar" />
                    </form>
                </td>
            </tr>
     <?php endforeach; ?>
    
</table>
<?php  
}else{
    echo "veja se esses títulos te interessam";
}


