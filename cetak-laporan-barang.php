<?php
include_once 'koneksi.php';
?>

<script>
    window.print();
</script>
<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <tr>
        <th colspan="10">
            <h2 style="margin: 0;"> Laporan Barang</h2>

        </th>
    </tr>

    <tr>
        <th scope="col">No</th>
        <th scope="col">Kode Barang</th>
        <th scope="col">Tanggal Masuk</th>
        <th scope="col">Nama Barang</th>
        <th scope="col">Nama Kategori</th>
        <th scope="col">Kondisi Barang</th>
        <th scope="col">Stok</th>
        <th scope="col">Satuan</th>
        <th scope="col">Nama Ruang</th>
    </tr>

    <tbody>
        <?php
        if (isset($_GET['tanggal_awal'])) {
            $tanggal_awal = $_GET['tanggal_awal'];
            $tanggal_akhir = $_GET['tanggal_akhir'];
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori = kategori.id_kategori INNER JOIN ruang ON barang.id_ruang = ruang.id_ruang WHERE (DATE(tanggal_masuk) BETWEEN '$tanggal_awal' AND '$tanggal_akhir')");
            while ($data = mysqli_fetch_array($query)) {
        ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['kode_barang'] ?></td>
                    <td><?php echo date('d-m-Y', strtotime($data['tanggal_masuk'])) ?></td>
                    <td><?php echo $data['nama_barang'] ?></td>
                    <td><?php echo $data['nama_kategori'] ?></td>
                    <td><?php echo $data['kondisi_barang'] ?></td>
                    <td><?php echo $data['stok'] ?></td>
                    <td><?php echo $data['satuan'] ?></td>
                    <td><?php echo $data['nama_ruang'] ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>