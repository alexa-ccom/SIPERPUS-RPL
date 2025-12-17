<?php
include "inc/koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets_style/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets_style/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets_style/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <title>Laporan Perpustakaan - Laporan Sirkulasi</title>
</head>
<body onload="window.print()" style="font-family: Quicksand, sans-serif;">
    <h3 class='text-center' style='font-family: Quicksand, sans-serif; margin-top: 30px;'>
        .:: Laporan Perpustakaan ::.
    </h3>
    <h4 class='text-center'>Laporan Sirkulasi</h4>
    
    <?php
    // Query data
    $sql = mysqli_query($koneksi, "SELECT tb_sirkulasi.id_buku, 
        tb_buku.judul_buku, 
        tb_anggota.id_anggota,
        tb_anggota.nama,
        tb_sirkulasi.id_sk,
        tb_sirkulasi.tgl_pinjam,
        tb_sirkulasi.tgl_kembali,
        tb_sirkulasi.tgl_dikembalikan,
        IF(DATEDIFF(tb_sirkulasi.tgl_dikembalikan, tb_sirkulasi.tgl_kembali) <= 0, 0, DATEDIFF(tb_sirkulasi.tgl_dikembalikan, tb_sirkulasi.tgl_kembali)) as telat_pengembalian 
        FROM tb_sirkulasi 
        JOIN tb_anggota ON tb_anggota.id_anggota = tb_sirkulasi.id_anggota 
        JOIN tb_buku ON tb_buku.id_buku = tb_sirkulasi.id_buku 
        WHERE tb_sirkulasi.status = 'KEM'
        ORDER BY id_anggota");
    
    $no = 0;
    $total_denda = 0;
    $tarif_denda = 1000;
    ?>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">ID SKL</th>
                <th style="text-align: center;">Buku</th>
                <th style="text-align: center;">Peminjam</th>
                <th style="text-align: center;">Tgl Pinjam</th>
                <th style="text-align: center;">Jatuh Tempo</th>
                <th style="text-align: center;">Tgl dikembalikan</th>
                <th style="text-align: center;">Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Cek apakah query berhasil
            if ($sql) {
                $row = mysqli_num_rows($sql);
                
                if ($row > 0) {
                    while ($data = mysqli_fetch_assoc($sql)) {
                        $no++;
                        $denda = $data['telat_pengembalian'] * $tarif_denda;
                        $total_denda += $denda;
                        
                        // Format tanggal dengan pengecekan null/empty
                        $tgl_pinjam = (!empty($data['tgl_pinjam']) && $data['tgl_pinjam'] != '0000-00-00') 
                            ? date('d/M/Y', strtotime($data['tgl_pinjam'])) 
                            : '-';
                        
                        $tgl_kembali = (!empty($data['tgl_kembali']) && $data['tgl_kembali'] != '0000-00-00') 
                            ? date('d/M/Y', strtotime($data['tgl_kembali'])) 
                            : '-';
                        
                        $tgl_dikembalikan = (!empty($data['tgl_dikembalikan']) && $data['tgl_dikembalikan'] != '0000-00-00') 
                            ? date('d/M/Y', strtotime($data['tgl_dikembalikan'])) 
                            : '-';
                        
                        echo '<tr>
                                <td style="text-align: center;">' . $no . '</td>
                                <td style="text-align: center;">' . htmlspecialchars($data['id_sk']) . '</td>
                                <td>' . htmlspecialchars($data['judul_buku']) . '</td>
                                <td>' . htmlspecialchars($data['nama']) . '</td>
                                <td style="text-align: center;">' . $tgl_pinjam . '</td>
                                <td style="text-align: center;">' . $tgl_kembali . '</td>
                                <td style="text-align: center;">' . $tgl_dikembalikan . '</td>
                                <td style="text-align: right;">Rp. ' . number_format($denda, 0, ',', '.') . '</td>
                              </tr>';
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align: center;'>Data tidak ada</td></tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align: center; color: red;'>Error: " . mysqli_error($koneksi) . "</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right; padding-right: 10px;">
                    Total Denda
                </th>
                <th style="text-align: right;">
                    Rp. <?php echo number_format($total_denda, 0, ',', '.'); ?>
                </th>
            </tr>
        </tfoot>
    </table>
    
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>
</html>