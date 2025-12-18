<section class="content-header">
	<h1 style="text-align:center;">
		Data Buku
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="index.php">
				<i class="fa fa-home"></i>
				<b>SiPerpus</b>
			</a>
		</li>
	</ol>
</section>

<style>
#bookContainer {
    display: flex;
    flex-wrap: wrap;
}

/* Memaksa kartu untuk selalu setinggi container induknya */
.book-card {
    display: flex;
    flex-direction: column;
    height: 100%; /* SANGAT PENTING */
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 25px;
    position: relative;
}

.book-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.book-cover {
    width: 100%;
    height: 280px;
    display: flex;
    /* Ubah align-items ke flex-end agar teks turun ke bawah */
    align-items: flex-end; 
    justify-content: center;
    position: relative;
    overflow: hidden;
    background-size: cover;
    background-position: center;
}



.book-cover.no-image {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.book-cover.no-image::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y="50" font-size="60" fill="rgba(255,255,255,0.1)">📚</text></svg>') center/cover;
}

.book-title-cover {
    color: white;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    /* Sesuaikan padding dan margin */
    padding: 15px 10px;
    margin-bottom: 20px; /* Memberi jarak sedikit dari dasar cover */
    z-index: 1;
    position: relative;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    line-height: 1.4;
    /* Transparansi sedikit gelap agar teks terbaca jelas di atas gambar */
    background: rgba(0,0,0,0.5); 
    width: 90%; /* Lebar kotak teks */
    border-radius: 5px;
}

.book-badge {
	position: absolute;
	top: 10px;
	right: 10px;
	background: rgba(255,255,255,0.9);
	padding: 5px 12px;
	border-radius: 15px;
	font-size: 11px;
	font-weight: bold;
	color: #667eea;
	z-index: 2;
}

.book-details {
    padding: 15px;
    flex-grow: 1; /* Membuat area teks mengambil sisa ruang yang ada */
}

.book-info {
    margin-bottom: 5px;
    font-size: 13px;
    color: #666;
    /* Mencegah teks meluber */
    word-wrap: break-word; 
}

.book-info {
    min-height: 20px; /* Menjaga konsistensi jarak antar baris info */
}
.book-actions {
    margin-top: auto; /* Memaksa footer ke bawah */
    padding: 12px 15px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    display: flex;
    /* gap: 8px; */
    justify-content: center;
}

.filter-section {
	background: white;
	padding: 20px;
	border-radius: 8px;
	box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	margin-bottom: 25px;
}

/* Container Search Icon */
.search-wrapper {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.search-box {
    width: 40px;
    height: 40px;
    background: #fff;
    line-height: 40px;
    border-radius: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    display: flex;
    align-items: center;
    overflow: hidden;
    border: 1px solid #ddd;
}

.search-box.active {
    width: 100%; /* Memanjang saat diklik */
    border-color: #3c8dbc;
}

.search-box input {
    width: 100%;
    border: none;
    outline: none;
    background: none;
    padding: 0;
    font-size: 14px;
    transition: all 0.4s ease;
    opacity: 0;
}

.search-box.active input {
    padding: 0 15px;
    opacity: 1;
}

.search-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    color: #333;
}

/* Agar info text tetap rapi */
.book-info {
    font-size: 12px;
    margin-bottom: 5px;
    display: flex;
}
.book-info strong {
    width: 80px;
    flex-shrink: 0;
}

@media (max-width: 768px) {
	.book-cover {
		height: 220px;
	}
	.book-title-cover {
		font-size: 14px;
	}
}
</style>

