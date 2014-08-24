<?php

include 'autoload.php';
    $obj = new database();
    $category = new caregory();
    $product = new product();
    
    $lista_de_categorias = $category->list_categories($obj);

?>
<form method="post" action="http://jefersonsilva.in/projetos/tcc/cria_produto.php">
    <input type="hidden" value="1" name="produto"/>
    <ul style="list-style-type:none">
        <li>nome<br>
            <input type="text" name="nome"/>
        </li>
        
        
        <select name="category_id">
            <?php
            foreach($lista_de_categorias as $categoria){

                echo "<option value='". $categoria['id']. "' > ".$categoria['name']."</option>";
            }

            ?>

         </select>
        
        <li><br>
            <input type="submit" value="criar produto" />
        </li>
    </ul>
    
</form>


<?php

 
if($_REQUEST['produto'] == 1){
    
    try{
        $product->add(trim($_REQUEST['nome']), $_REQUEST['category_id'], $obj);
        
        echo "Produto criado com sucesso <a href='http://jefersonsilva.in/projetos/tcc/'>voltar</a>";
    }  catch (Exception $e){
        echo "tivemos problemas";
    }
}

