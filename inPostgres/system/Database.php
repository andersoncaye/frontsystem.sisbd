<?php

//namespace System;

class Database extends \PDO
{

	public function __construct($dbType, $dbHost, $dbName, $dbUser, $dbPass)
	{
		try {

			//parent::__construct("{$dbType}:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass); //MySql
            parent::__construct("$dbType:host=$dbHost;port=5432;dbname=$dbName;user=$dbUser;password=$dbPass"); //Postgres

        } catch (\PDOException $e) {

			die("Ops! Desculpe, ocorreu uma falha de carregamento. Tente novamente mais tarde.\n".$e);

        }
	}

	public function insert($table, $data, $lastInsertIdName = NULL)
	{

		ksort($data);

		$fields = implode(', ', array_keys($data));
		$values = ':' . implode(', :', array_keys($data));

		$sth = $this->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$values})");

		foreach ($data as $key => $value) :
			if (is_int($value)) :
				$type = \PDO::PARAM_INT;
			elseif (is_null($value)) :
				$type = \PDO::PARAM_NULL;
			elseif (is_bool($value)) :
				$type = \PDO::PARAM_BOOL;
			else :
				$type = \PDO::PARAM_STR;
			endif;
			$sth->bindValue(":$key", $value, $type);
		endforeach;

	    $retry = $sth->execute();

		if (NULL == $lastInsertIdName && $retry) :
			return $this->lastInsertId($lastInsertIdName);
		endif;
		
		return $retry;
	}

	public function select($qry, $bindValueReplace = array(), $all = TRUE, $fetchMode = \PDO::FETCH_OBJ)
	{
		// Prepare a SQL Query
		$sth = $this->prepare($qry);

		if ($bindValueReplace !== NULL) :
			foreach ($bindValueReplace as $key => $value) :
				if (is_int($value)) :
					$type = \PDO::PARAM_INT;
				elseif (is_null($value)) :
					$type = \PDO::PARAM_NULL;
				elseif (is_bool($value)) :
					$type = \PDO::PARAM_BOOL;
				else :
					$type = \PDO::PARAM_STR;
				endif;
				$sth->bindValue($key, $value, $type);
			endforeach;
		endif;

		$sth->execute();

		if ($all) :
			return $sth->fetchAll($fetchMode);
		else :
			return $sth->fetch($fetchMode);
		endif;
	}
	
	public function update($table, $fieldsArray, $where)
	{
		foreach ($fieldsArray as $key => $value) :
			$data[] = "$key = :$key";
		endforeach;

		$fields = implode(', ', $data);

		$sth = $this->prepare("UPDATE $table SET $fields WHERE $where");

		foreach ($fieldsArray as $key => $value) :
			if (is_int($value)) :
				$type = \PDO::PARAM_INT;
			elseif (is_null($value)) :
				$type = \PDO::PARAM_NULL;
			elseif (is_bool($value)) :
				$type = \PDO::PARAM_BOOL;
			else :
				$type = \PDO::PARAM_STR;
			endif;                    
			$sth->bindValue(":$key", $value, $type);
		endforeach;

		$reply = $sth->execute();

		return $reply;
	}

	public function delete($table, $where)
	{
        $query = "DELETE FROM {$table} WHERE {$where}";

		$sth = $this->prepare($query);

		$retry = $sth->execute();

		return $query;
	}
}
