



<form method="post" action="http://jefersonsilva.in/projetos/tcc/cria_user.php">
    <input type="hidden" value="1" name="user"/>
    <ul style="list-style-type:none">
        <li>nome<br>
            <input type="text" name="nome"/>
        </li>
        <li>email<br>
            <input type="email" name="username" />
        </li>
        <li>senha<br>
            <input type="password" name="password"/>
        </li>
        <li><br>
            <input type="submit" value="criar usuario" />
        </li>
    </ul>
    
</form>


<?php

 
if($_REQUEST['user'] == 1){
    include 'autoload.php';
    $obj = new database();
    $user = new user();
    try{
        $user->add(trim($_REQUEST['nome']), trim($_REQUEST['username']), sha1(trim($_REQUEST['password'])), $obj);
        echo "usuário criado com sucesso <a href='http://jefersonsilva.in/projetos/tcc/'>voltar</a>";
    }  catch (Exception $e){
        echo "tivemos problemas";
    }
}

