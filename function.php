<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "projek") or die("Connect failed: " . $conn->error);

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah_purchase($data)
{
    global $conn;
    $kode_purchase = htmlspecialchars($data["kode_purchase"]);
    $purchase_date = htmlspecialchars($data["purchase_date"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $amount = htmlspecialchars($data["amount"]);
    $narasi = htmlspecialchars($data["narasi"]);
    $stock = htmlspecialchars($data["stock"]);
    $nama_bank = htmlspecialchars($data["nama_bank"]);

    $balance_query = "SELECT amount FROM akun_bank WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $result = mysqli_query($conn, $balance_query);
    $row = mysqli_fetch_assoc($result);

    $balance = $row['amount'];

    $total_balance = intval($balance) - intval($amount);

    $query1 = "INSERT INTO purchase VALUES
    ('', '$kode_purchase', '$purchase_date', '$nama_barang', '$stock', '$amount', '$narasi')";

    $query2 = "UPDATE inventory SET stock = stock + $stock WHERE nama_barang LIKE '%$nama_barang%'";

    $query3 = "INSERT INTO bank VALUES
    ('', '$nama_bank','$purchase_date' ,'purchase', '$kode_purchase','purchase', '-', '$amount', '$total_balance')";

    $query4 = "UPDATE akun_bank SET amount = $total_balance WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $query = $query1 . "; " . $query2 . "; " . $query3 . "; " . $query4;

    mysqli_multi_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_sales($data)
{
    global $conn;
    $kode_sales = htmlspecialchars($data["kode_sales"]);
    $sales_date = htmlspecialchars($data["sales_date"]);
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $stock = htmlspecialchars($data["stock"]);
    $ongkir = htmlspecialchars($data["ongkir"]);
    $total_sales = htmlspecialchars($data["total_sales"]);
    $narasi = htmlspecialchars($data["narasi"]);
    $nama_bank = htmlspecialchars($data["nama_bank"]);

    $balance_query = "SELECT amount FROM akun_bank WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $result = mysqli_query($conn, $balance_query);
    $row = mysqli_fetch_assoc($result);

    $balance = $row['amount'];

    $total_balance = intval($balance) + intval($total_sales);

    $query1 = "INSERT INTO sales VALUES
    ('', '$kode_sales', '$sales_date','$nama_barang', '$stock', '$ongkir', '$total_sales', '$narasi')";

    $query2 = "UPDATE inventory SET stock = stock - $stock WHERE nama_barang LIKE '%$nama_barang%'";

    $query3 = "INSERT INTO bank VALUES
    ('', '$nama_bank','$sales_date' ,'sales', '$kode_sales','sales', '$total_sales', '-', '$total_balance')";

    $query4 = "UPDATE akun_bank SET amount = $total_balance WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $query = $query1 . "; " . $query2 . "; " . $query3 . "; " . $query4;

    mysqli_multi_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_inventory($data)
{
    global $conn;
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $stock = htmlspecialchars($data["stock"]);
    $tenggat = htmlspecialchars($data["tenggat"]);
    $cogs = htmlspecialchars($data["cogs"]);

    $query = "INSERT INTO inventory VALUES
    ('', '$nama_barang', '$stock', '$tenggat', '$cogs')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_akun($data)
{
    global $conn;
    $username = htmlspecialchars($data["username"]);
    $email = htmlspecialchars($data["email"]);
    $password = htmlspecialchars($data["password"]);

    $query = "INSERT INTO akun VALUES
    ('', '$username', '$email', '$password')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function expense($data)
{
    global $conn;
    $kode_expense = htmlspecialchars($data["kode_expense"]);
    $expense_akun = htmlspecialchars($data["expense_akun"]);
    $expense_date = htmlspecialchars($data["expense_date"]);
    $nama_bank = htmlspecialchars($data["nama_bank"]);
    $total_expense = htmlspecialchars($data["total_expense"]);
    $narasi = htmlspecialchars($data["narasi"]);

    $balance_query = "SELECT amount FROM akun_bank WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $result = mysqli_query($conn, $balance_query);
    $row = mysqli_fetch_assoc($result);

    $balance = $row['amount'];

    $total_balance = intval($balance) - intval($total_expense);

    $query1 = "INSERT INTO expense VALUES
    ('', '$kode_expense', '$expense_akun', '$expense_date','$nama_bank', '$total_expense', '$narasi')";

    $query2 = "INSERT INTO bank VALUES
    ('', '$nama_bank','$expense_date' ,'$expense_akun', '$kode_expense','expense', '-', '$total_expense', '$total_balance')";

    $query3 = "UPDATE akun_bank SET amount = $total_balance WHERE nama_akun_bank LIKE '%$nama_bank%'";

    $query = $query1 . "; " . $query2 . "; " . $query3;

    mysqli_multi_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function income($data){
    global $conn;
    $kode_income = htmlspecialchars($data["kode_income"]);
    $income_akun = htmlspecialchars($data["income_akun"]);
    $income_date = htmlspecialchars($data["income_date"]);
    $payment_income = htmlspecialchars($data["payment_income"]);
    $total_income = htmlspecialchars($data["total_income"]);
    $narasi = htmlspecialchars($data["narasi"]);

    $balance_query = "SELECT amount FROM akun_bank WHERE nama_akun_bank LIKE '%$payment_income%'";

    $result = mysqli_query($conn, $balance_query);
    $row = mysqli_fetch_assoc($result);

    $balance = $row['amount'];

    $total_balance = intval($balance) + intval($total_income);

    $query1 = "INSERT INTO income VALUES
    ('', '$kode_income', '$income_akun', '$payment_income','$income_date', '', '$total_income', '$narasi')";
    
    $query2 = "INSERT INTO bank VALUES
    ('', '$payment_income','$income_date' ,'$income_akun', '$kode_income','income', '$total_income', '-', '$total_balance')";

    $query3 = "UPDATE akun_bank SET amount = $total_balance WHERE nama_akun_bank LIKE '%$payment_income%'";

    $query = $query1 . "; " . $query2 . "; " . $query3;

    mysqli_multi_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function tambah_akun_bank($data){
    global $conn;
    $nama_akun_bank = htmlspecialchars($data["nama_akun"]);
    $amount = htmlspecialchars($data["amount"]);

    $query = "INSERT INTO akun_bank VALUES
    ('', '$nama_akun_bank', '$amount')";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword){
    $query = "SELECT * FROM bank WHERE nama_bank LIKE '%$keyword%'";
    return query($query);
}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM bank WHERE id_bank = $id");
    return mysqli_affected_rows($conn);
}

function update($data){
    global $conn;
    $id_bank = $data["id_bank"];
    $nama_bank = $data["nama_bank"];
    $tanggal = $data["tanggal"];
    $particulars = $data["particulars"];
    $vch_no = $data["vch_no"];
    $vch_type = $data["vch_type"];
    $debit = $data["debit"];
    $credit = $data["credit"];
    $balance = $data["balance"];

    $query = "UPDATE bank SET
    nama_bank = '$nama_bank',
    tanggal = '$tanggal',
    particulars = '$particulars',
    vch_no = '$vch_no',
    vch_type = '$vch_type',
    debit = '$debit',
    credit = '$credit',
    balance = '$balance' WHERE id_bank = '$id_bank'";

    mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
}
?>

