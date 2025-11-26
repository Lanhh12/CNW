<?php
// Đường dẫn tới file CSV
$csvFile = '65HTTT_Danh_sach_diem_danh.csv';

// Kiểm tra file
if (!file_exists($csvFile)) {
    die('Không tìm thấy file CSV.');
}

$rows = [];
$header = [];

if (($handle = fopen($csvFile, 'r')) !== false) {
    // đọc header
    $rawHeader = fgetcsv($handle);
    if ($rawHeader === false) {
        fclose($handle);
        die('File CSV trống hoặc không thể đọc header.');
    }

    // loại bỏ BOM nếu có ở ô đầu tiên
    $rawHeader[0] = preg_replace('/^\xEF\xBB\xBF/', '', $rawHeader[0]);

    $header = $rawHeader;

    // đọc các dòng còn lại và chuyển thành associative array theo header
    while (($row = fgetcsv($handle)) !== false) {
        // if row has fewer cols, pad with empty strings
        if (count($row) < count($header)) {
            $row = array_pad($row, count($header), '');
        }
        $assoc = array_combine($header, array_slice($row, 0, count($header)));
        $rows[] = $assoc;
    }
    fclose($handle);
} else {
    die('Không thể mở file CSV.');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSĐD</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 20px; 
            padding: 0; 
            background-color: #addaecff; 
        }
        table { 
            width: 85%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            background: #fff; 
            box-shadow: 0 4px 8px rgba(53, 214, 38, 0.8); 
        }
        th, td { 
            border: 3px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #28a745; 
            color: #fff; 
            font-weight: bold; 
        }
        tr:nth-child(even) { 
            background-color: #f8f9fa; 
        }
        tr:hover { 
            background-color: #d1e7dd; 
        }
        .no-data { 
            padding: 12px; 
            background: #fff; 
            border: 1px solid #ddd; 
            color: #6c757d; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1>DANH SÁCH ĐIỂM DANH</h1>

    <?php if (empty($rows)): ?>
        <div class="no-data">Không có bản ghi phù hợp.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <?php foreach ($header as $col): ?>
                        <th><?= htmlspecialchars($col) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($header as $col): ?>
                            <td><?= htmlspecialchars($row[$col] ?? '') ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>