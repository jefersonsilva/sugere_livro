<?php

class sugestion{
    
    
    function  get_point_user($user_id, $obj){
        
        $sql_sugest = "
                select  sum(PO.ponto) div count(S.users_id) as client_point
                from sales S
                inner join users U on(U.id = S.users_id)
                inner join products PR on(S.products_id = PR.id)
                inner join category C on (PR.category_id = C.id)
                inner join point PO on(PO.id = C.point_id)
                where U.id =".$user_id;
        
       $client_point = $obj->executeSql($sql_sugest);
       return $client_point[0]['client_point'];  
    }
    function sugest_book($user_id, $obj){
        $points = $this->get_point_user($user_id, $obj);
        $points_mais = $points +1;
        $points_menos = $points -1;
                
        
        $sql_book = "Select PR.name
                from products PR
                inner join category C on(PR.category_id = C.id)
                inner join point PO on(PO.id = C.point_id)
                where PO.ponto =".$points. 
                " or PO.ponto =".$points_mais .
                " or PO.ponto =".$points_menos;
        //echo $sql_book;
        $sugest_book = $obj->executeSql($sql_book);
        return $sugest_book;
    }
    
}

