<?php
// Ambil ID terakhir yang berawalan 'A' saja agar tidak bentrok dengan ID berawalan 'S'
$carikode = mysqli_query($koneksi, "SELECT id_sk FROM tb_sirkulasi WHERE id_sk LIKE 'A%' ORDER BY id_sk DESC LIMIT 1");
$datakode = mysqli_fetch_array($carikode);

if ($datakode) {
    $kode = $datakode['id_sk'];
    // Mengambil 3 angka setelah huruf 'A'
    $urut = substr($kode, 1, 3);
    $tambah = (int) $urut + 1;
} else {
    // Jika belum ada ID berawalan 'A', mulai dari 1
    $tambah = 1;
}

// Formating ke A00X
if (strlen($tambah) == 1){
    $format = "A00".$tambah;
} else if (strlen($tambah) == 2){
    $format = "A0".$tambah;
} else {
    $format = "A".$tambah;
}
?>

<section class="content-header">
	<h1>
		Sirkulasi
		<small>Buku</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="index.php">
				<i class="fa fa-home"></i>
				<b>Si Perpustakaan</b>
			</a>
		</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Peminjaman</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-box-tool" data-widget="remove">
							<i class="fa fa-remove"></i>
						</button>
					</div>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form action="" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label>Id Sirkulasi</label>
							<input type="text" name="id_sk" id="id_sk" class="form-control"
								value="<?php echo $format; ?>" readonly />
						</div>

						<div class="form-group">
							<label>Nama Peminjam</label>
							<select name="id_anggota" id="id_anggota" class="form-control select2" style="width: 100%;">
								<option selected="selected">-- Pilih --</option>
								<?php
								// ambil data dari database
								$query = "select * from tb_anggota";
								$hasil = mysqli_query($koneksi, $query);
								while ($row = mysqli_fetch_array($hasil)) {
								?>
								<option value="<?php echo $row['id_anggota'] ?>">
									<?php echo $row['id_anggota'] ?>
									-
									<?php echo $row['nama'] ?>
								</option>
								<?php
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Buku</label>
							<select name="id_buku" id="id_buku" class="form-control select2" style="width: 100%;">
								<option selected="selected">-- Pilih --</option>
								<?php
								// ambil data dari database
								$query = "select * from tb_buku";
								$hasil = mysqli_query($koneksi, $query);
								while ($row = mysqli_fetch_array($hasil)) {
								?>
								<option value="<?php echo $row['id_buku'] ?>">
									<?php echo $row['id_buku'] ?>
									-
									<?php echo $row['judul_buku'] ?>
								</option>
								<?php
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label>Tgl Pinjam</label>
							<input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" />
						</div>

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
						<a href="?page=data_sirkul" class="btn btn-warning">Batal</a>
					</div>
				</form>
			</div>
			<!-- /.box -->
</section>

<?php
    if (isset ($_POST['Simpan'])){

        //menangkap post tgl pinjam
        $tgl_p = $_POST['tgl_pinjam'];
        //membuat tgl kembali
        $tgl_k = date('Y-m-d', strtotime('+7 days', strtotime($tgl_p)));
        
        // --- BAGIAN INI DIPERBAIKI AGAR TIDAK EROR FATAL ---
        
        // 1. Simpan ke tabel sirkulasi dulu
        $sql_sirkulasi = "INSERT INTO tb_sirkulasi (id_sk,id_buku,id_anggota,tgl_pinjam,status,tgl_kembali) VALUES (
            '".$_POST['id_sk']."',
            '".$_POST['id_buku']."',
            '".$_POST['id_anggota']."',
            '".$_POST['tgl_pinjam']."',
            'PIN',
            '".$tgl_k."')";
        
        // Kita gunakan try-catch agar kalau ID kembar (A005), web tidak mati/blank putih
        try {
            $query_sirkulasi = mysqli_query($koneksi, $sql_sirkulasi);
        } catch (Exception $e) {
            $query_sirkulasi = false; // Jika error, anggap gagal
        }

        // 2. Jika simpan sirkulasi berhasil, baru simpan ke Log
        if($query_sirkulasi) {
            $sql_log = "INSERT INTO log_pinjam (id_buku,id_anggota,tgl_pinjam) VALUES (
                '".$_POST['id_buku']."',
                '".$_POST['id_anggota']."',
                '".$_POST['tgl_pinjam']."')";
            mysqli_query($koneksi, $sql_log);
        }

        // --- AKHIR PERBAIKAN ---

        if ($query_sirkulasi){
            echo "<script>
            Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_sirkul';
                }
            })</script>";
        }else{
            echo "<script>
            Swal.fire({title: 'Tambah Data Gagal',text: 'ID Sirkulasi Mungkin Sudah Ada',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=add_sirkul';
                }
            })</script>";
        }
    }
?>