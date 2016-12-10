<?php
class DBService {
	private $connection = null;

	public function __construct() {
		$this->connection = mysqli_connect('127.0.0.1', 'root', '1111', 'mars');
	}

	public function executeQuery($query) {
		$result = null;
		$res = mysqli_query($this->connection, $query);
		foreach ($res as $row) {
			$result[] = $row;
		}
		return $result;
	}

	public function executeCommitQuery($query) {
		mysqli_query($this->connection, $query);
	}

	public function __destruct() {
		if ($this->connection) {
			mysqli_close($this->connection);
		}
	}
}