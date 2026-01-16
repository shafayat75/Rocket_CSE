<?php
// take_quiz.php
session_start();

$quizDir = realpath(__DIR__ . '/../assets/uploads/quiz');
$quizFiles = glob($quizDir . '/*.txt');

if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // sanitize input
    $path = $quizDir . '/' . $file;

    if (is_file($path)) {
        $content = file_get_contents($path);

        // Parse questions
        preg_match_all('/Q\d+\)\s*(.+?)\s*a\)\s*(.+?)\s*b\)\s*(.+?)\s*c\)\s*(.+?)\s*d\)\s*(.+?)\s*ANSWER:\s*([a-d])/is', $content, $matches, PREG_SET_ORDER);
    }
}

// Handle submission
$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'], $_POST['correct'])) {
    $answers = $_POST['answers'];
    $correct = $_POST['correct'];

    $score = 0;
    foreach ($correct as $i => $corr) {
        if (isset($answers[$i]) && strtolower($answers[$i]) === strtolower($corr)) {
            $score++;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Take Quiz</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: auto; }
        h2 { color: #444; }
        .quiz-list a { display: block; margin: 5px 0; color: blue; text-decoration: underline; }
        .question { margin-bottom: 20px; }
        .question h4 { margin-bottom: 6px; }
        .score { font-weight: bold; color: green; font-size: 1.2em; }
    </style>
</head>
<body>

<h2>Take Quiz</h2>

<?php if (isset($matches)): ?>
    <form method="post">
        <?php foreach ($matches as $i => $q): ?>
            <div class="question">
                <h4>Q<?= $i + 1 ?>) <?= htmlspecialchars($q[1]) ?></h4>
                <?php foreach (['a','b','c','d'] as $j => $opt): ?>
                    <label>
                        <input type="radio" name="answers[<?= $i ?>]" value="<?= $opt ?>" required>
                        <?= strtoupper($opt) ?>) <?= htmlspecialchars($q[$j + 2]) ?>
                    </label><br>
                <?php endforeach; ?>
                <input type="hidden" name="correct[<?= $i ?>]" value="<?= $q[6] ?>">
            </div>
        <?php endforeach; ?>
        <button type="submit">Submit Quiz</button>
    </form>

    <?php if ($score !== null): ?>
        <p class="score">You scored <?= $score ?> out of <?= count($matches) ?>.</p>
    <?php endif; ?>

    <p><a href="take_quiz.php">← Back to Quiz List</a></p>

<?php else: ?>
    <h3>Available Quizzes:</h3>
    <div class="quiz-list">
        <?php foreach ($quizFiles as $file): ?>
            <?php $name = basename($file); ?>
            <a href="?file=<?= urlencode($name) ?>"><?= htmlspecialchars($name) ?></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</body>
</html>
