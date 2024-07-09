<?php
include "koneksi.php";
?>

<?php
$id    = mysqli_real_escape_string($koneksi,$_GET['id']);
$query = mysqli_query($koneksi,"SELECT * FROM surat WHERE id='$id' ");
$data  = mysqli_fetch_array($query);
?>

<embed src="file/<?php echo $data['file'];?>" type="application/pdf" width="800" height="600" >

<script language="JavaScript">
                alert('Klik Ok Untuk mendownload');
                document.location='index.php';
                </script>