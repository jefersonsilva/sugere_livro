<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
class user{
    
    function add($name,$username,$pwd, $obj ){
        $sql_insere = "insert into users(name,username, password)
                 values ('".$name. "', '". $username. "', '".$pwd."')";
        $obj->executeSql($sql_insere);
        
        //echo $sql_insere;
    }
    function list_user($obj){
        
        $sql_users = "select * from users";
        return $obj->executeSql($sql_users);
    }
}
