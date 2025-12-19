<?php
include "inc/koneksi.php";
$sql = mysqli_query($koneksi, "SELECT MAX(RIGHT(id_buku, 3)) AS nomor FROM tb_buku");
$data = mysqli_fetch_array($sql);

if ($data['nomor']) {
    $angka = (int) $data['nomor'];
    $next = $angka + 1;
} else {
    $next = 1;
}

$ID_BARU_OTOMATIS = "A" . str_pad($next, 3, "0", STR_PAD_LEFT);
?>

<section class="content-header">
	<ol class="breadcrumb">
		<li>
			<a href="index.php">
				<i class="fa fa-home"></i>
				<b>Si Perpustakaan</b>
			</a>
		</li>
	</ol>
</section>

<style>
.preview-container {
	margin-top: 15px;
	text-align: center;
}

.preview-container img {
	max-width: 300px;
	max-height: 400px;
	border-radius: 8px;
	box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	object-fit: cover;
}

.file-upload-wrapper {
	position: relative;
	overflow: hidden;
	display: inline-block;
	width: 100%;
}

.file-upload-wrapper input[type=file] {
	font-size: 100px;
	position: absolute;
	left: 0;
	top: 0;
	opacity: 0;
	cursor: pointer;
}

.btn-file-upload {
	display: inline-block;
	padding: 8px 20px;
	background: #3c8dbc;
	color: white;
	border-radius: 4px;
	cursor: pointer;
	transition: background 0.3s;
}

.btn-file-upload:hover {
	background: #2e6da4;
}

.file-name {
	margin-top: 10px;
	color: #666;
	font-size: 14px;
}
</style>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Buku</h3>
				</div>
				<!-- /.box-header -->
				<!-- form -->
				<form action="" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>ID Buku</label>
									<input type="text" name="id_buku" class="form-control" value="<?php echo $ID_BARU_OTOMATIS; ?>" readonly>
								</div>

								<div class="form-group">
									<label>Judul Buku</label>
									<input type="text" name="judul_buku" id="judul_buku" class="form-control" placeholder="Judul Buku" required>
								</div>

								<div class="form-group">
									<label>Pengarang</label>
									<input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Nama Pengarang" required>
								</div>

								<div class="form-group">
									<label>Penerbit</label>
									<input type="text" name="penerbit" id="penerbit" class="form-control" placeholder="Penerbit" required>
								</div>

								<div class="form-group">
									<label>Tahun Terbit</label>
									<input type="number" name="th_terbit" id="th_terbit" class="form-control" placeholder="Tahun Terbit" required>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Cover Buku</label>
									<div class="file-upload-wrapper">
										<button type="button" class="btn-file-upload">
											<i class="fa fa-cloud-upload"></i> Pilih Foto Cover
										</button>
										<input type="file" name="foto_buku" id="foto_buku" accept="image/*" onchange="previewImage(event)">
									</div>
									<div class="file-name" id="fileName">Belum ada file dipilih</div>
								</div>
								
								<div class="preview-container" id="previewContainer" style="display: none;">
									<img id="preview" src="" alt="Preview">
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
						<a href="?page=MyApp/data_buku" class="btn btn-warning">Batal</a>
					</div>
				</form>
			</div>
			<!-- /.box -->
</section>

<script>
function previewImage(event) {
	const input = event.target;
	const fileName = input.files[0] ? input.files[0].name : 'Belum ada file dipilih';
	document.getElementById('fileName').textContent = fileName;
	
	if (input.files && input.files[0]) {
		const reader = new FileReader();
		
		reader.onload = function(e) {
			document.getElementById('preview').src = e.target.result;
			document.getElementById('previewContainer').style.display = 'block';
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}
</script>

<?php

    if (isset ($_POST['Simpan'])){
		
		// Proses upload foto
		$foto_buku = '';
		if (!empty($_FILES['foto_buku']['name'])) {
			$nama_file = $_FILES['foto_buku']['name'];
			$tmp_file = $_FILES['foto_buku']['tmp_name'];
			$ukuran_file = $_FILES['foto_buku']['size'];
			$ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
			
			// Validasi ekstensi file
			$ekstensi_allowed = array('jpg', 'jpeg', 'png', 'gif', 'avif');
			if (in_array(strtolower($ekstensi), $ekstensi_allowed)) {
				// Validasi ukuran file (max 2MB)
				if ($ukuran_file <= 2000000) {
					// Rename file dengan ID buku
					$foto_buku = $_POST['id_buku'] . '_' . time() . '.' . $ekstensi;
					$path = "foto_buku/" . $foto_buku;
					
					
					if (!file_exists("foto_buku")) {
						mkdir("foto_buku", 0777, true);
					}
					
					// Upload file
					move_uploaded_file($tmp_file, $path);
				} else {
					echo "<script>
					Swal.fire({title: 'Ukuran File Terlalu Besar',text: 'Maksimal 2MB',icon: 'error',confirmButtonText: 'OK'
					})</script>";
					exit;
				}
			} else {
				echo "<script>
				Swal.fire({title: 'Format File Tidak Diizinkan',text: 'Hanya JPG, JPEG, PNG, GIF',icon: 'error',confirmButtonText: 'OK'
				})</script>";
				exit;
			}
		}
    
        $sql_simpan = "INSERT INTO tb_buku (id_buku,judul_buku,pengarang,penerbit,th_terbit,foto_buku) VALUES (
           '".$_POST['id_buku']."',
          '".$_POST['judul_buku']."',
          '".$_POST['pengarang']."',
          '".$_POST['penerbit']."',
          '".$_POST['th_terbit']."',
          '".$foto_buku."')";
        $query_simpan = mysqli_query($koneksi, $sql_simpan);
        mysqli_close($koneksi);

    if ($query_simpan){

      echo "<script>
      Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {
          if (result.value) {
              window.location = 'index.php?page=MyApp/data_buku';
          }
      })</script>";
      }else{
      echo "<script>
      Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {
          if (result.value) {
              window.location = 'index.php?page=MyApp/add_buku';
          }
      })</script>";
    }
  }