<?php
require 'function.php';

$purchase = query("SELECT * FROM purchase ORDER BY purchase_id DESC");
$query_inventory = "SELECT * FROM inventory";
$result_inventory = mysqli_query($conn, $query_inventory);
$query_akun_bank = "SELECT * FROM akun_bank";
$result_akun_bank = mysqli_query($conn, $query_akun_bank);
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

if (isset($_POST["submit"])) {
    if (tambah_purchase($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'purchase.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'purchase.php';
            </script>
        ";
    }
}
?>
<html>

<head>
    <title>Purchase</title>
    <link rel="icon" type="image/jpeg" href="logo.jpg">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <nav>
            <center>
                <img src="logo.jpg" alt="logo skuybor" style="width:40%;padding-top:1rem;">
                <b>
                    <p>Skuybor Accounting Information System</p>
                </b>
            </center>
            <hr>
            <ul>
                <li><a href="index.php" onclick="showIndex()">Dashboard</a></li>
                <li><a href="expense.php" onclick="showExpense()">Expense</a></li>
                <li><a href="income.php" onclick="showIncome()">Income</a></li>
                <li><a href="Sales.php" onclick="showSales()">Sales</a></li>
                <li><a class="active" href="purchase.php" onclick="showPurchase()">Purchase</a></li>
                <li><a href="ledger.php" onclick="showLedger()">Ledger</a></li>
                <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
                <li><a href="inventory.php" onclick="showinventory()">Inventory</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <div class="form">
            <table>
            <form action="" method="POST" onsubmit="return validateForm()">
                    <tr>
                        <td>Purchase No</td>
                        <td><input type="text" name="kode_purchase"></td>
                    </tr>
                    <tr>
                        <td>Voucher Date</td>
                        <td><input type="date" name="purchase_date"></td>
                    </tr>
                    <!-- bank -->
                    <tr>
                        <td>Supplier/Cash</td>
                        <td>
            <select name="nama_bank" required>
                <option value="-" selected>Pilih Bank</option>
            <?php
                while ($row = mysqli_fetch_assoc($result_akun_bank)) {
                    echo "<option value='" . $row['nama_akun_bank'] . "'>" . $row['nama_akun_bank'] . "</option>";
                }
                ?>
            </select>
            </td>
                    </tr>
                    <tr>
                        <td>Item</td>
                        <td>
                            <select name="nama_barang" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_inventory)) {
                                    echo "<option value='" . $row['nama_barang'] . "'>" . $row['nama_barang'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Stock</td>
                        <td><input type="text" name="stock"></td>
                    </tr>
                    <tr>
                        <td><label for="Narration">Narration</label></td>
                        <td><textarea id="Narration" name="narasi" rows="6" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="amount">Amount</label></td>
                        <td><input type="text" name="amount"></td>
                    </tr>
                    <tr class="btn">
                        <td></td>
                        <td><button type="submit" name="submit" class="simpan">Tambah Data</button></td>
                    </tr>
                </form>
            </table>
            </div>
            <div class="box-table">
                <table border="1" cellspacing="0" cellpadding="3px">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($purchase as $row): ?>
                        <tr>
                            <td><?php echo $row["kode_purchase"]; ?></td>
                            <td><?php echo $row["purchase_date"]; ?></td>
                            <td><?php echo $row["nama_barang"]; ?></td>
                            <td><?php echo $row["stock"]; ?></td>
                            <td><?php echo $row["amount"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="project.js"></script>
<script>
  function validateForm() {
    var purchaseNo = document.forms[0]["kode_purchase"].value;
    var purchaseDate = document.forms[0]["purchase_date"].value;
    var supplierCash = document.forms[0]["nama_bank"].value;
    var item = document.forms[0]["nama_barang"].value;
    var stock = document.forms[0]["stock"].value;
    var narration = document.forms[0]["narasi"].value;
    var amount = document.forms[0]["amount"].value;

    // Validasi Purchase No (tidak boleh kosong)
    if (purchaseNo === "") {
      alert("Purchase No harus diisi");
      return false;
    }

    // Validasi Voucher Date (tidak boleh kosong)
    if (purchaseDate === "") {
      alert("Voucher Date harus diisi");
      return false;
    }

    // Validasi Supplier/Cash (tidak boleh dipilih default)
    if (supplierCash === "-") {
      alert("Pilih Supplier/Cash");
      return false;
    }

    // Validasi Item (tidak boleh dipilih default)
    if (item === "-") {
      alert("Pilih Item");
      return false;
    }

    // Validasi Stock (harus diisi dengan angka positif)
    if (stock === "" || isNaN(stock) || parseInt(stock) <= 0) {
      alert("Stock harus diisi dengan angka positif");
      return false;
    }

    // Validasi Narration (tidak boleh kosong)
    if (narration === "") {
      alert("Narration harus diisi");
      return false;
    }

    // Validasi Amount (harus diisi dengan angka positif)
    if (amount === "" || isNaN(amount) || parseFloat(amount) <= 0) {
      alert("Amount harus diisi dengan angka positif");
      return false;
    }

    // Jika semua validasi berhasil, form dapat disubmit
    return true;
  }
</script>
</html>
