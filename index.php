<?php
include_once 'autoload.php';

$db = new database();
$usuario = new user();
$categoria = new caregory();
$produto = new product();
$sale = new sale();

//$usuario->add('jef', 'jeferson@eu.com', '123456', $db);

#


//$categoria->add();

?>


<html>
    
    <head>
        <title>Sugestao de escolhas</title> 
        <link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset-fonts-grids/reset-fonts-grids.css">
        <meta charset="UTF-8"/>
    <style type="text/css">
			a{
				text-decoration: none;
			}
			
			body > ul{
				font-family: 'Dosis', sans-serif;
				font-size: 18px;
			}
			
			body > ul > li{
				float: left;
				position: relative;
				margin-left: 5px;
			}
			
			body > ul > li:first-child{
				margin-left: 0;
			}
			
			body > ul > li > a{
				color:#fff;
				padding: 5px 10px;
				background: #999999;
				-webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
			}
			
			body > ul > li > ul{
				padding: 4px 7px;
				visibility: hidden;
				position: absolute;
				left: 0;
				top: 23px;
				-webkit-transition: all 0.7s ease;
				-moz-transition: all 0.7s ease;
				-o-transition: all 0.7s ease;
				-moz-opacity: 0.00;
				opacity: 0.00;
				-ms-filter: "progid:DXImageTransform.Microsoft.Alpha"(Opacity=0);
			}
			
			body > ul > li:hover > ul{
				-moz-opacity: 1;
				opacity: 1;
				-ms-filter:"progid:DXImageTransform.Microsoft.Alpha"(Opacity=100);
				visibility: visible;
				text-align: left;
				background: #999999;
				-webkit-border-radius: 0 0 5px 5px;
				-moz-border-radius: 0 0 5px 5px;
				border-radius: 0 0 5px 5px;
				padding: 4px 7px;
			}
			
			body > ul > li > ul > li{
				display: block;
				font-size: 12px;
				margin-bottom: 5px;
			}
			
			body > ul > li > ul > li > a{
				color: #fff;
			}
		</style>
    </head>
    <meta charset="UTF-8"/>
    <body>
        
        
            <ul>
                <li>Usuários
                <ul>
                    <li>
                        <a href="./cria_user.php" > Criar </a>
                    </li>
                    <li>
                        <a href="./lista_user.php" > Listar </a>
                    </li>
                    
                </ul>
                </li>
                <li>Compra
                <ul>
                    <li>
                        <a href="./cria_compra.php" > Criar </a>
                    </li>
                    <li>
                        <a href="./lista_compra.php" > Listar </a>
                    </li>
                    
                </ul>
                </li>
                <li>Categoria
                <ul>
                    <li>
                        <a href="./cria_categoria.php" > Criar </a>
                    </li>
                    <li>
                        <a href="./lista_categoria.php" > Listar </a>
                    </li>
                    
                </ul>
                </li>
                <li>Produto
                <ul>
                    <li>
                        <a href="./cria_produto.php" > Criar </a>
                    </li>
                    <li>
                        <a href="./lista_produto.php" > Listar </a>
                    </li>
                    
                </ul>
                </li>
            </ul>
        
        
        
    </body>
</html>

