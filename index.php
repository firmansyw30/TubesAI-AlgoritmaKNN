<?php
include_once "RekomendasiRumah.php";
$rekomen = new RekomendasiRumah();
$hasil = $rekomen->getRekomendasi();
$k = 2; // jumlah rekomendasi

// var_dump($hasil);
// var_dump($rekomen->getDataSets());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>TUBES AI | KNN</title>
</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
   <div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col"><img src="img/ai.png" alt="" width="100"></div>
        <div class="col align-middle">
            <a class="navbar-brand" href="#">Rekomendasi Rumah Menggunakan Algoritma KNN</a>
        </div>
    </div>
    
  </div>
</nav>
    <div class="container mt-3">
        <div class="row">
        <h3><span class="badge text-bg-info">Jumlah Rekomendasi : <?= $k ?></span></h3>
        <?php for($i=0; $i<$k; $i++) : ?>
          <div class="col-sm-6 mb-3 mb-sm-0 mt-2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Nama Rumah : <?= $hasil[$i]['nama'] ?></h5>
                <h4>
                    <span class="badge rounded-pill text-bg-primary">
                        Harga : <?= number_format($hasil[$i]['harga'],0,",",".") ?>
                    </span>
                </h4>
                <div class="row">
                    <div class="col">Luas Tanah : <?= $hasil[$i]['lt'] ?></div>
                    <div class="col">Luas Bangunan : <?= $hasil[$i]['lb'] ?></div>
                    <div class="col">Kamar Tidur : <?= $hasil[$i]['kt'] ?></div>
                </div>
                <div class="row">
                    <div class="col">Kamar Mandi : <?= $hasil[$i]['km'] ?></div>
                    <div class="col">Garasi : <?= $hasil[$i]['grs'] ?></div>
                </div>
                <div class="row">
                    <div class="col">
                        Jarak Euclidian : <?= $hasil[$i]['jarakEuclidian'] ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#modalDetailPerhitungan"
                data-perhitungan="<?= $hasil[$i]['perhitungan'] ?>" id="btn-detail">
                  Detail Perhitungan
                </button>
              </div>
            </div>
          </div>
        <?php endfor; ?>
        </div>
    </div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal modal-lg fade" id="modalDetailPerhitungan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Perhitungan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="perhitungan">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script>
    $(document).on('click', '#btn-detail', function() {
        const perhitungan = $(this).data('perhitungan');
        console.log(perhitungan);
        $('#modalDetailPerhitungan .modal-body #perhitungan').html(perhitungan);
    });
</script>
</body>
</html>





