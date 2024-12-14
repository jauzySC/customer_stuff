<?php
include_once 'barang.php';
include_once 'BarangManager.php';
include_once 'customer.php';
include_once 'CustomerManager.php';

$barangManager = new BarangManager();
$customerManager = new CustomerManager();

// Handle form submission for adding barang and customer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    // Get barang data
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Get customer data
    $customer_name = $_POST['customer_name'];
    $customer_no = $_POST['customer_no'];

    // Check if the customer already exists
    $existingCustomer = $customerManager->getCustomerByName($customer_name);

    if ($existingCustomer) {
        // If the customer exists, use their ID
        $customer_id = $existingCustomer['id'];
    } else {
        // If the customer does not exist, add them and get the new customer ID
        $customer_id = $customerManager->tambahCustomer($customer_name, $customer_no); // Pass the phone number
    }

    // Now add the barang with the customer_id
    $barangManager->tambahBarang($nama, $harga, $stok, $customer_id);
    header('Location: index.php');
    exit; // Always exit after a header redirect
}

// Handle deletion of barang
if (isset($_GET['hapus_barang'])) {
    $id = $_GET['hapus_barang'];
    $barangManager->hapusBarang($id);
    header('Location: index.php');
    exit;
}

// Handle deletion of customer
if (isset($_GET['hapus_customer'])) {
    $id = $_GET['hapus_customer'];
    $customerManager->hapusCustomer($id);
    header('Location: index.php');
    exit;
}

// Fetch all barang and customers
$barangs = $barangManager->getBarang();
$customers = $customerManager->getCustomer();

// Create an associative array for customers for easy lookup
$customerMap = [];
foreach ($customers as $customer) {
    $customerMap[$customer['id']] = $customer; // Assuming 'id' is the key for customer
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Barang</title>
    <style>
        body {
            background-color: black;
            color: white;
            margin: 20px;
        }
        .container{
            max-width: 800px;
            margin: auto;
            background: #222;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(225,225,225,1);
        }
        input{
            background: #222;
            color: white;
        }
        table{
            width:100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td{
            border: 1px solid #111;
        }
        th, td{
            padding: 8px;
            text-align: center;
        }
        .btn{
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .btn-add{
            color: #000;
        }
        .btn-add:active{
            font-weight: bold;
        }
        .btn-delete{
            color: white;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <h2>Tambah Barang</h2>
    <div>
        <label for="nama">Nama Barang</label> <br>
        <input type="text" name="nama" id="nama" required> 
    </div>
    <div>
        <label for="harga">Harga</label> <br>
        <input type="number" name="harga" id="harga" required>
    </div>
    <div>
        <label for="stok">Stok</label> <br>
        <input type="number" name="stok" id="stok" required>
    </div>
    
    <h2>Tambah Customer</h2>
    <div>
        <label for="customer_name">Nama Customer</label> <br>
        <input type="text" name="customer_name" id="customer_name" required>
    </div>
    <div>
        <label for="customer_no">No Telepon Customer</label> <br>
        <input type="text" name="customer_no" id="customer_no" required>
    </div>
    
    <button type="submit" name="tambah" class="btn btn-add">Tambah Barang dan Customer</button>
</form>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Nama Customer</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($barangs as $barang): ?>
        <tr>
            <td><?= htmlspecialchars($barang['id']); ?></td>
            <td><?= htmlspecialchars($barang['nama']); ?></td>
            <td><?= htmlspecialchars($barang['harga']); ?></td>
            <td><?= htmlspecialchars($barang['stok']); ?></td>
            <td>
                <?php 
                // Check if 'customer_id' exists in the barang array
                if (isset($barang['customer_id'])) {
                    // Get the customer associated with this barang
                    $customer = isset($customerMap[$barang['customer_id']]) ? $customerMap[$barang['customer_id']] : null;
                    echo $customer ? htmlspecialchars($customer['nama']) : 'No Customer';
                } else {
                    echo 'No Customer'; // If 'customer_id' is not set
                }
                ?>
            </td>
            <td>
                <?php 
                // Display the phone number if the customer exists
                if (isset($barang['customer_id'])) {
                    $customer = isset($customerMap[$barang['customer_id']]) ? $customerMap[$barang['customer_id']] : null;
                    echo $customer ? htmlspecialchars($customer['no']) : 'No Phone Number';
                } else {
                    echo 'No Phone Number'; // If 'customer_id' is not set
                }
                ?>
            </td>
            <td>
                <a href="?hapus_barang=<?= htmlspecialchars($barang['id']) ?>" class="btn btn-delete">Hapus Barang</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Daftar Customer</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Customer</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($customers as $customer): ?>
        <tr>
            <td><?= htmlspecialchars($customer['id']); ?></td>
            <td><?= htmlspecialchars($customer['nama']); ?></td>
            <td><?= htmlspecialchars($customer['no']); ?></td>
            <td>
                <a href="?hapus_customer=<?= htmlspecialchars($customer['id']) ?>" class="btn btn-delete">Hapus Customer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    </div>
</body>
</html>