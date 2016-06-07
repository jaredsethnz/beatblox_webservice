<?php

require ("service.php");
require ("MySQLDB.php");

class Route
{

private $_uri = array();

	public function __construct()
	{
		$this->add('addscore');
		$this->add('getscores');
		$this->add('check/nickname');
		$this->add('check/email');
	}

	public function add($uri)
	{
		$this->_uri[] = $uri;
	}

	public function submit()
	{
		$uriGetParam = isset($_GET['uri']) ? $_GET['uri'] : '/';

		foreach ($this->_uri as $key => $value) 
		{
			if (preg_match("#^$value#", $uriGetParam))
			{
				if (authenticateUser())
				{
					$this->action($value);
				}
			}
		}
	}

	public function action($uri)
	{
		$db = new MySQL('root', 'root');
		switch ($uri) {
			case 'addscore':
				addScore($db);
				break;

			case 'getscores':
				getScores($db);
				break;

			case 'check/nickname':
				checkNickname($db);
				break;

			case 'check/email':
				checkEmail($db);
				break;
		}
	}

}