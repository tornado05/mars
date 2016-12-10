<?php
class UserService{
	private $dbService = null;

	public function __construct($dbService) {
		$this->dbService = $dbService;
	}

	public function authenticate($login, $pw) {
		$query = 'SELECT id_user, login FROM User WHERE login = "' . $login . '" AND pw = md5("' . $pw . '") AND is_valid = 1;';
		$users = $this->dbService->executeQuery($query);
		return $users[0];
	}
}