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

$sugestao = new sugestion();

if($venda->find_user($user_id, $obj) == null){
    echo "Veja os produtos disponíveis";
    $listagem_produtos = $produto->list_product($obj)
    ?>
<pre>

</pre>
<table border="1">
    <th>Título</th>
    <th></th>
    <?php foreach($listagem_produtos as $produtos): ?>
            <tr>
                <td> <?php echo $produtos['produto'] ?></td>
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
    //$sugestao->sugest_book($user_id, $obj);
    try{
        
        
       $livros_sugeridos = $sugestao->sugest_book($user_id, $obj);
?>       
<table border="1">
    <th>Título</th>
    <th></th>
    <?php foreach($livros_sugeridos as $produtos): ?>
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
       
        
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}


