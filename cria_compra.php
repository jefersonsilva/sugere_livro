<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'autoload.php';
$usuario = new user();
$db = new database();

$lista_de_usuarios = $usuario->list_user($db);

?>
<h2> Escolha o usuário </h2>
<form action="perfil.php" method="post" name="choose-user">
   
    <select name="user_id">
<?php
foreach($lista_de_usuarios as $usuario){
    
    echo "<option value='". $usuario['id']. "' > ".$usuario['name']."</option>";
}



?>
    
   </select> 
    <input type="submit" />
</form>

        
        
        

