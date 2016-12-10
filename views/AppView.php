<?php
class AppView {
	public function __construct() {

	}

	public function getTemplate($options) {
		return $this->getHeader($options) . $this->getContent($options);
	}

	private function getContent($options) {
		$result = '';
		if (isset($options['user'])) {
			$result .= $this->getAddCommentForm($options);
		}
		$result .= $this->getCommentsList($options);
		return $result;
	}

	private function getAddCommentForm($options) {
		$user = $options['user'];
		return '<div><form method="POST">' .
		'<input type="hidden" name="action" value="add_comment"/><input type="hidden" name="id_user" value="' . $user['id_user'] . '"/><input type="hidden" name="login" value="' . $user['login'] . '"/>' . 
		'<div><label>Comment text</label><textarea name="comment_text"></textarea></div>' .
		'<div><input type="submit"/><input type="reset"/></div>' .
		'</form></div>';
	}

	private function getCommentsList($options) {
		$comments = '';
		//echo '<pre>';print_r($options['comments']);echo '</pre>';		
		foreach ($options['comments'] as $comment) {
			$idUser = isset($options['user']) ? $options['user']['id_user'] : null;
			$isEditable = $comment['id_user'] === $idUser;
			$comments .= '<div><div>' . $comment['login'] . '</div><div>' . $comment['create_date'] . '</div><div>' . $comment['comment_instance'] . '</div><div>' . ($isEditable ? 'Edit' : '') .  '</div></div>';
		}
		return '<div>' . $comments . '</div>';
	}

	private function getHeader($options) {
		return isset($options['user']) ? $this->getLoggedUserHeader($options): $this->getLoginForm();
	}

	private function getLoginForm() {
		return '<div><form method="POST"><input type="hidden" name="action" value="login"/><div><label>Login</label><input type="text" name="login"/></div><div><label>Password</label><input type="password" name="pw"/></div><div><input type="submit"/><input type="reset"/></div></form></div>';
	}

	private function getLoggedUserHeader($options) {
		$user = $options['user'];
		return '<div>Hello, ' . $user['login'] . '</div>';
	}
}