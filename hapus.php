<?php
include "koneksi.php";
$id    = mysqli_real_escape_string($koneksi,$_GET['id']);
$query = mysqli_query($koneksi,"DELETE FROM surat WHERE id='$id' ");
header('location:index.php?pesan=hapus-berhasil');
?>