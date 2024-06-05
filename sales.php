<?php
require 'function.php';

$sales = query("SELECT * FROM sales ORDER BY id_sales DESC");
$query_inventory = "SELECT * FROM inventory";
$result_inventory = mysqli_query($conn, $query_inventory);
$query_akun_bank = "SELECT * FROM akun_bank";
$result_akun_bank = mysqli_query($conn, $query_akun_bank);
if (!isset($_SESSION['username'])) {
  header("location: login.php");
  exit;
}

if (isset($_POST["submit"])) {
  if (tambah_sales($_POST) > 0) {
    echo "
        <script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'sales.php';
        </script>
    ";
  } else {
    echo "
        <script>
            alert('Data gagal ditambahkan!');
            document.location.href = 'sales.php';
        </script>
    ";
  }
}
?>
<html>

<head>
  <title>Sales</title>
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
        <li><a class="active" href="Sales.php" onclick="showSales()">Sales</a></li>
        <li><a href="purchase.php" onclick="showPurchase()">Purchase</a></li>
        <li><a href="ledger.php" onclick="showLedger()">Ledger</a></li>
        <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
        <li><a href="inventory.php" onclick="showinventory()">Inventory</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>

    <div id="content">
      <div class="form">
      <table>
      <form action="" method="POST" name="myForm" onsubmit="return validateForm()">
          <tr>
            <td>Invoice No</td>
            <td><input type="text" name="kode_sales"></td>
          </tr>
          <tr>
            <td>Voucher Date</td>
            <td><input type="date" name="sales_date"></td>
          </tr>
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
            <td><label for="stock">Stock</label></td>
            <td><input type="text" name="stock"></td>
          </tr>
          <tr>
            <td><label for="ongkir">Ongkir</label></td>
            <td><input type="text" name="ongkir"></td>
          </tr>
          <tr>
            <td><label for="total_sales">Total Sales</label></td>
            <td><input type="text" name="total_sales"></td>
          </tr>
          <tr>
            <td><label for="narration">Narration</label></td>
            <td><textarea id="narration" name="narasi" rows="6" cols="50"></textarea></td>
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
            <th>Kode</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Stock</th>
            <th>Total Sales</th>
          </tr>
          <?php foreach ($sales as $row): ?>
          <tr>
            <td><?php echo $row["kode_sales"]; ?></td>
            <td><?php echo $row["sales_date"]; ?></td>
            <td><?php echo $row["nama_barang"]; ?></td>
            <td><?php echo $row["stock"]; ?></td>
            <td><?php echo $row["total_sales"]; ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</body>
<script>
  function validateForm() {
    // Mendapatkan nilai input dari form
    var kode_sales = document.forms["myForm"]["kode_sales"].value;
    var sales_date = document.forms["myForm"]["sales_date"].value;
    var nama_bank = document.forms["myForm"]["nama_bank"].value;
    var nama_barang = document.forms["myForm"]["nama_barang"].value;
    var stock = document.forms["myForm"]["stock"].value;
    var ongkir = document.forms["myForm"]["ongkir"].value;
    var total_sales = document.forms["myForm"]["total_sales"].value;
    var narasi = document.forms["myForm"]["narasi"].value;

    // Validasi setiap input
    if (kode_sales == "") {
      alert("Invoice No harus diisi");
      return false;
    }

    if (sales_date == "") {
      alert("Voucher Date harus diisi");
      return false;
    }

    if (nama_bank == "-") {
      alert("Supplier/Cash harus dipilih");
      return false;
    }

    if (nama_barang == "") {
      alert("Item harus dipilih");
      return false;
    }

    if (stock == "") {
      alert("Stock harus diisi");
      return false;
    }

    if (ongkir == "") {
      alert("Ongkir harus diisi");
      return false;
    }

    if (total_sales == "") {
      alert("Total Sales harus diisi");
      return false;
    }

    if (narasi == "") {
      alert("Narration harus diisi");
      return false;
    }
  }
</script>

</html>
