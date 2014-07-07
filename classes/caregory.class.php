<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
class caregory {
    
            
    
    function add($name,$point,$obj){
        
        $pontos = new point();
        
        $id_ponto =  $pontos->add($point, $obj);
        
        
        $sql_insere = "insert into category(name,point_id)
                 values ('".$name. "', '". $id_ponto. "')";
        $obj->executeSql($sql_insere);
        
        echo $sql_insere;
          
         
    }
    function list_user($obj){
        
        $sql_users = "select * from users";
        return $obj->executeSql($sql_users);
    }
}
