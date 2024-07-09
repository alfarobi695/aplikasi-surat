<?php
include 'layouts/sidebar.php';
include 'layouts/topbar.php';
include 'koneksi.php';

// Menghapus kategori jika parameter 'hapus' ada di URL
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Menghapus kategori berdasarkan ID
    $query = "DELETE FROM kategori WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['pesan'] = "Kategori berhasil dihapus.";
    } else {
        $_SESSION['pesan'] = "Gagal menghapus kategori: " . mysqli_error($koneksi);
    }

    // Mengarahkan kembali ke halaman utama
    header('Location: kategori.php');
    exit();
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <?php
    if (isset($_SESSION['pesan']) && $_SESSION['pesan']) {
        printf('<b>%s</b>', $_SESSION['pesan']);
        unset($_SESSION['pesan']);
    }
    ?>

    <h1 class="">Kategori Surat</h1><br>
    <h5 class="">Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat.</h5>
    <h5 class="">Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.</h5>
    <br>
    <form action="kategori.php" method="get">
        <label>Cari Kategori :</label>
        <input type="text" name="cari">
        <input type="submit" value="Cari">
    </form>
    <?php
    if (isset($_GET['cari'])) {
        $cari = $_GET['cari'];
        echo "<b>Hasil pencarian : " . $cari . "</b>";
    }
    ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (isset($_GET['cari'])) {
                $cari = $_GET['cari'];
                $hasil = mysqli_query($koneksi, "select * from kategori where namaKategori like '%" . $cari . "%'");
            } else {
                $hasil = mysqli_query($koneksi, "select * from kategori");
            }
            $no = 1;
            while ($data = mysqli_fetch_array($hasil)) {
                ?>
                <tr>

                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['namaKategori']; ?></td>
                    <td><?php echo $data['KeteranganKategori']; ?></td>
                    <td>
                        <a href="kategori.php?hapus=<?php echo $data['id']; ?>" onclick="return confirm('Yakin Hapus?')"
                            class="btn btn-danger">Hapus</a>
                        <a href="editKategori.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                <?php
            } ?>
        </tbody>
    </table>
    <a href="tambahKategori.php" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i>Tambah Kategori Baru</a>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
include 'layouts/footer.php';
?>
