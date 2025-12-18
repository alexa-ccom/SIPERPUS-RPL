<?php
if(isset($_GET['kode'])){
	
	// Ambil data foto sebelum dihapus
	$sql_foto = "SELECT foto_buku FROM tb_buku WHERE id_buku='".$_GET['kode']."'";
	$query_foto = mysqli_query($koneksi, $sql_foto);
	$data_foto = mysqli_fetch_array($query_foto);
	
	// Hapus data dari database
	$sql_hapus = "DELETE FROM tb_buku WHERE id_buku='".$_GET['kode']."'";
	$query_hapus = mysqli_query($koneksi, $sql_hapus);

	if ($query_hapus) {
		// Hapus file foto jika ada
		if (!empty($data_foto['foto_buku']) && file_exists("foto_buku/".$data_foto['foto_buku'])) {
			unlink("foto_buku/".$data_foto['foto_buku']);
		}
		
		echo "<script>
		Swal.fire({title: 'Hapus Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				window.location = 'index.php?page=MyApp/data_buku';
			}
		})</script>";
	}else{
		echo "<script>
		Swal.fire({title: 'Hapus Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				window.location = 'index.php?page=MyApp/data_buku';
			}
		})</script>";
	}
}