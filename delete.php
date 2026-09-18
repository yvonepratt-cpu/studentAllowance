<?php
require_once 'Database.php';
require_once 'Student.php';

$db = (new Database())->connect();
$studentModel = new Student($db);

$id = $_GET['id'] ?? null;
if($id){
    $studentModel->id = $id;
    $studentModel->delete();
}
header('Location: index.php');
exit;