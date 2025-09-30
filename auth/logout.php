<?php
require_once __DIR__ . '/../layouts/app.php';

session_start();
$_SESSION = [];
header('Location: ' . url('/'));
