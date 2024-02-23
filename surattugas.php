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
  <link href="login_lol.png" rel="icon">
  <title>Data Surat-Tugas</title>
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
                  <div class="d-grid gap-2 d-md-block">
                  <a class="btn btn-sm btn-primary" href="" data-toggle="modal" data-target="#myModal"><i class="fas fa fa-plus"></i> Tambah Data</a>
                  <button class="btn btn-success mb-3" id="exportExcel"><i class="fas fa-file-excel"></i> Ekspor ke Excel</button>
                    </div>
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
                        <th>Berkas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
<?php
$no = 1;
$data = "SELECT * FROM surat_tugas";
$result = mysqli_query($koneksi, $data);
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
        <a href="generate_pdf.php" class="btn btn-primary">Unduh PDF</a>
<td>
           <a class="btn btn-sm btn-warning" href="" data-toggle="modal" data-target="#myModaledit<?php echo $row['id']; ?>"><i class="fas fa fa-edit"></i></a><br><br>
                  <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $row['id']; ?>"><i class="fas fa fa-trash"></i></button>
            </td>
        </tr>
    <?php } ?>
</tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->
<style></style>
          <!-- Modal Tambah-->
    <div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg"> <!-- Use "modal-lg" for large modal, or "modal-sm" for small modal -->
    <div class="modal-content">
                      <!-- Header Modal -->
                      <div class="modal-header">
                          <h4 class="modal-title">Tambah surat-tugas</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Isi Modal -->
                      <div class="modal-body">
                        <form method="POST" action="tambah_surattugas.php" enctype="multipart/form-data">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nama">Nama:</label>
                                  <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                                <div class="form-group">
                                <label for="departemen">Departemen:</label>
                                <select class="form-control" id="departemen" name="departemen">
                                  <!-- Tambahkan opsi-opsi departemen sesuai kebutuhan -->
                                  <option value="Departemen Teknologi dan industri">Departemen Teknologi dan industri</option>
                                 <option value="Departemen Sains Dan Analitika Data">Departemen Sains Dan Analitika Data </option>
                                  <option value="Departemen Kedokteran Dan Kesehatan">Departemen Kedokteran Dan Kesehatan</option>
                                  <!-- ... tambahkan departemen lainnya sesuai kebutuhan ... -->
                                </select>
                                </div>
                                <div class="form-group">
                                  <label for="tanggal">Tanggal:</label>
                                  <input type="date" class="form-control" id="tanggal" name="tanggal">
                                </div>
                                <div class="form-group">
                                  <label for="lokasi">Lokasi:</label>
                                  <input type="text" class="form-control" id="lokasi" name="lokasi">
                                </div>
                                <div class="form-group">
                                  <label for="keterangan">Keterangan:</label>
                                  <input type="text" class="form-control" id="keterangan" name="keterangan">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="jam_berangkat">Jam Berangkat:</label>
                                  <input type="time" class="form-control" id="jam_berangkat" name="jam_berangkat">
                                </div>
                                <div class="form-group">
                                  <label for="jam_pulang">Jam Pulang:</label>
                                  <input type="time" class="form-control" id="jam_pulang" name="jam_pulang">
                                </div>
                                <div class="form-group">
                                  <label for="menugaskan">Menugaskan:</label>
                                  <input type="text" class="form-control" id="menugaskan" name="menugaskan">
                                </div>
                                </div>
    </div>
    </div>    
                           <!-- Footer Modal -->
  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    </form>
</div>

                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Modal Edit-->
          <?php
          $datap = "SELECT * FROM surat_tugas";
          $result = mysqli_query($koneksi, $datap);
          while ($rowp = mysqli_fetch_assoc($result)){
          ?>
          <div class="modal fade" id="myModaledit<?php echo $rowp['id']; ?>">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <!-- Header Modal -->
                      <div class="modal-header">
                          <h4 class="modal-title">Edit Surat Tugas</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="POST" action="uodate_surattugas.php" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?php echo $rowp['id']; ?>">
                          <div class="container">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="nama">Nama:</label>
                                  <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $rowp['nama']; ?>">
                                </div>
                                  <div class="form-group">
                                <label for="departemen">Departemen:</label>
                                <select class="form-control" id="departemen" name="departemen">
                                  <!-- Tambahkan opsi-opsi departemen sesuai kebutuhan -->
                                  <option value="Departemen Teknologi dan industri">Departemen Teknologi dan industri</option>
                                    <option value="Departemen Sains Dan Analitika Data">Departemen Sains Dan Analitika Data </option>
                                    <option value="Departemen Kedokteran Dan Kesehatan">Departemen Kedokteran Dan Kesehatan</option>
                                  <!-- ... tambahkan departemen lainnya sesuai kebutuhan ... -->
                                </select>
                                </div>
                                <div class="form-group">
                                  <label for="tanggal">Tanggal:</label>
                                  <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $rowp['tanggal']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="lokasi">Lokasi:</label>
                                  <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $rowp['lokasi']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="keterangan">Keterangan:</label>
                                  <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $rowp['keterangan']; ?>">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="jam_berangkat">Jam Berangkat:</label>
                                  <input type="time" class="form-control" id="jam_berangkat" name="jam_berangkat" value="<?php echo $rowp['jam_berangkat']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="jam_pulang">Jam Pulang:</label>
                                  <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" value="<?php echo $rowp['jam_pulang']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="menugaskan">Menugaskan:</label>
                                  <input type="text" class="form-control" id="menugaskan" name="menugaskan" value="<?php echo $rowp['menugaskan']; ?>">
                                </div>
                              </div>
                            </div>
                            <!-- Footer Modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
          <?php } ?>

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
    </script>
</body>

</html>
