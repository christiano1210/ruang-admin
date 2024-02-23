<?php
// Koneksi ke database (ganti sesuai dengan pengaturan Anda)
include 'koneksi.php';

// Ambil data dari form
$surat_id = $_POST['idsk'];
$idp = $_POST['idp'];
$tanggalKeluar = $_POST['tanggalKeluar'];
$nomorAgenda = $_POST['nomorAgenda'];
$kode = $_POST['kode'];
$nomorSuratKeluar = $_POST['nomorSuratKeluar'];
$tanggalSuratKeluar = $_POST['tanggalSuratKeluar'];
$penerima = $_POST['penerima'];
$perihal = $_POST['perihal'];
$lampiran = $_POST['lampiran'];
$tindakan = $_POST['tindakan'];

// Update data surat masuk di database
$query = "UPDATE tb_sk SET nomor_agenda='$nomorAgenda', kode='$kode', nomor_sk='$nomorSuratKeluar', tgl_keluar='$tanggalKeluar', tgl_sk='$tanggalSuratKeluar', penerima_sk='$penerima', perihal_sk='$perihal', lampiran_sk='$lampiran', tindakan='$tindakan', dari_disposisi='$idp' WHERE id_sk=$surat_id";

if ($koneksi->query($query) === TRUE) {
    // Hapus file-file yang terkait dengan surat ini jika tidak ada perubahan pada upload berkas PDF
    if (!empty($_FILES['file_pdf']['name'][0])) {
        $query = "DELETE FROM file_surat_k WHERE sk_id=$surat_id";
        $koneksi->query($query);
    }

    // Proses upload file PDF
    $file_surat = $_FILES['file_pdf']['name'];
    $file_surat_tmp = $_FILES['file_pdf']['tmp_name'];

    foreach ($file_surat as $index => $nama_file) {
        $ukuran_file = $_FILES['file_pdf']['size'][$index];

        // Batasi ukuran file maksimal (50 MB)
        if ($ukuran_file <= 50000000) {
            $target_dir = "suratkeluar/";
            $target_file = $target_dir . basename($nama_file);

            if (move_uploaded_file($file_surat_tmp[$index], $target_file)) {
                // Simpan informasi file ke database
                $query = "INSERT INTO file_surat_k (sk_id, nama_file) VALUES ($surat_id, '$nama_file')";
                $koneksi->query($query);
            } else {
                echo '<script language="javascript" type="text/javascript">
                  alert("File yang diubah tidak ada, maka tidak tersimpan dan file yang asli masih ada.!");</script>';
                echo "<meta http-equiv='refresh' content='0; url=surat_keluar_p.php'>";
            }
        } else {
            echo '<script language="javascript" type="text/javascript">
              alert("Ukuran file terlalu besar.!");</script>';
            echo "<meta http-equiv='refresh' content='0; url=surat_keluar_p.php'>";
        }
    }

    echo '<script language="javascript" type="text/javascript">
        alert("Data Berhasil Diupdate!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=surat_keluar_p.php'>";
} else {
    echo "Error: " . $query . "<br>" . $koneksi->error;
}

$koneksi->close();
?>