<?php
session_start();
include 'koneksi.php';

// Periksa apakah session username telah diatur
if (!isset($_SESSION['pengguna_type'])) {
    ?>
    <script>
        alert("Anda Tidak Berhak Masuk Kehalaman Ini!");
        window.location.href = "index.php";
    </script>
    <?php
    exit;
}
    
// Tombol submit pada form tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa dan tambahkan data ke database
    if (isset($_POST['nama']) && isset($_POST['departemen']) && isset($_POST['tanggal']) && isset($_POST['lokasi']) && isset($_POST['keterangan']) && isset($_POST['jam_berangkat']) && isset($_POST['jam_pulang']) && isset($_POST['menugaskan'])) {
        $nama = $_POST['nama'];
        $departemen = $_POST['departemen'];
        $tanggal = $_POST['tanggal'];
        $lokasi = $_POST['lokasi'];
        $keterangan = $_POST['keterangan'];
        $jam_berangkat = $_POST['jam_berangkat'];
        $jam_pulang = $_POST['jam_pulang'];
        $menugaskan = $_POST['menugaskan'];
    
        // Check if the data already exists
        $checkQuery = "SELECT * FROM surat_tugas WHERE nama='$nama'";
        $result = mysqli_query($koneksi, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // Data already exists, send response to client
            $response = array(
                'status' => 'error',
                'message' => 'Data dengan nama tersebut sudah ada!'
            );
            echo json_encode($response);
        } else {
            // Lakukan penambahan data ke database, sesuaikan dengan struktur tabel
            $queryTambah = "INSERT INTO surat_tugas (nama, departemen, tanggal, lokasi, keterangan, jam_berangkat, jam_pulang, menugaskan) VALUES ('$nama', '$departemen', '$tanggal', '$lokasi', '$keterangan', '$jam_berangkat', '$jam_pulang', '$menugaskan')";

            // Eksekusi query tambah data
            if ($koneksi->query($queryTambah) === TRUE) {
                // Data added successfully, send response to client
                $response = array(
                    'status' => 'success',
                    'message' => 'Tambah data berhasil!'
                );
                echo json_encode($response);
                ?>
                <script>
                    alert("Tambah data berhasil!");
                    window.location.href = "index.php"; // Redirect to desired page
                </script>
                <?php
            } else {
                // Error adding record
                $response = array(
                    'status' => 'error',
                    'message' => 'Error adding record: ' . $koneksi->error
                );
                echo json_encode($response);
            }
        }
    }
    exit; // Exit script after processing POST request
}
?>
