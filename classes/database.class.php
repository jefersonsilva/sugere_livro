<?php
########################################################################
/**
 * Classe que extende o objeto PDO
 * @author Marcelo Soares da Costa
 * @email phpmafia at yahoo dot com dot br
 * @copyright Marcelo Soares da Costa Â© 2007/2009.
 * @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
 * @version 2.0
 * @access public
 * @changelog
 * @package OOE
 * @data 2009-06-30
 */
#################################################################################

class database extends PDO{

	private $objPdo = false;
	private $sth;
	private $sql;
	private $dbh;
	private $row;
	private $rows;
	private $result;
	private $affected;
	private $queryType;
	private $sqlStatment;
	private $sqlClean = null;
	private $results = array ();

	function __construct($conn=null) {
		try{
			if (in_array(strtolower(USEDB), PDO::getAvailableDrivers())) {
				self::_dsn($conn);

				parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} else {
				throw new Exception("Driver " . USEDB . " Unvaliable");
			}


		} catch (PDOException $e) {
			$cathMsg= 'Sua requisicao encontrou um problema de solicitacao, tente novamente em alguns minutos';
			$mensage = wordwrap("[Conexao]:".$e->getMessage(), 70);
			self::sendAlertMsg($mensage);
			throw new Exception("<h3>".$cathMsg."</h3>");
		}
	}

	/**
	 *
	 * Metodo privado para montar a conexao com o banco de dados escolhido
	 * @access private
	 * @input database type = master,slave,default {string}
	 * @return void dsn connection {string}
	 *
	 */

