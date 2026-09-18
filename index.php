<?php
require_once 'Database.php';
require_once 'Student.php';

$db = (new Database())->connect();
$studentModel = new Student($db);

// fetch all students
$stmt = $studentModel->readAll();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalAllowance = $studentModel->totalAllowance();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Student Allowance Tracker</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;padding:12px}
    table{width:100%;border-collapse:collapse;margin-bottom:12px}
    th,td{border:1px solid #ddd;padding:8px;text-align:left}
    th{background:#f2f2f2}
    a.button{display:inline-block;padding:8px 12px;background:#2d89ef;color:#fff;text-decoration:none;border-radius:4px}
    form.inline{display:inline}
  </style>
</head>
<body>
  <h2>Student Allowance Tracker</h2>
  <p><a class="button" href="create.php">Add New Student</a></p>
  <table>
    <tr>
      <th>ID</th><th>Name</th><th>Course</th><th>Year</th><th>Allowance</th><th>Actions</th>
    </tr>
    <?php if(count($students)==0): ?>
      <tr><td colspan="6">No students yet</td></tr>
    <?php else: ?>
      <?php foreach($students as $s): ?>
        <tr>
          <td><?php echo htmlspecialchars($s['id']); ?></td>
          <td><?php echo htmlspecialchars($s['student_name']); ?></td>
          <td><?php echo htmlspecialchars($s['course']); ?></td>
          <td><?php echo htmlspecialchars($s['year_level']); ?></td>
          <td><?php echo number_format($s['allowance'],2); ?></td>
          <td>
            <a href="edit.php?id=<?php echo $s['id']; ?>">Edit</a> |
            <a href="delete.php?id=<?php echo $s['id']; ?>" onclick="return confirm('Delete this student?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    <tr>
      <th colspan="4">Total Allowance</th>
      <th colspan="2"><?php echo number_format($totalAllowance,2); ?></th>
    </tr>
  </table>
</body>
</html>