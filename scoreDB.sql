<?php

require ("service.php");
require ("MySQLDB.php");

class Route
{

private $_uri = array();
private $db;

	public function __construct()
	{
		$this->add('addscore');
		$this->add('getscores');
		$this->add('user/getscore');
		$this->add('check/nickname');
		$this->add('check/account/auth');
		$this->add('new/account/register');

		$this->db = new MySQL('root', '');

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
				if (authenticateUser($this->db) || $value == 'new/account/register' || $value == 'check/nickname')
				{
					$this->action($value);
				}
			}
		}
	}

	public function action($uri)
	{
		switch ($uri) {
			case 'addscore':
				addScore($this->db);
				break;

			case 'getscores':
				getScores($this->db);
				break;

			case 'user/getscore':
				getScore($this->db);
				break;

			case 'check/nickname':
				checkNickname($this->db);
				break;

			case 'check/account/auth':
				checkLogin($this->db);
				break;

			case 'new/account/register':
				registerUser($this->db);
				break;
		}
	}

}