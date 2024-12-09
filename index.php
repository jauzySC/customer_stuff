<?php
require_once 'barang.php';
require_once 'BarangManager.php';

$barangmanager = new BarangManager();

//form tambah barang
if ($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST['tambah'])){
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    
    $barangmanager->tambahBarang($nama, $stok, $harga);
    header('Location: index.php');
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    $barangmanager->hapusbarang($id);
    header('Location: index.php');
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
     @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap');
body{
    font-family:"Lexend", sans-serif;
    background: #111;
    margin: 20px;
    color: white;
}
.container{
    max-width: 800px;
    margin: auto;
    background: #333;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0,0,10px rgba(0,0,0,0.1);
}
h1{
    text-align: center;
}
a{
    text-decoration: none;
    color: white;
}
.btn-delete{
    background-color: #000;
    padding: 10px 15px:
    border-radius: 5px;
}

</style>
<body>
    <div class="container">
<h1>
    Daftar Barang-Barang
</h1>
<h2>
    Berikut adalah daftar barang-barang yang ada di toko AkuJago
</h2>
<form action="" method="POST">
    <div>
        <label for="nama">Nama Barang</label><br>
       <input type="text" name="nama" id="nama" required>
    </div>
    <div>
        <label for="harga">Harga Barang</label><br>
       <input type="number" name="harga" id="harga" required>
    </div>
    <div>
        <label for="stok">Stok Barang</label><br>
       <input type="Number" name="stok" id="stok" required>
    </div>
    <br>
    <button type="submit" name="tambah" class="btn btn-add">tambahBarang</button>
</form>
<br>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($barangmanager->getBarang() as $barang): ?>
            <tr>
                <td><?=$barang['id'] ?></td>
                <td><?=$barang['nama'] ?></td>
                <td><?=$barang['harga'] ?></td>
                <td><?=$barang['stok'] ?></td>
                <td>
                    <a href="?hapus=<?= $barang['id']?>" class="btn btn-delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>
    </div>
   
</body>
</html>