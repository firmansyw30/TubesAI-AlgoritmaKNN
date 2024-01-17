<?php
include_once "RekomendasiRumah.php";
$rekomen = new RekomendasiRumah();

if (isset($_POST['cari'])) {
    $rekomen->k = $k = $_POST['jml']; // jumlah rekomendasi
    $rekomen->kriteria = [
        "HARGA" => $_POST['harga'],
        "LB" => $_POST['lb'],
        "LT" => $_POST['lt'],
        "KT" => $_POST['kt'],
        "KM" => $_POST['km'],
        "GRS" => $_POST['grs']
    ];
    $hasil = $rekomen->getRekomendasi();
    // var_dump($hasil); die();
}else{
    $rekomen->k = 1010;
    $hasil = $rekomen->getDataSets();
}
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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalInput" id="btn-kriteria">
          Masukkan Kriteriamu
        </button>
        <div class="row">
        <?php if(isset($hasil[0]['jarakEuclidian'])) : ?>
            <h3><span class="badge text-bg-info">Jumlah Rekomendasi : <?= $k ?></span></h3>
        <?php endif; ?>
        <?php for($i=0; $i<$rekomen->k; $i++) : ?>
          <div class="col-sm-6 mb-3 mb-sm-0 mt-2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><b>Nama Rumah :</b> <?= $hasil[$i]['NAMA RUMAH'] ?></h5>
                <h4>
                    <span class="badge rounded-pill text-bg-primary">
                        <b>Harga :</b> <?= number_format($hasil[$i]['HARGA'],0,",",".") ?>
                    </span>
                </h4>
                <div class="row">
                    <div class="col"><b>Luas Tanah :</b> <?= $hasil[$i]['LT'] ?>m<sup>2</sup></div>
                    <div class="col"><b>Luas Bangunan :</b> <?= $hasil[$i]['LB'] ?>m<sup>2</sup></div>
                    <div class="col"><b>Kamar Tidur :</b> <?= $hasil[$i]['KT'] ?></div>
                </div>
                <div class="row">
                    <div class="col"><b>Kamar Mandi :</b> <?= $hasil[$i]['KM'] ?></div>
                    <div class="col"><b>Garasi :</b> <?= $hasil[$i]['GRS'] ?></div>
                </div>
                <?php if(isset($hasil[$i]['jarakEuclidian'])) : ?>
                <div class="row">
                    <div class="col">
                        <b>Jarak Euclidian :</b> <?= $hasil[$i]['jarakEuclidian'] ?>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#modalDetailPerhitungan"
                data-perhitungan="<?= $hasil[$i]['perhitungan'] ?>" data-harga="<?= $hasil[$i]['HARGA'] ?>"
                data-lt="<?= $hasil[$i]['LT'] ?>" data-lb="<?= $hasil[$i]['LB'] ?>" 
                data-kt="<?= $hasil[$i]['KT'] ?>" data-km="<?= $hasil[$i]['KM'] ?>"
                data-grs="<?= $hasil[$i]['GRS'] ?>" id="btn-detail">
                  Detail Perhitungan
                </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endfor; ?>
        </div>
    </div>


<?php if(isset($hasil[0]['jarakEuclidian'])) : ?>
<div class="container mt-4">
    <div class="bg-primary bg-gradient badge text-bg-primary mb-1">
        <h3>
        Perhitungan Seluruh Jarak Euclidian
        </h3>
    </div>
    <table class="table table-dark table-hover">
      <thead>
        <tr>
          <th scope="col">NO</th>
          <th scope="col">Nama</th>
          <th scope="col">Jarak Euclidian</th>
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; ?>
        <?php foreach($hasil as $h) : ?>
        <tr>
            <th scope="row"><?= $i ?></th>
            <td><?= $h['NAMA RUMAH'] ?></td>
            <td><?= $h['jarakEuclidian'] ?></td>
            <td>
                <?php if($i <= $rekomen->k) : ?>
                    <span class="badge text-bg-primary">Direkomendasikan</span>
                <?php else : ?>
                    <span class="badge text-bg-danger">Tidak Direkomendasikan</span>
                <?php endif; ?>

            </td>
            <td>
                <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#modalDetailPerhitungan"
                data-perhitungan="<?= $h['perhitungan'] ?>" data-harga="<?= $h['HARGA'] ?>"
                data-lt="<?= $h['LT'] ?>" data-lb="<?= $h['LB'] ?>" 
                data-kt="<?= $h['KT'] ?>" data-km="<?= $h['KM'] ?>"
                data-grs="<?= $h['GRS'] ?>" id="btn-detail">
                    Detail
                </button>
            </td>

        </tr>
        <?php $i++; endforeach; ?>
      </tbody>
    </table>
