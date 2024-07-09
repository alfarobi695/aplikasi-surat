<?php
include "koneksi.php";

//pengecekan tipe harus pdf
$tipe_file = $_FILES['file']['type']; //mendapatkan mime type
if ($tipe_file == "application/pdf") //mengecek apakah file tersebu pdf atau bukan
{
 $nomorsurat = trim($_POST['nomorsurat']);
 $kategori = trim($_POST['kategori']);
 $judul     = trim($_POST['judul']);
 $waktu = trim($_POST['waktu']);
 $file = trim($_FILES['file']['name']);

 $sql = "INSERT INTO surat (nomorsurat,kategori,judul,waktu) VALUES ('$nomorsurat','$kategori','$judul','$waktu')";
 mysqli_query($koneksi,$sql); //simpan data judul dahulu untuk mendapatkan id

 //dapatkan id terkahir
 $query = mysqli_query($koneksi,"SELECT id FROM surat ORDER BY id DESC LIMIT 1");
 $data  = mysqli_fetch_array($query);

 //mengganti nama pdf
 $nama_baru = "file_".$data['id'].".pdf"; //hasil contoh: file_1.pdf
 $file_temp = $_FILES['file']['tmp_name']; //data temp yang di upload
 $folder    = "file"; //folder tujuan

 move_uploaded_file($file_temp, "$folder/$nama_baru"); //fungsi upload
 //update nama file di database
 mysqli_query($koneksi,"UPDATE surat SET file='$nama_baru' WHERE id='$data[id]' ");

 // header('location:index.php?pesan=upload-berhasil');
 ?>
 <script language="JavaScript">
                alert('Upload File PDF Berhasil!');
                document.location='index.php';
                </script>
<?php
}else
{
 // echo "Gagal Upload File Bukan PDF! <a href='index.php'> Kembali </a>";

 ?>
  <script language="JavaScript">
                alert('File Bukan PDF');
                document.location='surat_tambah.php';
                </script>
 <?php
}

?>