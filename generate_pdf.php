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

require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author');
$pdf->SetTitle('Data Surat-Tugas');
$pdf->SetSubject('Data Surat-Tugas');
$pdf->SetKeywords('TCPDF, PDF, data, surat-tugas');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/tcpdf/eng.php')) {
    require_once(dirname(__FILE__).'/tcpdf/eng.php');
    $pdf->setLanguageArray($l);
}

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Set some content to display
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Surat-Tugas</title>
  <!-- Include your CSS styles here -->
</head>
<body>
  <!-- Your HTML content here -->
  <h1>Data Surat-Tugas</h1>
  <table border="1">
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Departemen</th>
      <th>Yang Menugaskan</th>
      <!-- Add other table headers here -->
    </tr>';

// Fetch data from database and add to the table
$data = "SELECT * FROM surat_tugas";
$result = mysqli_query($koneksi, $data);
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
                <td>'.$no++.'</td>
                <td>'.$row['nama'].'</td>
                <td>'.$row['departemen'].'</td>
              <td>'.$row['menugaskan'].'</td>
                <!-- Add other table data here -->
              </tr>';
}

$html .= '</table>
  <!-- Include your JavaScript here -->
</body>
</html>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('data_surat_tugas.pdf', 'I');

?>
