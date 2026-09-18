<?php
require_once 'Database.php';
require_once 'Student.php';

$db = (new Database())->connect();
$studentModel = new Student($db);

$message = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $studentModel->student_name = $_POST['student_name'] ?? '';
    $studentModel->course = $_POST['course'] ?? '';
    $studentModel->year_level = $_POST['year_level'] ?? '';
    $studentModel->allowance = $_POST['allowance'] ?? 0;
    if($studentModel->create()){
        header('Location: index.php');
        exit;
    } else {
        $message = 'Failed to add student';
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Student</title><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body>
  <h2>Add Student</h2>
  <?php if($message) echo "<p>$message</p>"; ?>
  <form method="post">
    <label>Name<br><input name="student_name" required></label><br><br>
    <label>Course<br><input name="course" required></label><br><br>
    <label>Year Level<br><input name="year_level"></label><br><br>
    <label>Allowance<br><input name="allowance" type="number" step="0.01" value="0.00"></label><br><br>
    <button type="submit">Save</button> | <a href="index.php">Cancel</a>
  </form>
</body>
</html>