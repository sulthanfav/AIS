<?php
require 'function.php';

$income = query("SELECT * FROM income ORDER BY income_id DESC");
$query_bank = "SELECT * FROM bank";
$result_bank = mysqli_query($conn, $query_bank);
$query_akun_bank = "SELECT * FROM akun_bank";
$result_akun_bank = mysqli_query($conn, $query_akun_bank);
if (isset($_POST["submit"])) {
    if (income($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'income.php';
            </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal ditambahkan!');
        document.location.href = 'income.php';
        </script>
        ";
    }
}

?>

<html>

<head>
    <title>Income</title>
    <link rel="website icon" type="jpg" href="logo.jpg">
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
                <li><a class="active" href="income.php" onclick="showIncome()">Income</a></li>
                <li><a href="Sales.php" onclick="showSales()">Sales</a></li>
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
            <form action="" method="POST" onsubmit="return validateForm()">
                    <tr>
                        <td>Kode Income</td>
                        <td><input type="text" name="kode_income"></td>
                    </tr>
                    <tr>
                        <td>Income Account</td>
                        <td><input type="text" name="income_akun"></td>
                    </tr>
                    <tr>
                        <td>Voucher Date</td>
                        <td><input type="date" name="income_date"></td>
                    </tr>

                    <tr>
                        <td><label for="total_income">Amount</label></td>
                        <td><input type="text" name="total_income"></td>
                    </tr>
                    <tr>
                        <td>item</td>
                        <td>
                            <select name="payment_income" required>
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
                    <?php foreach ($income as $row) : ?>
                        <tr>
                            <td><?php echo $row["income_date"]; ?></td>
                            <td><?php echo $row["kode_income"]; ?></td>
                            <td><?php echo $row["income_akun"]; ?></td>
                            <td><?php echo $row["total_income"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <table>
        </div>
    </div>
    <script src="project.js"></script>
    <script>
  function validateForm() {
    var kodeIncome = document.forms[0]["kode_income"].value;
    var incomeAccount = document.forms[0]["income_akun"].value;
    var incomeDate = document.forms[0]["income_date"].value;
    var totalIncome = document.forms[0]["total_income"].value;
    var paymentIncome = document.forms[0]["payment_income"].value;
    var narration = document.forms[0]["narasi"].value;

    // Validasi Kode Income (tidak boleh kosong)
    if (kodeIncome === "") {
      alert("Kode Income harus diisi");
      return false;
    }

    // Validasi Income Account (tidak boleh kosong)
    if (incomeAccount === "") {
      alert("Income Account harus diisi");
      return false;
    }

    // Validasi Voucher Date (tidak boleh kosong)
    if (incomeDate === "") {
      alert("Voucher Date harus diisi");
      return false;
    }

    // Validasi Amount (harus diisi dengan angka positif)
    if (totalIncome === "" || isNaN(totalIncome) || parseFloat(totalIncome) <= 0) {
      alert("Amount harus diisi dengan angka positif");
      return false;
    }

    // Validasi Item (tidak boleh dipilih default)
    if (paymentIncome === "-") {
      alert("Pilih Item");
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
