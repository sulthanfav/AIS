<?php
require 'function.php';

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

$query_akun_bank = "SELECT * FROM akun_bank";
$result_akun_bank = mysqli_query($conn, $query_akun_bank);

$label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
for($bulan = 1;$bulan < 13;$bulan++)
{
	$query = mysqli_query($conn,"SELECT sum(stock) as jumlah from sales where MONTH(sales_date)='$bulan'");
	$row = $query->fetch_array();
	$jumlah_produk[] = $row['jumlah'];
}

?>

<html>

<head>
    <title>Accounting Information System</title>
    <link rel="icon" type="image/jpeg" href="logo.jpg">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="chart.js"></script>
</head>

<body>
    <div class="container">
        <nav>
            <center><img src="logo.jpg" alt="logo skuybor" style="width:40%;padding-top:1rem;">
                <b><p>Skuybor Accounting Information System</p></b>
            </center>
            <hr>
            <ul>
                <li><a class="active" href="index.php" onclick="showIndex()">Dashboard</a></li>
                <li><a href="expense.php" onclick="showExpense()">Expense</a></li>
                <li><a href="income.php" onclick="showIncome()">Income</a></li>
                <li><a href="Sales.php" onclick="showSales()">Sales</a></li>
                <li><a href="purchase.php" onclick="showPurchase()">Purchase</a></li>
                <li><a href="ledger.php" onclick="showLedger()">Ledger</a></li>
                <li><a href="profitloss.php" onclick="showProfitLoss()">Profit & Loss</a></li>
                <li><a href="inventory.php" onclick="showinventory()">Inventory</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

    <div id="dashboard">
        <div class="dashboard-widget">
            <h2 class="widget-title">Saldo Bank</h2>
            <div class="widget-content">
                <?php
                if (mysqli_num_rows($result_akun_bank) > 0) {
                    // Mencetak data
                    while ($row = mysqli_fetch_assoc($result_akun_bank)) {
                        echo '<div class="akun_bank">';
                        echo "<p>" . $row["nama_akun_bank"] . "</p>";
                        echo number_format($row["amount"], 2, ',', '.');
                        echo "</div>";
                    }
                } else {
                    echo "Tidak ada data yang ditemukan.";
                }
                ?>
            </div>
        </div>
        
        <div class="dashboard-widget">
            <h2 class="widget-title">Grafik Penjualan Bulanan</h2>
            <div class="widget-content">
            <div style="width: 800px;margin: 0px auto;">
		<canvas id="myChart"></canvas>
	</div>
            </div>
            </div>
    </div>    
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'Grafik Penjualan',
					data: <?php echo json_encode($jumlah_produk); ?>,
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>

</html>
