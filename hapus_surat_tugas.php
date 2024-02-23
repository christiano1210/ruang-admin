<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Delete the record with the specified ID
        $queryDelete = "DELETE FROM surat_tugas WHERE id = $id";
        if (mysqli_query($koneksi, $queryDelete)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($koneksi)));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Parameter ID tidak ditemukan'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Metode request tidak valid'));
}
?>
    
