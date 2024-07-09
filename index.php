<?php
    include 'layouts/sidebar.php';
    include 'layouts/topbar.php';
    include 'koneksi.php';
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <?php
    if (isset($_SESSION['pesan']) && $_SESSION['pesan'])
    {
      printf('<b>%s</b>', $_SESSION['pesan']);
      unset($_SESSION['pesan']);
    }
  ?>

        <h1 class="">Arsip Surat</h1><br>
        <h5 class="">Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.</h5>
        <h5 class="">Klik "lihat" pada kolom aksi untuk menampilkan surat.</h5>
        <br>
        <form action="index.php" method="get">
         <label>Cari Surat :</label>
         <input type="text" name="cari">
         <input type="submit" value="Cari">
        </form>
        <?php 
        if(isset($_GET['cari'])){
         $cari = $_GET['cari'];
         echo "<b>Hasil pencarian : ".$cari."</b>";
        }
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nomor Surat</th>
                    <th>Kategori</th>
                    <th>Judul</th>
                    <th>Waktu Pengarsipan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    if(isset($_GET['cari'])){
                      $cari = $_GET['cari'];
                      $hasil = mysqli_query($koneksi,"select * from surat where judul like '%".$cari."%'");    
                     }else{
                      $hasil = mysqli_query($koneksi,"select * from surat");  
                     }
                    $no = 1;
                    $sql = "SELECT * FROM surat";
                        while ($data = mysqli_fetch_array($hasil)){
                ?>
                <tr>

                    <td><?php echo $no++?></td>
                    <td><?php echo $data['nomorsurat'];?></td>
                    <td><?php echo $data['kategori'];?></td>
                    <td><?php echo $data['judul'];?></td>
                    <td><?php echo $data['waktu'];?></td>
                    <td>
                        <!-- <a href="hapus.php?id=<?php echo $data['id'];?>" class="btn btn-danger">Hapus File</a> -->

                        
                         <a href="hapus.php?id=<?php echo $data['id'];?>" onclick="return confirm('Yakin Hapus?')" class="btn btn-danger">Hapus</a> 
                         <a href="unduh.php?filename=<?=$data['file']?>" class="btn btn-warning">Download</a>
                        <a href="view.php?id=<?php echo $data['id'];?>" class="btn btn-primary">Lihat</a>
                    </td>
                </tr>
                <?php
            }?>
            </tbody>
            <tr>
                
            </tr>
        </table>
        <a href="surat_tambah.php" class="btn btn-primary"><i class="fas fa-fw fa-plus"></i>Arsipkan Surat</a>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
    include 'layouts/footer.php';
?>

