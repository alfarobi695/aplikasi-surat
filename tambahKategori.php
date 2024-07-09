<?php
include 'layouts/sidebar.php';
include 'layouts/topbar.php';
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $namaKategori = $_POST['namaKategori'];
    $keteranganKategori = $_POST['keteranganKategori'];

    $query = "INSERT INTO kategori (namaKategori, KeteranganKategori) VALUES ('$namaKategori', '$keteranganKategori')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['pesan'] = "Kategori berhasil ditambahkan.";
        header('Location: kategori.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Mendapatkan ID berikutnya untuk ditampilkan di kolom ID
$nextIdQuery = "SELECT AUTO_INCREMENT
                FROM information_schema.TABLES
                WHERE TABLE_SCHEMA = DATABASE()
                AND TABLE_NAME = 'kategori'";
$nextIdResult = mysqli_query($koneksi, $nextIdQuery);
$nextIdRow = mysqli_fetch_assoc($nextIdResult);
$nextId = $nextIdRow['AUTO_INCREMENT'];
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h2>Kategori Surat >> Tambah</h2>
    <h5>Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk.</h5>
    <h5>mengklik tombol "Simpan"</h5>
    <br>


        <form action="tambahKategori.php" method="post">
            <div class="form-group">
                <label for="id">ID Kategori:</label>
                <input type="text" class="form-control" id="id" name="id" value="<?php echo $nextId; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="namaKategori">Nama Kategori:</label>
                <input type="text" class="form-control" id="namaKategori" name="namaKategori" required>
            </div>
            <div class="form-group">
                <label for="keteranganKategori">Keterangan:</label>
                <textarea class="form-control" id="keteranganKategori" name="keteranganKategori" rows="4"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="kategori.php" class="btn btn-secondary">Batal</a>
        </form>
</div>
</div>
<!-- /.container-fluid -->

<?php
include 'layouts/footer.php';
?>