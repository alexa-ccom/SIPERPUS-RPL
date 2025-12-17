<?php
    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_anggota WHERE id_anggota='".$_GET['kode']."'";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }
?>

<section class="content-header">
    <h1>
        Master Data
        <small>Data Anggota</small>
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
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Anggota</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">

                        <div class="form-group">
                            <label>Id anggota</label>
                            <input type='text' class="form-control" name="id_anggota" value="<?php echo $data_cek['id_anggota']; ?>"
                             readonly/>
                        </div>

                        <div class="form-group">
                            <label>Nama</label>
                            <input type='text' class="form-control" name="nama" value="<?php echo $data_cek['nama']; ?>"
                            />
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jekel" id="jekel" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <?php
                                //cek data yg dipilih sebelumnya
                                if ($data_cek['jekel'] == "Laki-laki") echo "<option value='Laki-laki' selected>Laki-laki</option>";
                                else echo "<option value='Laki-laki'>Laki-laki</option>";
                                
                                if ($data_cek['jekel'] == "Perempuan") echo "<option value='Perempuan' selected>Perempuan</option>";
                                else echo "<option value='Perempuan'>Perempuan</option>";
                            ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="jurusan" id="jurusan" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <?php
                                    // PENTING: Cek nama kolom di database Anda.
                                    // Jika di database kolomnya masih bernama 'kelas', ubah baris bawah ini jadi: $data_cek['kelas'];
                                    // Jika sudah diubah jadi 'jurusan', biarkan seperti ini: $data_cek['jurusan'];
                                    $j = $data_cek['kelas']; 
                                ?>

                                <option value="Sistem & Teknologi Informasi Bisnis" <?php if($j == "Sistem & Teknologi Informasi Bisnis") echo "selected"; ?>>Sistem & Teknologi Informasi Bisnis</option>
                                <option value="Manajemen Retail" <?php if($j == "Manajemen Retail") echo "selected"; ?>>Manajemen Retail</option>
                                <option value="Bisnis Digital" <?php if($j == "Bisnis Digital") echo "selected"; ?>>Bisnis Digital</option>
                                <option value="Desain Komunikasi Visual" <?php if($j == "Desain Komunikasi Visual") echo "selected"; ?>>Desain Komunikasi Visual</option>
                                <option value="Desain Mode" <?php if($j == "Desain Mode") echo "selected"; ?>>Desain Mode</option>
                                <option value="Desain Interior" <?php if($j == "Desain Interior") echo "selected"; ?>>Desain Interior</option>
                                <option value="Arsitektur" <?php if($j == "Arsitektur") echo "selected"; ?>>Arsitektur</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type='number' class="form-control" name="no_hp" value="<?php echo $data_cek['no_hp']; ?>"
                            />
                        </div>

                    </div>
                    <div class="box-footer">
                        <input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
                        <a href="?page=MyApp/data_agt" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
            </section>

<?php

if (isset ($_POST['Ubah'])){
    
    // PENTING: Sesuaikan query UPDATE di bawah ini dengan nama kolom database Anda ('kelas' atau 'jurusan')
    // Di sini saya asumsikan kolom database masih bernama 'kelas'
    
    $sql_ubah = "UPDATE tb_anggota SET
        nama='".$_POST['nama']."',
        jekel='".$_POST['jekel']."',
        jurusan='".$_POST['jurusan']."',
        no_hp='".$_POST['no_hp']."'
        WHERE id_anggota='".$_POST['id_anggota']."'";
        
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_agt';
            }
        })</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=MyApp/data_agt';
            }
        })</script>";
    }
}
?>