</div>
<?php endif; ?>


<!-- Modal Detail Perhitungan -->
<div class="modal modal-lg fade" id="modalDetailPerhitungan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Perhitungan</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div id="perhitungan"></div>
        <div class="note small">
            <p>
            NOTE : jika user tidak memasukkan kriteria harga/luas tanah/luas bangunan 
            maka nilai kriteria harga/luas tanah/luas bangunan diberi nilai 
            yang sama dengan masing-masing data rumah yang dihitung
            </p>
        </div>
        <table class="table table-hover mt-3">
            <thead class="table table-primary">
                <tr>
                  <th scope="col">Variable</th>
                  <th scope="col">Kriteria</th>
                  <th scope="col">Data Ini</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  <td>Harga</td>    
                  <td><?= $_POST['harga'] ?></td>
                  <td id="harga"></td>
                </tr>
                <tr>
                  <td>Luas Bangunan</td>
                  <td><?= $_POST['lb'] ?></td>
                  <td id="lb"></td>
                </tr>
                <tr>
                  <td>Luas Tanah</td>
                  <td><?= $_POST['lt'] ?></td>
                  <td id="lt"></td>
                </tr>
                <tr>
                  <td>Kamar Tidur</td>
                  <td><?= $_POST['kt'] ?></td>
                  <td id="kt"></td>
                </tr>
                <tr>
                  <td>Kamar Mandi</td>
                  <td><?= $_POST['km'] ?></td>
                  <td id="km"></td>
                </tr>
                <tr>
                  <td>Garasi</td>
                  <td><?= $_POST['grs'] ?></td>
                  <td id="grs"></td>
                </tr>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Input kriteria-->
<div class="modal fade " id="modalInput" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="jml">Jumlah Rekomendasi</label>
                    <input type="number" name="jml" id="jml" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="lb">Lebar Bangunan</label>
                    <input type="number" name="lb" id="lb" class="form-control" value=""> 
                </div>
                <div class="mb-3">
                    <label for="lt">Luas Tanah</label>
                    <input type="number" name="lt" id="lt" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="kt">Kamar Tidur</label>
                    <input type="number" name="kt" id="kt" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="km">Kamar Mandi</label>
                    <input type="number" name="km" id="km" class="form-control" value="">
                </div>
                <div class="mb-3">
                    <label for="grs">Garasi</label>
                    <input type="number" name="grs" id="grs" class="form-control" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="cari">Cari</button>
            </form>
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
        const harga = $(this).data('harga');
        const lb = $(this).data('lb');
        const lt = $(this).data('lt');
        const kt = $(this).data('kt');
        const km = $(this).data('km');
        const grs = $(this).data('grs');

        console.log(perhitungan);
        $('#modalDetailPerhitungan .modal-body #perhitungan').html(perhitungan);
        $('#modalDetailPerhitungan .modal-body #harga').html(harga);
        $('#modalDetailPerhitungan .modal-body #lb').html(lb);
        $('#modalDetailPerhitungan .modal-body #lt').html(lt);
        $('#modalDetailPerhitungan .modal-body #kt').html(kt);
        $('#modalDetailPerhitungan .modal-body #km').html(km);
        $('#modalDetailPerhitungan .modal-body #grs').html(grs);
    });

</script>
</body>
</html>





