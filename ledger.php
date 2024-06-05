<?php
require 'function.php';

$bank = query("SELECT * FROM bank ORDER BY id_bank DESC");

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
if (isset($_POST["submit"])) {
  if (tambah_akun_bank($_POST) > 0) {
      echo "
          <script>
              alert('Data berhasil ditambahkan!');
              document.location.href = 'ledger.php';
          </script>
      ";
  } else {
      echo "
      <script>
      alert('Data gagal ditambahkan!');
      document.location.href = 'ledger.php';
      </script>
      ";
  }
}

if( isset($_POST["cari"])){
    $bank = cari($_POST["keyword"]);
}
?>

<html>

<head>
    <title>Ledger</title>
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
                <li><a class="active" href="ledger.php" onclick="showLedger()">Ledger</a></li>
                <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
                <li><a href="inventory.php" onclick="showinventory()">Inventory</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <div class="bank">
            <table>
            <form action="" method="POST" onsubmit="return validateForm()">
              <tr>
                <td><label for="nama_akun">Nama Akun</label></td>
                <td><input type="text" name="nama_akun" id="nama_akun"></td>
              </tr>
              <tr>
                <td><label for="amount">Amount</label></td>
                <td><input type="text" name="amount" id="amount"></td>
              </tr>
              <tr>
                <td><button type="submit" name="submit">Buat Akun</button></td>
              </tr>
            </form>
            </table>
            </div>

            <div class="searchl">
            <table>
                <tr>
                <form action="" method="POST">
                    <td>Account Name</td>
                    <td><input type="text" name="keyword" placeholder="Cari Bank"></td>
                    <td><button type="submit" name="cari" class="simpan">Cari</button></td>
                    </form>
                </tr>
            </table>
            </div>

            <table border="1" cellspacing="0" cellpadding="9px">
                <tr>
                    <th>Nama Bank</th>
                    <th>DATE</th>
                    <th>PARTICULARS</th>
                    <th>VCH NO</th>
                    <th>VCH TYPE</th>
                    <th>DEBIT</th>
                    <th>CREDIT</th>
                    <th>RUNNING BALANCE</th>
                    <th>EDIT</th>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($bank as $row): ?>
                    <tr>
                        <td><?php echo $row["nama_bank"]; ?></td>
                        <td><?php echo $row["tanggal"]; ?></td>
                        <td><?php echo $row["particulars"]; ?></td>
                        <td><?php echo $row["vch_no"]; ?></td>
                        <td><?php echo $row["vch_type"]; ?></td>
                        <td><?php echo $row["debit"]; ?></td>
                        <td><?php echo $row["credit"]; ?></td>
                        <td><?php echo $row["balance"]; ?></td>
                        <td>
                            <a href="update.php?id=<?= $row["id_bank"];?>">Ubah</a>
                            <a href="delete.php?id=<?= $row["id_bank"];?>">| Hapus</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script src="project.js"></script>
    <script>
  function validateForm() {
    var namaAkun = document.getElementById("nama_akun").value;
    var amount = document.getElementById("amount").value;

    // Validasi Nama Akun (tidak boleh kosong)
    if (namaAkun === "") {
      alert("Nama Akun harus diisi");
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
</body>

</html>
