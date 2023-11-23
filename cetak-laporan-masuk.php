<?php  
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

$timezone = date_default_timezone_get();
$currentdate = date('Y/m/d');
$currentdateD = date('d');
$currenthour = date('H:i');
$currentmonth = date("F");
$currentyear = date("Y");

$today = date("l");
$filter_upweek = date("Y/m/d", strtotime('this week'));
$filter_endweek = date("Y/m/d", strtotime('this week 6 days'));
$filter_upmonth = date("Y/m/1");
$filter_endmonth = date("Y/m/31");
$filter_upyear = date("Y/1/1");
$filter_endyear = date("Y/12/31");

if ($today == "Monday") {
    $today_indo = "Senin";

}elseif ($today == "Tuesday") {
    $today_indo = "Selasa";

}elseif ($today == "Wednesday") {
    $today_indo = "Rabu";
    
}elseif ($today == "Thursday") {
    $today_indo = "Kamis";
    
}elseif ($today == "Friday") {
    $today_indo = "Jumat";
    
}elseif ($today == "Saturday") {
    $today_indo = "Sabtu";
    
}elseif ($today == "Sunday") {
    $today_indo = "Minggu";
    
}
?>
<script type="text/javascript">
	window.print();
</script>
<center>
	<h2 style="margin: 0;">Laporan Barang Masuk</h2>
</center>
<br>
<span style="float: right;">
	<?php  
	if (isset($_GET['print'])) {
		if ($_GET['print'] == 'tanggal') {
			$awal = $_GET['awal'];
			$akhir = $_GET['akhir'];

			echo 'Tanggal Barang Masuk : ' . $awal . ' s/d ' . $akhir ;

		}elseif ($_GET['print'] == 'day') {
			echo 'Hari ini, Tanggal Barang Masuk : ' . $currentdate . ' - ' . $today_indo ;

		}elseif ($_GET['print'] == 'week') {
			echo 'Minggu ini, Tanggal Barang Masuk : ' . $filter_upweek . ' - ' . $filter_endweek ;

		}elseif ($_GET['print'] == 'month') {
			echo 'Bulan ini, Bulan Barang Masuk : ( ' . $currentyear . ' - ' . $currentmonth . ' )' ;
			
		}elseif ($_GET['print'] == 'year') {
			echo 'Tahun ini, Tahun Barang Masuk : ( ' . $currentyear . ' )' ;
			
		}
	}
	?>
</span>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
		<tr>
			<th rowspan="2">No</th>
		    <th rowspan="2">Tanggal masuk</th>
		    <th rowspan="2">Kode Barang</th>
		    <th rowspan="2">Nama Barang</th>
		    <th rowspan="2">Nama Kategori</th>
		    <th colspan="2">Stok dan Kondisi Barang</th>
		    <th rowspan="2">Satuan</th>
		    <th rowspan="2">Ruangan</th>
		    <th rowspan="2">Status</th>
		</tr>
		<tr>
		    <th>Bagus</th>
		    <th>Rusak</th>
		</tr>
	<tbody>
		<?php  
		if (isset($_GET['print'])) {
			if ($_GET['print'] == 'tanggal') {
				$awal = $_GET['awal'];
				$akhir = $_GET['akhir'];

				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$awal' AND '$akhir' ORDER BY tanggal_masuk ");

			}elseif ($_GET['print'] == 'day') {
				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk='$currentdate' ORDER BY tanggal_masuk ");

			}elseif ($_GET['print'] == 'week') {
				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upweek' AND '$filter_endweek' ORDER BY tanggal_masuk ");

			}elseif ($_GET['print'] == 'month') {
				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upmonth' AND '$filter_endmonth' ORDER BY tanggal_masuk ");

			}elseif ($_GET['print'] == 'year') {
				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upyear' AND '$filter_endyear' ORDER BY tanggal_masuk ");

			}elseif ($_GET['print'] == 'all') {
				$query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' ORDER BY tanggal_masuk ");

			}
		}
		$i = 1;
		while ($data = mysqli_fetch_array($query)) {						
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $data['tanggal_masuk']; ?></td>
			<td><?php echo $data['kode_barang']; ?></td>
			<td><?php echo $data['nama_barang']; ?></td>
			<td><?php echo $data['nama_kategori']; ?></td>
			<td><?php echo $data['kondisi_barang_bagus']; ?></td>
			<td><?php echo $data['kondisi_barang_rusak']; ?></td>
			<td><?php echo ucwords($data['satuan']); ?></td>
			<td><?php echo $data['nama_ruang']; ?></td>
			<td><?php 
			if ($data['keluar'] == '1' || $data['alasan'] == 'hapus') {
                echo 'Terhapus';                                               
            }elseif ($data['alasan2'] == 'pinjam'){
                echo 'Terpinjam';
            }else{
                echo 'Ada';
            } 
            ?>
			</td>
		</tr>
		
		<?php
		$i++;
		}
		?>
		<tr>
			<?php  
			if (isset($_GET['print'])) {
				if ($_GET['print'] == 'tanggal') {
					$awal = $_GET['awal'];
					$akhir = $_GET['akhir'];
	
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$awal' AND '$akhir' ORDER BY tanggal_masuk ");
	
				}elseif ($_GET['print'] == 'day') {
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk='$currentdate' ORDER BY tanggal_masuk ");
	
				}elseif ($_GET['print'] == 'week') {
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upweek' AND '$filter_endweek' ORDER BY tanggal_masuk ");
	
				}elseif ($_GET['print'] == 'month') {
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upmonth' AND '$filter_endmonth' ORDER BY tanggal_masuk ");
	
				}elseif ($_GET['print'] == 'year') {
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' AND tanggal_masuk BETWEEN '$filter_upyear' AND '$filter_endyear' ORDER BY tanggal_masuk ");
	
				}elseif ($_GET['print'] == 'all') {
					$query2 = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' ORDER BY tanggal_masuk ");
	
				}
				$data2 = mysqli_fetch_array($query2);
			}
			?>
			<td colspan="5" align="right" style="margin-right: 5px;">Total Barang</td>
			<td><?= $data2['bagus'] ?></td>
			<td><?= $data2['rusak'] ?></td>
			<td colspan="3"></td>
		</tr>
	</tbody>
</table>