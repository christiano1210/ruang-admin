<?php
// Koneksi ke database (ganti sesuai dengan pengaturan Anda)
include 'koneksi.php';

// Ambil data dari form
$id = $_POST['id'];
$nama = $_POST['nama'];
$departemen = $_POST['departemen'];
$tanggal = $_POST['tanggal'];
$lokasi = $_POST['lokasi'];
$keterangan = $_POST['keterangan'];
$jam_berangkat = $_POST['jam_berangkat'];
$jam_pulang = $_POST['jam_pulang'];
$menugaskan = $_POST['menugaskan'];

// Update data surat masuk di database
$query = "UPDATE surat_tugas SET nama='$nama', departemen='$departemen', tanggal='$tanggal', lokasi='$lokasi', keterangan='$keterangan', jam_berangkat='$jam_berangkat', jam_pulang='$jam_pulang', menugaskan='$menugaskan' WHERE id=$id";

// Eksekusi query
if ($koneksi->query($query) === TRUE) {
    echo '<script language="javascript" type="text/javascript">
        alert("Edit berhasil!");
    </script>';
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
} else {
    echo "Error updating record: " . $koneksi->error;
}

$koneksi->close();
?>
