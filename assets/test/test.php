<center>
<?php
$koneksi = mysqli_connect('localhost','root','','inventaris_barang');

do {
	$kode = rand(100000,999999);
	$cek = mysqli_query($koneksi, "SELECT kode FROM test WHERE kode='$kode' ");
	$cek2 = mysqli_num_rows($cek);
	if ($cek2 == 1) {
		unset($kode);
	}
} while (!isset($kode));

echo $kode;
?>


</center>
