<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Notice</title>
  <link rel="stylesheet" href="../css/notice.css">
</head>
<body>

  <div class="notice-box">
    <h2>Create a Notice</h2>
    <form action="notice_submit.php" method="POST">
      <input type="text" name="title" placeholder="Notice Title" required>
      <textarea name="description" rows="5" placeholder="Notice Description" required></textarea>
      <button type="submit">Send Notice</button>
    </form>
  </div>

  <script src="../js/notice.js"></script>
</body>
</html>
