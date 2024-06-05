<?php
require 'function.php';

$expense = query("SELECT * FROM expense ORDER BY expense_id DESC");
$query_bank = "SELECT * FROM bank";
$result_bank = mysqli_query($conn, $query_bank);
$query_akun_bank = "SELECT * FROM akun_bank";
$result_akun_bank = mysqli_query($conn, $query_akun_bank);
if (isset($_POST["submit"])) {
    if (expense($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'expense.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan!');
            document.location.href = 'expense.php';
        </script>
        ";
    }
}
?>

<html>
<head>
    <title>Expense</title>
    <link rel="icon" type="image/jpg" href="logo.jpg">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <nav>
            <center>
                <img src="logo.jpg" alt="logo skuybor" style="width: 40%; padding-top: 1rem;">
                <b><p>Skuybor Accounting Information System</p></b>
            </center>
            <hr>
            <ul>
                <li><a href="index.php" onclick="showIndex()">Dashboard</a></li>
                <li><a class="active" href="expense.php" onclick="showExpense()">Expense</a></li>
                <li><a href="income.php" onclick="showIncome()">Income</a></li>
                <li><a href="Sales.php" onclick="showSales()">Sales</a></li>
                <li><a href="purchase.php" onclick="showPurchase()">Purchase</a></li>
                <li><a href="ledger.php" onclick="showLedger()">Ledger</a></li>
                <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
                <li><a href="inventory.php" onclick="showInventory()">Inventory</a></li>
                <li><a href="logout.php" onclick="showLogout()">Logout</a></li>
            </ul>
        </nav>

        <div id="content">
            <div class="form">
            <table>
            <form action="" method="POST" onsubmit="return validateForm()">
                    <tr>
                        <td>Kode Expense</td>
                        <td><input type="text" name="kode_expense"></td>
                    </tr>
                    <tr>
                        <td>Expense Account</td>
                        <td><input type="text" name="expense_akun"></td>
                    </tr>
                    <tr>
                        <td>Voucher Date</td>
                        <td><input type="date" name="expense_date"></td>
                    </tr>
                    <tr>
                        <td><label for="total_expense">Amount</label></td>
                        <td><input type="text" name="total_expense" id="total_expense"></td>
                    </tr>
                    <tr>
                        <td>Bank Account</td>
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
                        <td><label for="Narration">Narration</label></td>
                        <td><textarea id="Narration" name="narasi" rows="6" cols="50"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" name="submit" class="simpan">Simpan</button></td>
                    </tr>
                </form>
            </table>
            </div>
            <div class="box-table">
                <table border="1" cellspacing="0" cellpadding="9px" width="100%">
                    <tr>
                        <th>Date</th>
                        <th>Kode Entries</th>
                        <th>Account</th>
                        <th>Amount</th>
                    </tr>
                    <?php foreach ($expense as $row): ?>
                        <tr>
                            <td><?php echo $row["expense_date"]; ?></td>
                            <td><?php echo $row["kode_expense"]; ?></td>
                            <td><?php echo $row["expense_akun"]; ?></td>
                            <td><?php echo $row["total_expense"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="project.js"></script>
    <script>
  function validateForm() {
    var kodeExpense = document.forms[0]["kode_expense"].value;
    var expenseAccount = document.forms[0]["expense_akun"].value;
    var expenseDate = document.forms[0]["expense_date"].value;
    var totalExpense = document.forms[0]["total_expense"].value;
    var namaBank = document.forms[0]["nama_bank"].value;
    var narration = document.forms[0]["narasi"].value;

    // Validasi Kode Expense (tidak boleh kosong)
    if (kodeExpense === "") {
      alert("Kode Expense harus diisi");
      return false;
    }

    // Validasi Expense Account (tidak boleh kosong)
    if (expenseAccount === "") {
      alert("Expense Account harus diisi");
      return false;
    }

    // Validasi Voucher Date (tidak boleh kosong)
    if (expenseDate === "") {
      alert("Voucher Date harus diisi");
      return false;
    }

    // Validasi Amount (harus angka positif)
    if (totalExpense === "" || isNaN(totalExpense) || parseFloat(totalExpense) <= 0) {
      alert("Amount harus diisi dengan angka positif");
      return false;
    }

    // Validasi Bank Account (tidak boleh dipilih default)
    if (namaBank === "-") {
      alert("Pilih Bank Account");
      return false;
    }

    // Validasi Narration (tidak boleh kosong)
    if (narration === "") {
      alert("Narration harus diisi");
      return false;
    }

    // Jika semua validasi berhasil, form dapat disubmit
    return true;
  }
</script>

</body>
</html>