<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
class product{
    
    function add($name,$cat_id, $obj ){
        $sql_insere = "insert into products(name,category_id)
                 values ('".$name. "', '". $cat_id. "')";
        
        $obj->executeSql($sql_insere);
       
    }
    function list_product($obj){
        
        $sql_users = "select * from products";
        return $obj->executeSql($sql_users);
    }
    function list_product_by_category($pontos_clientes,$obj){
        $sql_users = "select P.* "
                   . "from products P "
                   . "inner join category C on(P.category_id = C.id)"
                   . "inner join points P on(C.point_id = P.id)"
                   . "where P.ponto =".$pontos_clientes;
        return $obj->executeSql($sql_users);
    }
}
