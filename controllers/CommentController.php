<?php
require_once __DIR__ . '/../views/AppView.php';
require_once __DIR__ . '/../services/DBService.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../services/CommentService.php';

class CommentController {
	private $request = null;
	private $appView = null;
	private $dbService = null;	
	private $userService = null;	
	private $commentService = null;

	public function __construct($request) {
		$this->request = $request;

		$this->dbService = new DBService();
		$this->userService = new UserService($this->dbService);
		$this->commentService = new CommentService($this->dbService);
		$this->appView = new AppView();

		$this->request['action'] = isset($this->request['action']) ? $this->request['action'] : null;
	}	

	public function __toString() {
		return $this->executeRequest();
	}

	private function executeRequest() {
		echo '<pre>';print_r($this->request);echo '</pre>';
		switch($this->request['action']) {
			case 'login': return $this->login();
			case 'add_comment': return $this->addComment();
			default: return $this->defaultPage();
		}
	}

	private function defaultPage() {
		$options['comments'] = $this->commentService->getComments();
		return $this->appView->getTemplate($options);
	}

	private function addComment() {
		$options = array();
		if (isset($this->request['id_user'])) {
			$options['user'] = array(
				'id_user' => $this->request['id_user'],
				'login' => $this->request['login']
			);
		}
		$this->commentService->addComment($this->request['id_user'], $this->request['comment_text']);
		$options['comments'] = $this->commentService->getComments();
		return $this->appView->getTemplate($options);
	}

	private function login() {
		$options = array();
		$options['user'] = $this->userService->authenticate($this->request['login'], $this->request['pw']);
		$options['comments'] = $this->commentService->getComments();
		return $this->appView->getTemplate($options);
	}
}
