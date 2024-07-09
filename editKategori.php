<?php
include 'layouts/sidebar.php';
include 'layouts/topbar.php';
include 'koneksi.php';

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mendapatkan data kategori berdasarkan ID
    $query = "SELECT * FROM kategori WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        // Jika data tidak ditemukan, arahkan kembali ke halaman utama
        header('Location: index.php');
        exit();
    }
}

// Memeriksa apakah formulir disubmit
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $namaKategori = $_POST['namaKategori'];
    $keteranganKategori = $_POST['keteranganKategori'];

    // Mengupdate data kategori
    $query = "UPDATE kategori SET namaKategori = '$namaKategori', KeteranganKategori = '$keteranganKategori' WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['pesan'] = "Kategori berhasil diperbarui.";
        header('Location: kategori.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="text-center">Edit Kategori Surat</h1><br>
    <form action="editKategori.php?id=<?php echo $id; ?>" method="post">
        <div class="form-group">
            <label for="id">ID Kategori:</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="namaKategori">Nama Kategori:</label>
            <input type="text" class="form-control" id="namaKategori" name="namaKategori" value="<?php echo $data['namaKategori']; ?>" required>
        </div>
        <div class="form-group">
            <label for="keteranganKategori">Keterangan:</label>
            <textarea class="form-control" id="keteranganKategori" name="keteranganKategori" rows="4"><?php echo $data['KeteranganKategori']; ?></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="kategori.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<!-- /.container-fluid -->
</div>

<?php
include 'layouts/footer.php';
?>
