<?php
// Required questions
$required = [
  "html1","html2","html3","html4","html5",
  "css1","css2","css3","css4","css5",
  "php1","php2","php3","php4","php5",
  "js1","js2","js3","js4","js5"
];

$errors = [];
foreach ($required as $q) {
    if (empty($_POST[$q])) {
        $errors[] = $q;
    }
}

if (!empty($errors)) {
    echo "<h2 style='color:red; text-align:center;'>❌ Please answer all questions before submitting!</h2>";
    echo "<div style='text-align:center;'><a href='../view/quizzes.html'>Go Back</a></div>";
    exit();
}

echo "<h2 style='color:green; text-align:center;'>✅ Quiz Submitted Successfully!</h2>";
echo "<div style='text-align:center;'><a href='../view/quizzes.html'>Take Again</a></div>";
?>
