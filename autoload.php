<?php

/* 
 *@author Jeferson R R Silva
 *@license FreeBSD  http://www.freebsd.org/copyright/freebsd-license.html
 *@version 1.0
 *@access public
 *@package OOE
 *@data 2014-07-05
 */

//Locate
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, 'PT_br.UTF8');


//session 
ini_set("session.gc_maxlifetime", '36000');
session_set_cookie_params('36000','/','.jefersonsilva.in');
@session_start();

define('USEDB','Mysql');

define('DATABASE','sugere_livro');
define('HOST','localhost');
define('USER','root');
define('PASSWORD','U.jK9ne5');


function __autoload($className){
    
    $CLASSPATH = '/home/jefersonsilva/public_html/projetos/tcc/classes/';
    $FILENAME = $CLASSPATH.$className.".class.php";
    if(file_exists($FILENAME)){
        
        include_once($FILENAME);
        
    }  
    
}

?>
<html>
    
    <meta charset="UTF-8" />