@extends('layouts.app')

@section('content')
    <h2>Danh sách Sinh viên</h2>

    <!-- Form Thêm Sinh Viên -->
    <form action="{{ route('sinhvien.store') }}" method="POST">
        @csrf
        <div>
            <label for="ten_sinh_vien">Tên Sinh Viên:</label>
            <input type="text" id="ten_sinh_vien" name="ten_sinh_vien" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Thêm Sinh Viên</button>
    </form>

    <hr>

    <!-- Bảng Danh Sách Sinh Viên -->
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sinh Viên</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($danhSachSV as $sv)
                <tr>
                    <td>{{ $sv->id }}</td>
                    <td>{{ $sv->ten_sinh_vien }}</td>
                    <td>{{ $sv->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection