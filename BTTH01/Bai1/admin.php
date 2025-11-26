<?php include 'flowers.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Admin Hoa xinh</title>
<style>
body{
    background:#fff0f5;
    font-family:'Segoe UI', sans-serif;
}
h2{
    text-align:center;
    color:#e91e63;
    margin:25px 0;
    font-size:28px;
}

/* bảng có bo góc ngoài */
table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 4px 18px rgba(255,140,175,0.35);
}

/* style dòng */
th, td{
    padding:12px;
    border-bottom:1px solid #f2c2d6;
    border-right:1px solid #f2c2d6; 
}

/* bỏ border cột cuối */
th:last-child, td:last-child{
    border-right:none;
}

/* hàng cuối không cần border dưới */
tr:last-child td{
    border-bottom:none;
}

/* header */
th{
    background:#ff9ebb;
    color:white;
    font-size:15px;
}

/* ảnh */
img{
    width:120px;
    height:100px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #ffb6c1;
}

/* nút chung */
.action-btn{
    border:none;
    padding:7px 16px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:0.25s;
    margin:3px;
}

/* nút sửa */
.edit{
    background:#45d6a3;
    color:white;
}
.edit:hover{
    background:#2db58e;
}

/* nút xóa */
.delete{
    background:#ff7aa2;
    color:white;
}
.delete:hover{
    background:#ff4d88;
}

/* nút thêm mới */
.addBtn{
    display:block;
    width:180px;
    margin:25px auto;
    background:#ff4d88;
    color:white;
    text-align:center;
    padding:10px 0;
    border-radius:30px;
    text-decoration:none;
    font-size:15px;
    font-weight:bold;
}
.addBtn:hover{
    background:#e63873;
}
</style>
</head>

<body>

<h2>🌼 Quản lý các loài hoa</h2>

<table>
<tr>
    <th>Ảnh</th>
    <th>Tên hoa</th>
    <th>Mô tả</th>
    <th>Thao tác</th>
</tr>

<?php foreach($flowers as $i => $f): ?>
<tr>
    <td><img src="<?= $f['image']?>"></td>
    <td><?= $f['name']?></td>
    <td><?= $f['description']?></td>
    <td>
        <button class="action-btn edit" onclick="location.href='edit.php?id=<?= $i ?>'">✏ Sửa</button>
        <button class="action-btn delete" onclick="location.href='delete.php?id=<?= $i ?>'">🗑 Xóa</button>
    </td>
</tr>
<?php endforeach;?>
</table>

<a class="addBtn" href="add.php">➕ Thêm hoa mới</a>

</body>
</html>