<!-- Main content -->
<section class="content">
	<div class="filter-section">
    <div class="row">
        <div class="col-md-6 col-xs-6">
            <a href="?page=MyApp/add_buku" class="btn btn-primary">
                <i class="glyphicon glyphicon-plus"></i> <span class="hidden-xs">Tambah Buku</span>
            </a>
        </div>
        <div class="col-md-6 col-xs-6">
            <div class="search-wrapper">
                <div class="search-box" id="searchBox">
                    <input type="text" id="searchBook" placeholder="Cari buku...">
                    <div class="search-icon" id="toggleSearch">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<div class="row" id="bookContainer">
		<?php
		$no = 1;
		$sql = $koneksi->query("SELECT * from tb_buku ORDER BY id_buku DESC");
		
		// Array warna gradient untuk cover buku tanpa foto
		$gradients = [
			'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
			'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
			'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
			'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
			'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
			'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
			'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
			'linear-gradient(135deg, #ff9a56 0%, #ff6a88 100%)',
			'linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%)',
			'linear-gradient(135deg, #fddb92 0%, #d1fdff 100%)'
		];
		
		$count = 0;
		while ($data = $sql->fetch_assoc()) {
			$gradient = $gradients[$count % count($gradients)];
			$count++;
			
			// Cek apakah ada foto
			$hasCover = !empty($data['foto_buku']) && file_exists("foto_buku/".$data['foto_buku']);
		?>
		
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 book-item" 
			data-title="<?php echo strtolower($data['judul_buku']); ?>" 
			data-author="<?php echo strtolower($data['pengarang']); ?>" 
			data-publisher="<?php echo strtolower($data['penerbit']); ?>">
			<div class="book-card">
				
				<?php if ($hasCover) { ?>
					<div class="book-cover" style="background-image: url('foto_buku/<?php echo $data['foto_buku']; ?>');">
						<span class="book-badge"><?php echo $data['th_terbit']; ?></span>
						<div class="book-title-cover">
							<?php echo $data['judul_buku']; ?>
						</div>
					</div>
				<?php } else { ?>
					<div class="book-cover no-image" style="background: <?php echo $gradient; ?>">
						<span class="book-badge"><?php echo $data['th_terbit']; ?></span>
						<div class="book-title-cover">
							<?php echo $data['judul_buku']; ?>
						</div>
					</div>
				<?php } ?>
				
				<div class="book-details">
					<div class="book-info">
						<strong>ID Buku:</strong> <?php echo $data['id_buku']; ?>
					</div>
					<div class="book-info">
						<strong>Pengarang:</strong> <?php echo $data['pengarang']; ?>
					</div>
					<div class="book-info">
						<strong>Penerbit:</strong> <?php echo $data['penerbit']; ?>
					</div>
				</div>
				
				<div class="book-actions">
					<a href="?page=MyApp/edit_buku&kode=<?php echo $data['id_buku']; ?>" 
						title="Edit" class="btn btn-success btn-sm">
						<i class="glyphicon glyphicon-edit"></i> Edit
					</a>
					<a href="?page=MyApp/del_buku&kode=<?php echo $data['id_buku']; ?>" 
						onclick="return confirm('Yakin Hapus Data Ini ?')"
						title="Hapus" class="btn btn-danger btn-sm">
						<i class="glyphicon glyphicon-trash"></i> Hapus
					</a>
				</div>
			</div>
		</div>
		
		<?php
		}
		?>
	</div>
	
	<div id="noResults" style="display: none; text-align: center; padding: 40px;">
		<i class="fa fa-search" style="font-size: 48px; color: #ccc;"></i>
		<h4 style="color: #999; margin-top: 20px;">Buku tidak ditemukan</h4>
		<p style="color: #aaa;">Coba kata kunci pencarian lain</p>
	</div>
</section>

<script>
const searchBox = document.getElementById('searchBox');
const toggleSearch = document.getElementById('toggleSearch');
const searchInput = document.getElementById('searchBook');

// Fungsi untuk membuka/tutup search bar
toggleSearch.addEventListener('click', function() {
    searchBox.classList.toggle('active');
    if (searchBox.classList.contains('active')) {
        searchInput.focus();
    }
});

// Tutup search bar jika klik di luar
document.addEventListener('click', function(e) {
    if (!searchBox.contains(e.target)) {
        searchBox.classList.remove('active');
    }
});

// Fungsi pencarian asli Anda tetap bekerja
searchInput.addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    let bookItems = document.querySelectorAll('.book-item');
    let visibleCount = 0;
    
    bookItems.forEach(function(item) {
        let title = item.getAttribute('data-title');
        let author = item.getAttribute('data-author');
        let publisher = item.getAttribute('data-publisher');
        
        if (title.includes(searchValue) || author.includes(searchValue) || publisher.includes(searchValue)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    document.getElementById('noResults').style.display = visibleCount === 0 ? 'block' : 'none';
});
</script>