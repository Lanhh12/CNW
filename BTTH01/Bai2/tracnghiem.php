<?php
// Đọc nội dung từ file Quiz.txt (cải tiến: parse option letter, hỗ trợ nhiều đáp án, trim, bảo mật output)
$quizFile = 'Quiz.txt';
$questions = [];

if (file_exists($quizFile)) {
    $lines = file($quizFile, FILE_IGNORE_NEW_LINES);
    $current = null;

    foreach ($lines as $raw) {
        $line = trim($raw);
        if ($line === '') continue;

        // ANSWER: hoặc answer:
        if (stripos($line, 'ANSWER:') === 0) {
            $ansPart = trim(substr($line, 7));
            // hỗ trợ định dạng "A,B" hoặc "A, B" hoặc "A"
            $answers = array_filter(array_map('trim', preg_split('/[,;]+/', strtoupper($ansPart))));
            $current['answer'] = $answers;
            $questions[] = $current;
            $current = null;
            continue;
        }

        // Option line như "A. Text" hoặc "A) Text" (cho phép khoảng trắng trước)
        if (preg_match('/^\s*([A-Z])\s*[.)]\s*(.+)$/i', $line, $m)) {
            if ($current === null) {
                // If an option appears before a question, skip it
                continue;
            }
            $letter = strtoupper($m[1]);
            $text = $m[2];
            $current['options'][] = ['letter' => $letter, 'text' => $text];
            continue;
        }

        // Nếu không phải option hay answer => là câu hỏi
        $current = ['question' => $line, 'options' => []];
    }
} else {
    die('Không tìm thấy file Quiz.txt');
}

// Xử lý POST (lưu lựa chọn người dùng, nhưng KHÔNG tính điểm / kiểm tra đúng-sai)
$userAnswers = $_POST['answer'] ?? [];
$total = count($questions);
$results = [];

foreach ($questions as $i => $q) {
    $correct = $q['answer'] ?? [];
    // normalize correct answers (array of letters)
    $correctNorm = array_map('strtoupper', array_map('trim', $correct));

    $userRaw = $userAnswers[$i] ?? null;
    if (is_array($userRaw)) {
        $user = array_map('strtoupper', array_map('trim', $userRaw));
    } elseif ($userRaw !== null) {
        $user = [strtoupper(trim($userRaw))];
    } else {
        $user = [];
    }

    $results[$i] = [
        'user' => $user,
        'correct' => $correctNorm
    ];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài thi trắc nghiệm</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
        }
        .quiz-container {
            max-width:800px;
            margin:0 auto;
            background:#fff;
            padding:20px;
            border-radius:8px;
            box-shadow:0 4px 8px rgba(0,0,0,0.1);
        }
        .question {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .question h3 {
            font-size:18px;
            margin-bottom:10px;
        }
        .options label {
            display: block;
            margin: 5px 0;
            cursor: pointer;
        }
        .submit-btn {
            margin-top:20px;
            padding:10px 20px;
            background:#007bff;
            color:#fff;
            border:none;
            border-radius:4px;
            cursor:pointer;
        }
        .submit-btn:hover {
            background:#0056b3;
        }
        .answer {
            margin-top:10px;
            font-weight:bold;
        }
        .fade-in {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el) => {
                el.style.opacity = 0;
                el.style.transition = "opacity 1s";
                setTimeout(() => {
                    el.style.opacity = 1;
                }, 100);
            });
        });
    </script>
</head>
<body>
    <div class="quiz-container">
        <h1>Bài thi trắc nghiệm</h1>

        <form method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question fade-in">
                    <h3><?= htmlspecialchars($q['question']) ?></h3>
                    <div class="options">
                        <?php
                            $multi = count($q['answer']) > 1;
                            foreach ($q['options'] as $opt):
                                $letter = $opt['letter'];
                                $text = $opt['text'];
                                $name = "answer[$index]" . ($multi ? '[]' : '');
                                $value = $letter;
                                // giữ trạng thái checked nếu đã submit
                                $checked = false;
                                if (isset($results[$index])) {
                                    $checked = in_array($letter, $results[$index]['user']);
                                } else {
                                    $checked = false;
                                }
                        ?>
                            <label>
                                <input type="<?= $multi ? 'checkbox' : 'radio' ?>"
                                       name="<?= htmlspecialchars($name) ?>"
                                       value="<?= htmlspecialchars($value) ?>"
                                       <?= $checked ? 'checked' : '' ?>>
                                <?= htmlspecialchars($letter . '. ' . $text) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                        $res = $results[$index];
                        $correctDisplay = implode(', ', $res['correct']);
                    ?>
                        <div class="answer">Đáp án đúng: <?= htmlspecialchars($correctDisplay) ?>.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="submit-btn">Nộp bài</button>
        </form>
    </div>
</body>
</html>