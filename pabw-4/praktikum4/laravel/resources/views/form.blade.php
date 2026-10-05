<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Mahasiswa</title>
</head>
<body>
    <h1>Form Input Mahasiswa</h1>
    <form action="/simpan" method="POST">
        @csrf
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        
        <label for="jurusan">Jurusan:</label>
        <input type="text" name="jurusan" id="jurusan" required><br><br>
        
        <label for="umur">Umur:</label>
        <input type="number" name="umur" id="umur" required><br><br>
        
        <button type="submit">Simpan</button>
    </form>
</body>
</html>