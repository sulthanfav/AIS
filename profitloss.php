<?php
  require 'function.php';
?>

<html>
<head>
  <title>Accounting Information System</title>
  <link rel="website icon" type="jpg"  href="logo.jpg">
  <link rel= "stylesheet" type="text/css" href="style.css">
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
        <li><a class="active" href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
        <li><a href="inventory.php" onclick="showinventory()">Inventory</a></li>
        <li><a href="logout.php" onclick="showinventory()">Logout</a></li>
      </ul>
    </nav>

    <div id="content">
    <table border="1" cellspacing="0" cellpadding="9px">
    <tr>
      <th>PARTICULARS</TH>
      <th>DEBIT</th>
      <th>CREDIT</th>
    </tr>
      <tr>
        <td>Sales</td>
        <td><?php $sql = "SELECT SUM(total_sales) AS debit_sales FROM sales";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total_sales = $row["debit_sales"];
                    echo $total_sales;
                } else {
                    echo "Tidak ada hasil yang ditemukan.";
                }?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>Income</td>
        <td><?php $sql = "SELECT SUM(total_income) AS debit_income FROM income";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total_income = $row["debit_income"];
                    echo $total_income;
                } else {
                    echo "Tidak ada hasil yang ditemukan.";
                }?>
        </td>
        <td></td>
      </tr>
      <tr>
        <td>Income</td>
        <td></td>
        <td><?php $sql = "SELECT SUM(total_expense) AS kredit_expense FROM expense";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total_expense = $row["kredit_expense"];
                    echo $total_expense;
                } else {
                    echo "Tidak ada hasil yang ditemukan.";
                }?>
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold;">Net Profit/Loss</td>
        <td colspan="2" style="font-weight: bold;">
          <?php
          $net = ($total_income + $total_sales) - $total_expense;
          $nett = 11.56;
          echo number_format($net, 2, ',', '.');
          ?>
        </td>
      </tr>
    </table>

    </div>
  </div>
  <script src="project.js"></script>
</body>
</html>