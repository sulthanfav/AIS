<?php
    require 'function.php';
    $id_bank = $_GET["id"];
    if( hapus($id_bank) > 0){
        echo "
            <script>
                alert('Data berhasil dihapus!');
                document.location.href = 'ledger.php';
            </script>
        ";
    } else {
        echo "<script>
        alert('Data gagal dihapus!');
        document.location.href = 'ledger.php';
        </script>
        ";
    }
?>