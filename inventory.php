<?php
require 'function.php';

$inventory = query("SELECT * FROM inventory ORDER BY barang_id DESC");

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

if (isset($_POST["submit"])) {
    if (tambah_inventory($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'inventory.php';
            </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal ditambahkan!');
        document.location.href = 'inventory.php';
        </script>
        ";
    }
}
?>

<html>

<head>
    <title>Inventory</title>
    <link rel="icon" type="image/jpeg" href="logo.jpg">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <nav>
            <center><img src="logo.jpg" alt="logo skuybor" style="width:40%;padding-top:1rem;">
                <b><p>Skuybor Accounting Information System</p></b>
            </center>
            <hr>
            <ul>
                <li><a href="index.php" onclick="showIndex()">Dashboard</a></li>
                <li><a href="expense.php" onclick="showExpense()">Expense</a></li>
                <li><a href="income.php" onclick="showIncome()">Income</a></li>
                <li><a href="Sales.php" onclick="showSales()">Sales</a></li>
                <li><a href="purchase.php" onclick="showPurchase()">Purchase</a></li>
                <li><a href="ledger.php" onclick="showLedger()">Ledger</a></li>
                <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
                <li><a class="active" href="inventory.php" onclick="showinventory()">Inventory</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <div class="form">
            <table>
            <form action="" method="POST" onsubmit="return validateForm()">
                    <tr>
                        <td>Nama Barang</td>
                        <td><input type="text" name="nama_barang"></td>
                    </tr>

                    <tr>
                        <td>Stock</td>
                        <td><input type="text" name="stock"></td>
                    </tr>

                    <tr>
                        <td>Voucher Date</td>
                        <td><input type="date" name="tenggat"></td>
                    </tr>

                    <tr>
                        <td><label for="cogs">Cogs</label></td>
                        <td><input type="text" name="cogs"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><button type="submit" name="submit" class="simpan">Tambah Data</button></td>
                    </tr>
                </form>
            </table>
            </div>

            <div class="box-table">
                <table border="1" cellspacing="0" cellpadding="3px">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                        <th>Tenggat</th>
                        <th>Cogs</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach ($inventory as $row): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $row["nama_barang"]; ?></td>
                            <td><?php echo $row["stock"]; ?></td>
                            <td><?php echo $row["tenggat"]; ?></td>
                            <td><?php echo $row["cogs"]; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="project.js"></script>
    <script>
  function validateForm() {
    // Mendapatkan nilai input
    var namaBarang = document.forms[0]["nama_barang"].value;
    var stock = document.forms[0]["stock"].value;
    var tenggat = document.forms[0]["tenggat"].value;
    var cogs = document.forms[0]["cogs"].value;

    // Validasi Nama Barang (tidak boleh kosong)
    if (namaBarang === "") {
      alert("Nama Barang harus diisi");
      return false;
    }

    // Validasi Stock (harus angka positif)
    if (stock === "" || isNaN(stock) || parseInt(stock) <= 0) {
      alert("Stock harus diisi dengan angka positif");
      return false;
    }

    // Validasi Voucher Date (tidak boleh kosong)
    if (tenggat === "") {
      alert("Voucher Date harus diisi");
      return false;
    }

    // Validasi Cogs (harus angka positif)
    if (cogs === "" || isNaN(cogs) || parseFloat(cogs) <= 0) {
      alert("Cogs harus diisi dengan angka positif");
      return false;
    }

    // Jika semua validasi berhasil, form dapat disubmit
    return true;
  }
</script>
</body>

</html>
