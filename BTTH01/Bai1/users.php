<?php require 'flowers.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</title>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: "Times New Roman", Arial, sans-serif;
        line-height: 1.7;
        background: #f7f7f7;
        color: #333;
    }

    .page-wrapper {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px 40px 50px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }

    h1 {
        font-size: 28px;
        text-align: center;
        margin-bottom: 25px;
        color: #26612d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    h1 span {
        display: block;
        font-size: 16px;
        font-weight: normal;
        text-transform: none;
        color: #666;
        margin-top: 6px;
    }

    .intro-line {
        height: 2px;
        width: 80px;
        background: #ff6f61;
        margin: 0 auto 30px;
        border-radius: 999px;
    }

    .flower-item {
        margin-bottom: 35px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .flower-item:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 8px;
        color: #1c4f82;
    }

    .title span.index {
        margin-right: 6px;
    }

    .flower-name-link {
        color: #0b5ed7;
        text-decoration: none;
        font-weight: bold;
    }

    .flower-name-link:hover {
        text-decoration: underline;
    }

    .flower-desc {
        text-align: justify;
        margin-bottom: 15px;
        font-size: 15px;
    }

    .flower-item img {
        display: block;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        border-radius: 8px;
    }

    .admin-link {
        display: inline-block;
        margin-top: 35px;
        text-decoration: none;
        font-size: 14px;
        color: #fff;
        background: #1c4f82;
        padding: 8px 18px;
        border-radius: 999px;
        transition: background 0.2s ease;
    }

    .admin-link:hover {
        background: #163b5f;
    }

    @media (max-width: 768px) {
        .page-wrapper {
            margin: 20px;
            padding: 20px;
        }

        h1 {
            font-size: 22px;
        }
    }
</style>
</head>
<body>

<div class="page-wrapper">
    <h1>
        14 LOẠI HOA TUYỆT ĐẸP
        <span>Thích hợp trồng để khoe hương sắc dịp xuân – hè</span>
    </h1>
    <div class="intro-line"></div>

    <?php 
    $stt = 1;
    foreach ($flowers as $f) : ?>
        <div class="flower-item" id="flower-<?= $stt; ?>">
            <div class="title">
                <span class="index"><?= $stt++; ?>.</span>
                <?= htmlspecialchars($f['name']); ?>
            </div>

            <p class="flower-desc">
                <!-- tên hoa dạng link xanh giống bài mẫu -->
                <a class="flower-name-link" href="#flower-<?= $stt - 1; ?>">
                    <?= htmlspecialchars($f['name']); ?>
                </a>
                <?= ' ' . nl2br(htmlspecialchars($f['description'])); ?>
            </p>

            <img src="<?= htmlspecialchars($f['image']); ?>" alt="<?= htmlspecialchars($f['name']); ?>">
        </div>
    <?php endforeach; ?>

    <a class="admin-link" href="admin.php">→ Trang quản trị</a>
</div>

</body>
</html>
