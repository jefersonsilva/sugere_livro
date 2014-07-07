<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
class point{
    
    function add($point,$obj){
        $sql_insere = "insert into point(ponto)
                 values ('".$point. "')";
        return $obj->executeSql($sql_insere);
        
        //echo $sql_insere;
    }
    function list_point($obj){
        
        $sql_list = "select * from point";
        return $obj->executeSql($sql_list);
    }
}
