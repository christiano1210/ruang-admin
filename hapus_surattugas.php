<?php
// Koneksi ke database
include 'koneksi.php';

// Mendapatkan surattugas dari parameter atau formulir
$id_sk = $_GET['id']; // Sesuaikan ini dengan cara Anda mendapatkan id_kategori

// Membuat pernyataan SQL DELETE
$sql = "DELETE FROM surattugas WHERE surattugas = $surattugas";

// Menjalankan pernyataan DELETE
if ($koneksi->query($sql) === TRUE) {
    echo '<script language="javascript" type="text/javascript">
        alert("Data surat tugas berhasil dihapus");</script>';
    echo "<meta http-equiv='refresh' content='0; url=surattugas.php'>";
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

// Menutup koneksi
$koneksi->close();
?>