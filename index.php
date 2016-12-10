<?php
require_once __DIR__ . '/controllers/CommentController.php';
$controller = new CommentController($_REQUEST);
echo $controller;