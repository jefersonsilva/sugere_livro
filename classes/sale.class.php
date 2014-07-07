<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
class sale{
    
    function add($users_id,$product_id, $obj ){
        $sql_insere = "insert into sales(users_id,products_id)
                 values ('".$users_id. "', '". $product_id. "')";
        $obj->executeSql($sql_insere);
        
        //echo $sql_insere;
    }
    function list_user($obj){
        
        $sql_users = "select * from users";
        return $obj->executeSql($sql_users);
    }
    function find_user($user_id, $obj){
        
        $sql_find = "select * from sales where users_id = ".$user_id;
        
        return $obj->executeSql($sql_find);
        
    }
}   
