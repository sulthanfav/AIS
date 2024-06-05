<?php
    require 'function.php';

    $id_bank = $_GET["id"];
    $bank = query("SELECT * FROM bank WHERE id_bank = $id_bank")[0];
    if( isset($_POST["submit"]) ) {
        if( update($_POST) > 0){
            echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'ledger.php';
                </script>
            ";
        } else {
            echo "
            <script>
            alert('Data gagal diubah!');
            document.location.href = 'ledger.php';
            </script>
            ";
        }

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
        <div class="update">
            <form action="" method="POST">
                <input type= "hidden" name="id_bank" value="<?= $bank["id_bank"]; ?>" autocomplete="off">

                <label for="nama_bank">Nama Bank</label>
                <input type="text" name="nama_bank" id="nama_bank" required value="<?= $bank["nama_bank"]; ?> ">
                
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" required value="<?= $bank["tanggal"]; ?> ">

                <label for="particurlars">Particurlars</label>
                <input type="text" name="particulars" id="particulars" required value="<?= $bank["particulars"]; ?> ">
                
                <label for="vch_no">VCH No</label>
                <input type="text" name="vch_no" id="vch_no" required value="<?= $bank["vch_no"]; ?> ">
                
                <label for="vch_type">VCH Type</label>
                <input type="text" name="vch_type" id="vch_type" required value="<?= $bank["vch_type"]; ?> ">
                
                <label for="debit">Debit</label>
                <input type="text" name="debit" id="debit" required value="<?= $bank["debit"]; ?> ">
                
                <label for="credit">credit</label>
                <input type="text" name="credit" id="credit" required value="<?= $bank["credit"]; ?> ">
                
                <label for="balance">balance</label>
                <input type="balance" name="balance" id="balance" required value="<?= $bank["balance"]; ?> ">
                
                <button type="submit" name="submit">Ubah Data</button>
            </form>
            </div>
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
