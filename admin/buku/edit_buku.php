<?php

    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_buku WHERE id_buku='".$_GET['kode']."'";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<section class="content-header">
	<h1>
		Master Data
		<small>Data Buku</small>
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
	background: #00a65a;
	color: white;
	border-radius: 4px;
	cursor: pointer;
	transition: background 0.3s;
}

.btn-file-upload:hover {
	background: #008d4c;
}

.file-name {
	margin-top: 10px;
	color: #666;
	font-size: 14px;
}

.current-photo {
	margin-top: 10px;
	padding: 10px;
	background: #f4f4f4;
	border-radius: 5px;
}
</style>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah Buku</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form action="" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Id Buku</label>
									<input type='text' class="form-control" name="id_buku" value="<?php echo $data_cek['id_buku']; ?>"
									 readonly/>
								</div>

								<div class="form-group">
									<label>Judul Buku</label>
									<input type='text' class="form-control" name="judul_buku" value="<?php echo $data_cek['judul_buku']; ?>" required/>
								</div>

								<div class="form-group">
									<label>Pengarang</label>
									<input type='text' class="form-control" name="pengarang" value="<?php echo $data_cek['pengarang']; ?>" required/>
								</div>

								<div class="form-group">
									<label>Penerbit</label>
									<input class="form-control" name="penerbit" value="<?php echo $data_cek['penerbit']; ?>" required/>
								</div>

								<div class="form-group">
									<label>Th Terbit</label>
									<input class="form-control" name="th_terbit" value="<?php echo $data_cek['th_terbit']; ?>" required>
								</div>
								
								<input type="hidden" name="foto_lama" value="<?php echo $data_cek['foto_buku']; ?>">
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Cover Buku</label>
									
									<?php if (!empty($data_cek['foto_buku']) && file_exists("foto_buku/".$data_cek['foto_buku'])) { ?>
									<div class="current-photo">
										<small>Foto saat ini:</small><br>
										<img src="foto_buku/<?php echo $data_cek['foto_buku']; ?>" style="max-width: 200px; max-height: 250px; border-radius: 5px; margin-top: 5px;">
									</div>
									<?php } ?>
									
									<div class="file-upload-wrapper" style="margin-top: 15px;">
										<button type="button" class="btn-file-upload">
											<i class="fa fa-cloud-upload"></i> Ganti Foto Cover
										</button>
										<input type="file" name="foto_buku" id="foto_buku" accept="image/*" onchange="previewImage(event)">
									</div>
									<div class="file-name" id="fileName">
										<?php echo !empty($data_cek['foto_buku']) ? 'Klik untuk ganti foto' : 'Belum ada foto'; ?>
									</div>
								</div>
								
								<div class="preview-container" id="previewContainer" style="display: none;">
									<small>Preview foto baru:</small><br>
									<img id="preview" src="" alt="Preview">
								</div>
							</div>
						</div>
					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
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

if (isset ($_POST['Ubah'])){
	
	$foto_buku = $_POST['foto_lama']; // Default pakai foto lama
	
	// Proses upload foto baru jika ada
	if (!empty($_FILES['foto_buku']['name'])) {
		$nama_file = $_FILES['foto_buku']['name'];
		$tmp_file = $_FILES['foto_buku']['tmp_name'];
		$ukuran_file = $_FILES['foto_buku']['size'];
		$ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
		
		// Validasi ekstensi file
		$ekstensi_allowed = array('jpg', 'jpeg', 'png', 'gif');
		if (in_array(strtolower($ekstensi), $ekstensi_allowed)) {
			// Validasi ukuran file (max 2MB)
			if ($ukuran_file <= 2000000) {
				// Hapus foto lama jika ada
				if (!empty($_POST['foto_lama']) && file_exists("foto_buku/".$_POST['foto_lama'])) {
					unlink("foto_buku/".$_POST['foto_lama']);
				}
				
				// Rename file dengan ID buku
				$foto_buku = $_POST['id_buku'] . '_' . time() . '.' . $ekstensi;
				$path = "foto_buku/" . $foto_buku;
				
				// Buat folder jika belum ada
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
	
    //mulai proses ubah
    $sql_ubah = "UPDATE tb_buku SET
        judul_buku='".$_POST['judul_buku']."',
        pengarang='".$_POST['pengarang']."',
        penerbit='".$_POST['penerbit']."',
        th_terbit='".$_POST['th_terbit']."',
        foto_buku='".$foto_buku."'
        WHERE id_buku='".$_POST['id_buku']."'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_buku';
            }
        })</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_buku';
            }
        })</script>";
    }
}