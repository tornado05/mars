<?php
class CommentService{
	private $dbService = null;

	public function __construct($dbService) {
		$this->dbService = $dbService;
	}

	public function addComment($id_user, $text) {
		$query = 'INSERT INTO Comment(id_user, comment_instance, create_date, is_valid) VALUE ' . 
		'(' . $id_user . ', "' . $text . '", NOW(), 1);';
		$this->dbService->executeCommitQuery($query);
	}

	public function getComments() {
		$query = 'SELECT * FROM Comment LEFT JOIN User ON User.id_user = Comment.id_user ORDER BY Comment.create_date desc;';
		return $this->dbService->executeQuery($query);
	}
}