	private function _dsn($conection)
	{
		try{
				
			switch(strtolower($conection))
			{
				case 'slave':
					$HOST=HOST_SLAVE;
					$DATABASE=DATABASE_SLAVE;
					$USER=USER_SLAVE;
					$PASSWORD=PASSWORD_SLAVE;
					break;
				case 'master':
					$HOST=HOST_MASTER;
					$DATABASE=DATABASE_MASTER;
					$USER=USER_MASTER;
					$PASSWORD=PASSWORD_MASTER;
					break;
				default :
					$HOST=HOST;
					$DATABASE=DATABASE;
					$USER=USER;
					$PASSWORD=PASSWORD;
			}
				
			$this->objPdo=parent::__construct(strtolower(USEDB) . ":host=" . $HOST . ";dbname=" . $DATABASE, $USER, $PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8") );
				
		} catch (PDOException $e) {
			throw new Exception("[Connection] :=>".$e->getMessage());
		}

	}
	 
	/**
	 *
	 * Metodo privado para retirar cÃ³digo malicioso
	 * @access private
	 * @input SQL {string}
	 * @return sql {string}
	 *
	 */
	private function __sqlClean($sql) {
		$arrayInjection = array (
			"#",
			"--",
			"//",
			";",
			"/*",
			"*/",
			"drop",
			"truncate");

		$sqlClean = trim(str_ireplace($arrayInjection,'',trim($sql)));

		if ($sqlClean == null) {
			$mensage = wordwrap("[Injection]:".$sql,150);
			self::sendAlertMsg($mensage);
			throw new Exception("Invalid => SQL Clean:[".$sql."]");
		} else {
			return $sqlClean;
		}
	}
	#
	/**
	*
	* Metodo privado para verificar o tipo de query
	* @access private
	* @input SQL {string}
	* @return tipo de query {string}
	*
	*/

	private function __queryType($sql) {
		unset ($this->queryType);

		list ($__queryType) = explode(" ",trim($sql));

		$this->queryType = strtolower($__queryType);

		switch ($this->queryType) {
			case "select";
			return $this->queryType;
			break;
			case "insert";
			return $this->queryType;
			break;
			case "update";
			case "delete";
			if (stripos(strtolower($sql), 'where') == true) {
				return $this->queryType;
			}else{
				$mensage = wordwrap("[Clause]:".$sql,150);
				self::sendAlertMsg($mensage);
				throw new Exception("Don\'t have clause WHERE in =>SQL:[".$sql."] ");
			}
			break;
			default :
				$mensage = wordwrap("[Invalid Query]:".$sql,70);
				self::sendAlertMsg($mensage);
				throw new Exception("Invalid => SQL querytype:[".$sql."]");
				break;
		}
	}

	/**
	 *
	 * Metodo privado que valida a query
	 * @access private
	 * @input SQL {string}
	 * @return exception
	 *
	 */
	private function __checkSql($sql) {
		try{
			$sqlClean=$this->__sqlClean($sql);
			$this->__queryType($sqlClean);
			return $sqlClean;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 *
	 * Metodo privado que efetua o prepare
	 * @access private
	 * @input SQL {string}
	 * @return exception
	 *
	 */
	private function __prepare($sql) {
		unset ($this->sqlPrepare);
		$this->timestart = microtime(true);
		try{
			$sqlClean=$this->__checkSql($sql);
			try{
				$this->sth = parent::prepare($sqlClean);
				$this->sqlPrepare=$sqlClean;
				return $this->sqlPrepare;
			} catch (PDOException $e) {
				$mensage = wordwrap("[Prepare]:".$sql."\n ERRO =>".$e->getMessage(),250);
				self::sendAlertMsg($mensage);
				throw new Exception("[prepare]".$sql."<br/>\r\n MSG :".$e->getMessage());
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}

	/**
	 *
	 * Metodo privado que executa a query
	 * @access private
	 * @input SQL {string}
	 * @return exception
	 *
	 */
	private function __execute($param=null) {
		unset($this->result);
		 
		if($param==null){
			try{
				$result=$this->sth->execute();

			} catch (PDOException $e) {
		 	$mensage = "[execute]:SQL=>".$this->sqlPrepare."\n  ERRO =>".$e->getMessage();
		 	self::sendAlertMsg($mensage);
		 	throw new Exception("[execute]: MSG :".$e->getMessage());
			}

		}elseif(is_array($param)){
			try{
				$result=$this->sth->execute($param);
			} catch (Exception $e) {
				$result=$this->sth->execute(array_values($param));
			}
		}
		 


	}

	/**
	 *
	 * Metodo publico para envocar o metodo prepare
	 * @access public
	 * @input SQL {string}
	 * @return exception
	 *
	 */
	final public function prepareSQL($sql) {
		try{
			self::__prepare($sql);
		} catch (Exception $e) {
			$mensage = "[prepareSQL]:".$sql."\n  ERRO =>".$e->getMessage();
			self::sendAlertMsg($mensage);
			throw new Exception($e->getMessage());
		}
	}

	/**
	 *
	 * Metodo publico para executar um Statment
	 * @access public
	 * @input Statment {array}
	 * @return result
	 *
	 */
	final public function execStatment($param) {
		if($this->sqlPrepare!=null)
		{
			if(is_array($param)){
	   $array=$param;
			}else{
	   $array=explode(',', $param);
			}
			$result= self :: __setSql($this->sqlPrepare,$array);
			if ($this->queryType == "select") {
				return self :: getAssocArray();
			} else{
				return $result;
			}
		}else{
			throw new Exception("First need prepareSQL");
		}

	}

	/**
	 *
	 * Metodo publico para retornar o resultado de uma query qualquer
	 * Verifica se a query e um SELECT e retorna um array associativo
	 * se a query for INSERT retorna o lastId se for update ou delete retorna afected
	 * @access public
	 * @input string
	 * @return mixed
	 *
	 */
	final public function executeSql($sql)
	{
		self::__prepare($sql);
		if ($this->queryType == "select")
		{
			self :: __setSql($sql);
			return self :: getAssocArray();
		}
		else
		{
			return self :: __setSql($sql);
		}
	}
	/**
	 *
	 * Metodo privado para query do tipo SELECT
	 * Prepara e executa SELECT
	 * @access private
	 * @input SQL {string}
	 * @return Obj
	 *
	 */

	private function __selectQuery($sql,$param=null) {
		if ($this->queryType == "select") {
			return self::__execute($param);
		} else {
			throw new Exception("NAO E SELECT =>SQL:[".$sql."] ");
		}
	}

	/**
	 *
	 * Metodo privado para query condicionais
	 * Executa query condicionais para query UPDATE e DELETE
	 * @access private
	 * Retorna o numero de resultados afetados
	 * @input SQL {string}
	 * @return numero de resultados afetados, number of affected rows, {int}
	 *
	 */

	private function __conditionalQuery($sql,$param=null) {
		if (stripos(strtolower($sql), 'where') == true) {
			self::__execute($param);
			try {
				return $this->sth->rowCount();
			} catch (PDOException $e) {
				$mensage = "[conditionalQuery]: ERRO =>".$e->getMessage();
				self::sendAlertMsg($mensage);
				throw new Exception("[conditionalQuery] MSG :\"".$e->getMessage());
			}
		} else {
			throw new Exception("Eh necessario a clausula WHERE =>SQL:[".$sql."] ");
		}
	}

	/**
	 *
	 * Metodo privado para query do tipo INSERT
	 * Executa query INSERT e retorna o ID inserido
	 * @access private
	 * Retorna o numero ID inserido
	 * @input SQL {string}
	 * @return lastInsertId {int}
	 *
	 */

	private function __insertQuery($sql,$param=null) {
		if ($this->queryType == "insert") {
			self::__execute($param);
			try {
				return parent::lastInsertId();
			} catch (PDOException $e) {
				$mensage = wordwrap("[INSERT]:".$e->getMessage(),150);
				self::sendAlertMsg($mensage);
				throw new Exception("[INSERT] MSG :\"".$e->getMessage());
				return false;
			}
		} else {
			throw new Exception("Nao eh INSERT=>SQL:[".$sql."] ");
		}
	}

	/**
	 *
	 * Metodo publico para setar a query
	 * Decide o metodo de acordo com o tipo de SQL
	 * @access public
	 * @input SQL {string}
	 * @return Obj
	 *
	 */

	private function __setSql($sql,$param=null) {
 	      
		$this->$sql=$sql;
 	      
		switch (self :: __queryType($sql)) {
			case "select";
			return self :: __selectQuery($sql,$param); // Para testes basta retirar os comentarios
			break;

			case "update";
			case "delete";
			return self :: __conditionalQuery($sql,$param);
			break;

			case "insert";
			return self :: __insertQuery($sql,$param);
			break;

			default :
				$mensage = wordwrap("[Query nao suportada]:\n".$sql."\n".$e->getMessage(),150);
				self::sendAlertMsg($mensage);
				throw new Exception("Query não suportada =>SQL:[".$sql."]\r\n<br/>");
				break;
		}
	}

	/**
	 *
	 * Metodo publico para retornar um array associativo
	 * Verifica se a query e um SELECT e retorna um array associativo
	 * @access public
	 * @input
	 * @return array
	 *
	 */

	final public function getAssocArray()
	{
		$time_start = microtime(true);
		unset ($rows);
		unset ($results);
		 
		try{
			self::__selectQuery($this->sqlPrepare);

			try {
				while ($rows =  $this->sth->fetch(PDO::FETCH_ASSOC)) {
					$results[] = $rows;
				}

				return $results;
			} catch (PDOException $e) {
				$mensage = wordwrap("[getAssocArray]:\n ERRO =>".$e->getMessage(),150);
				self::sendAlertMsg($mensage);
				throw new Exception("[getAssocArray] :\"".$e->getMessage()."\"");
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Metodo publico para retornar uma linha com um array associativo
	 * Verifica se a query e um SELECT e retorna um array associativo
	 * @access public
	 * @input
	 * @return array
	 */

	final public function getLineArray() {
		unset ($results);
		 
		try{
			self::__selectQuery($this->sqlPrepare);

			try {
				$results=  $this->sth->fetch();
				return $results;
			} catch (PDOException $e) {
				$mensage = wordwrap("[getLineArray]:".$this->sqlPrepare.":=>".$e->getMessage(),150);
				self::sendAlertMsg($mensage);
				throw new Exception("[getLineArray]".$e->getMessage()."\"");
			}

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}

	/**
	 *
	 * Metodo publico para retornar um resultado especifico de uma coluna
	 * Verifica se a query e um SELECT e retorna o valor de um campo
	 * @access public
	 * @input number ,optional array[key]
	 * @return string (array[key]=>value)
	 *
	 */

	final public function getRow($row = 0) {

		if ($this->queryType == "select")  {
			self :: __selectQuery($this->sqlPrepare);
			try {
				$result = $this->sth->fetchColumn($row);
			} catch (PDOException $e) {
				$mensage = wordwrap("[getRow]:".$this->sqlPrepare.":=>".$e->getMessage(),150);
				self::sendAlertMsg($mensage);
				throw new Exception("[getRow] :".$e->getMessage());
			}
			return $result;
		} else {
			throw new Exception("SELECT não definido para uso de getRow defina setSql");
		}
	}

	public function beginTransaction() {
		$transaction = parent::beginTransaction();
	}
	#
	public function commit() {
		$commit = parent::commit();
	}
	#
	public function rollBack() {
		$rollBack = parent::rollBack();
	}


	/**
	 *
	 * Envia mensagem de erro para email especificado
	 * @access private
	 * @input error mensage
	 * @ return email and exception
	 */

	private function sendAlertMsg($mensage)
	{
		 

		$headers='From: contato@jefersonsilva.in' . "\r\n";
		$headers.='Reply-To: contato@jefersonsilva.in';
		 
		$message = wordwrap($mensage, 500);

$message.="IP=>".$_SERVER["REMOTE_ADDR"]."\n USER AGENT=>".$_SERVER["HTTP_USER_AGENT"]."\n URL=>".$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]."\n";

		foreach($_REQUEST as $key=>$value)
		{
			$message.=" Campo : ".$key." Valor :".$value."\r\n";
		}
		mail('contato@jefersonsilva.in,contato@jefersonsilva.in', 'Alerta de ERRO X3 : Exception', $message,$headers);

	}

	/**
	 *
	 * Previne que o usuario clone a instancia
	 * @access public
	 *
	 */

	public function __clone() {
		throw new Exception("Clone is not allowed.");
	}

	# fim da classe
}
class DataBasePdoStatement extends PDOStatement {
}
?>