<?php include 'index.php'; ?>


<br>


<table border="1">
    <th>Produto</th>
    <th>Categoria</th>
<?php
include 'autoload.php';

$product = new product();
$obj = new database();

try{
$produtos = $product->list_product($obj);
}  catch (Exception $e){
    echo $e->getMessage();
}
foreach ($produtos as $produto):
?>

    <tr>
        <td>
            <?php echo $produto['produto'] ?>
        </td>
        <td>
            <?php echo $produto['categoria'] ?>
        </td>
    </tr>



<?php endforeach; ?>

</table>

