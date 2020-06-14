<?php

//namespace System;

class Database
{
    public static $typeResearch_FIND = 'find';
    public static $typeResearch_AGGREGATE = 'aggregate';

    protected $clientDB;
    protected $database;

    public function __construct($connectionString, $dataBaseName)
	{
	    try{
            $this->clientDB = new MongoDB\Client($connectionString);
            $this->database = $this->clientDB->selectDatabase($dataBaseName);
        }catch (Exception $exception){
            die("Ops! Desculpe, ocorreu uma falha de carregamento. Tente novamente mais tarde.\n".$exception);
        }
	}

	public function select($collection, $typeResearch, $command)
	{
	    $documents = null;
        $selectCollection = $this->database->selectCollection($collection);
        if ($typeResearch == 'find'){

        } else if ($typeResearch == 'aggregate') {
            $documents = $selectCollection->aggregate($command); //váriavel usada na posição : $pipeline
        }
        return $documents;
	}

}
