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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Data Surat-Tugas</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include 'menu.php'; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <?php include 'profil.php'; ?>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->
        
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h6 mb-0 text-gray-800">Data Surat-Tugas</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item">Surat Tugas</li>
              <li class="breadcrumb-item active" aria-current="page">Data Surat Tugas</li>
            </ol>
          </div>

          <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Data Surat Tugas</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                      <tr class="text-center">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Jam Berangkat</th>
                        <th>Jam Pulang</th>
                        <th>Yang Menugaskan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
<?php
$no = 1;
if(isset($_SESSION['nama'])){
    $nama_lengkap = $_SESSION['nama'];

    $query = "SELECT nama_lengkap FROM tb_pengguna WHERE nama_lengkap = '$nama_lengkap'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die('Error: ' . mysqli_error($koneksi));
    }

    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        
        $username_pengguna = $row['nama_lengkap'];

        // Fetch data dari tabel surat_tugas berdasarkan username pengguna
        $query_surat_tugas = "SELECT * FROM surat_tugas WHERE nama = '$username_pengguna'";
        $result = mysqli_query($koneksi, $query_surat_tugas);
    

?>
    <tbody>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr class="text-center">
            <td><?php echo $no++; ?>.</td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['departemen']; ?></td>
            <td><?php echo $row['tanggal']; ?></td>
            <td><?php echo $row['lokasi']; ?></td>
            <td><?php echo $row['keterangan']; ?></td>
            <td><?php echo $row['jam_berangkat']; ?></td>
            <td><?php echo $row['jam_pulang']; ?></td>
            <td><?php echo $row['menugaskan']; ?></td>
            <td>
                  <button class="btn btn-sm btn-info show-details-btn" data-id="<?php echo $row['id']; ?>">Export PDF</button>
                </td>
        </tr>
    <?php } } 
    } else {
        // Handle jika data tidak ditemukan
        echo "Data pengguna tidak ditemukan.";
    }?>
</tbody>
<?php
    if (!$result) {
        die('Error: ' . mysqli_error($koneksi));
    }
?>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->


                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script></span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</script>
 

  <script>
    $(document).ready(function () {
        $(".deleteBtn").click(function () {
            var id = $(this).data("id");
            var confirmDelete = confirm("Yakin ingin menghapus surat tugas ini?");

            if (confirmDelete) {
                // Lakukan permintaan AJAX ke script PHP penghapusan
                $.ajax({
                    url: "hapus_surat_tugas.php",
                    type: "POST",
                    data: { id: id },
                    success: function (response) {
                        // Handle hasil penghapusan jika diperlukan
                        location.reload(); // Refresh halaman setelah penghapusan
                    }
                });
            }
        });
    });
  </script>
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#exportExcel').click(function() {
          var table = document.getElementById('dataTable');
          var wb = XLSX.utils.table_to_book(table, {
            sheet: "SheetJS"
          });
          XLSX.writeFile(wb, 'data_surat_tugas.xlsx');
        });
      });


      $(document).ready(function() {
        $(".show-details-btn").click(function() {
            var id = $(this).data("id");

            // Send AJAX request to show_details.php with the row ID
            $.ajax({
                url: "generate_pdf.php",
                type: "POST",
                data: { id: id },
                success: function(response) {
                    // Redirect to details page with the response data
                    window.location.href = "generate_pdf.php?id=" + id;
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

</body>

</html>