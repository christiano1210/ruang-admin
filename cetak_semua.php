<?php
// Menghubungkan ke database
include 'koneksi.php';

// Mendapatkan data dari link GET
$tanggal = $_GET['tanggal'];
$status = $_GET['status'];

// Query untuk mendapatkan data dari tabel
$query = "SELECT * FROM tb_sm WHERE tgl_sm = '$tanggal' AND status = '$status'";
$result = mysqli_query($koneksi, $query);

// Menggunakan library TCPDF untuk membuat PDF
require_once('tcpdf/tcpdf.php');

// Membuat objek PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Menambahkan halaman
$pdf->AddPage();

// Mengatur font
$pdf->SetFont('helvetica', '', 10);

// Menambahkan informasi kecamatan
$kecamatanInfo = "LIMA PULUH\nJln. Datuk Lima Puluh\nTelp.(0893)2802-228\nEmail: limapuluh@gmail.com";
$pdf->MultiCell(0, 7, $kecamatanInfo, 0, 'C');

// Menambahkan garis titik-tik putus-putus tebal
$pdf->Ln(3);
$pdf->SetLineWidth(1.5); // Atur ketebalan garis
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 190, $pdf->GetY()); // Garis sepanjang lebar halaman
$pdf->SetLineWidth(0.2); // Mengembalikan ketebalan garis ke nilai default

// Membuat header tabel
$pdf->Ln(9); // Spasi antara informasi kecamatan dan tabel
$pdf->Cell(45, 7, 'No Surat', 1, 0, 'C');
$pdf->Cell(30, 7, 'Tgl. Surat', 1, 0, 'C');
$pdf->Cell(50, 7, 'Perihal', 1, 0, 'C');
$pdf->Cell(46, 7, 'Pengirim', 1, 0, 'C');
$pdf->Cell(20, 7, 'Status', 1, 1, 'C');

// Loop through the result set and add rows to the PDF
while ($data = mysqli_fetch_assoc($result)) {
    $pdf->Cell(45, 7, $data['nomor_sm'], 1, 0, 'C');
    $pdf->Cell(30, 7, $data['tgl_sm'], 1, 0, 'C');
    $pdf->Cell(50, 7, $data['perihal_surat'], 1, 0, 'C');
    $pdf->Cell(46, 7, $data['pengirim'], 1, 0, 'C');

    // Ubah status berdasarkan kondisi
    $statusText = '';
    if ($data['status'] == 1) {
        $statusText = 'Proses';
    } elseif ($data['status'] == 2) {
        $statusText = 'Diajukan';
    } elseif ($data['status'] == 3) {
        $statusText = 'Disposisi';
    }

    $pdf->Cell(20, 7, $statusText, 1, 1, 'C');
}

// Tambahkan informasi tanggal cetak
$pdf->Ln(10); // Spasi sebelum informasi tanggal cetak
$pdf->Cell(0, 7, 'Tanggal Cetak: ' . date('Y-m-d'), 0, 1, 'L');

// Tambahkan garis titik-tik putus-putus
$pdf->Ln(3);
$pdf->SetLineWidth(0.5); // Atur ketebalan garis
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 190, $pdf->GetY()); // Garis sepanjang lebar halaman
$pdf->SetLineWidth(0.2); // Mengembalikan ketebalan garis ke nilai default

// Tambahkan informasi nama yang bertanda tangan
$pdf->Ln(2); // Spasi sebelum nama yang bertanda tangan
$pdf->Cell(0, 7, 'Tanda Tangan', 0, 1, 'R');
$pdf->Ln(14);
$sql = "SELECT nama_lengkap FROM tb_pengguna WHERE jabatan = 'kepala'";
$result = $koneksi->query($sql);
$row = $result->fetch_assoc();
$namaYangBertandaTangan = $row["nama_lengkap"];
$pdf->Cell(0, 7, $namaYangBertandaTangan, 0, 1, 'R');

// Output PDF
$pdf->Output('cetak_pdf.pdf', 'I');
?>