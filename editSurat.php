<?php
include 'layouts/sidebar.php';
include 'layouts/topbar.php';
include "koneksi.php";

// Mengambil data kategori dari database
$sql = "SELECT namaKategori FROM kategori";
$result = $koneksi->query($sql);

// Proses update data
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nomorsurat = mysqli_real_escape_string($koneksi, $_POST['nomorsurat']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu']);

    $file = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];

    if (!empty($file_temp)) {
        move_uploaded_file($file_temp, "file/file_$id.pdf");
        $query = "UPDATE surat SET nomorsurat='$nomorsurat', kategori='$kategori', judul='$judul', waktu='$waktu', file='$file' WHERE id='$id'";
    } else {
        $query = "UPDATE surat SET nomorsurat='$nomorsurat', kategori='$kategori', judul='$judul', waktu='$waktu' WHERE id='$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: view.php?id=" . $id);
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}

// Mengambil data surat berdasarkan ID
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM surat WHERE id='$id'");
$data = mysqli_fetch_array($query);
?>

<div class="container-fluid">
    <h2>Edit Surat</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <div class="form-group">
            <label for="nomorsurat">Nomor Surat:</label>
            <input type="text" class="form-control" id="nomorsurat" name="nomorsurat" value="<?php echo $data['nomorsurat']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori:</label>
            <select class="form-control" name="kategori" id="kategori" required>
                <?php
                if ($result->num_rows > 0) {
                    // Output data dari setiap baris
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row["namaKategori"] == $data['kategori']) ? 'selected' : '';
                        echo '<option value="' . $row["namaKategori"] . '" ' . $selected . '>' . $row["namaKategori"] . '</option>';
                    }
                } else {
                    echo '<option value="">Tidak ada kategori</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="judul">Judul:</label>
            <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $data['judul']; ?>" required>
        </div>
        <div class="form-group">
            <label for="waktu">Waktu Unggah:</label>
            <input type="text" name="waktu_display" id="waktu_display" class="form-control" disabled value="<?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d H:i:s"); ?>">
            <input type="hidden" name="waktu" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date("Y-m-d H:i:s"); ?>">
        </div>
        <div class="form-group">
            <label for="file">File (PDF only):</label>
            <input type="file" class="form-control" id="file" name="file">
            <small class="form-text text-muted">Leave blank if you don't want to change the file.</small>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="view.php?id=<?php echo $data['id']; ?>" class="btn btn-danger">Kembali</a>
    </form>
</div>

<?php
include 'layouts/footer.php';
?>
