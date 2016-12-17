<?php
class CommentService{
	private $dbService = null;

	public function __construct($dbService) {
		$this->dbService = $dbService;
	}

	public function addComment($idUser, $text) {
		$query = 'INSERT INTO Comment(id_user, comment_instance, create_date, is_valid) VALUE ' . 
		'(' . $idUser . ', "' . $text . '", NOW(), 1);';
		$this->dbService->executeCommitQuery($query);
	}

	public function getComment($id) {
		$query = 'SELECT * FROM Comment LEFT JOIN User ON User.id_user = Comment.id_user WHERE Comment.id_comment = ' . $id . ' AND is_valid = 1;';
		$res = $this->dbService->executeQuery($query);
		return (count($res) > 0) ? $res[0] : null;
	}

	public function getComments() {
		$query = 'SELECT Comment.id_comment, Comment.comment_instance, Comment.create_date, User.login, User.id_user, (SELECT count(*) FROM UserLike WHERE UserLike.id_comment = Comment.id_comment and UserLike.is_valid = 1) as likes_count FROM Comment LEFT JOIN User ON User.id_user = Comment.id_user WHERE Comment.is_valid = 1 ORDER BY Comment.create_date desc;';
		return $this->dbService->executeQuery($query);
	}

	public function editComment($idComment, $textInstance) {
		$query = 'UPDATE Comment SET comment_instance = "' . $textInstance . '", update_date = NOW() WHERE id_comment = ' . $idComment . ';';
		$this->dbService->executeCommitQuery($query);
	}

	public function deleteComment($idComment) {
		$query = 'UPDATE Comment SET is_valid = 0, update_date = NOW() WHERE id_comment = ' . $idComment . ';';
		$this->dbService->executeCommitQuery($query);
	}

	public function likeComment($idComment, $idUser) {
		$getIsValidQuery = 'SELECT is_valid FROM UserLike WHERE id_user = ' . $idUser . ' AND id_comment = ' . $idComment . ';';
		$isValidRes = $this->dbService->executeQuery($getIsValidQuery);		
		$insertQuery = 'INSERT INTO UserLike(id_user, id_comment, create_date, is_valid) VALUE (' . $idUser . ',' . $idComment . ', NOW(), 1);';
		$updateQuery = 'UPDATE UserLike SET is_valid = ' . (($isValidRes[0]['is_valid'] == 1) ? 0 : 1) . ', update_date = NOW() WHERE id_user = ' . $idUser . ' AND id_comment = ' . $idComment . ';';
		$query = (count($isValidRes) < 1) ? $insertQuery : $updateQuery;

		$this->dbService->executeCommitQuery($query);
	}
}