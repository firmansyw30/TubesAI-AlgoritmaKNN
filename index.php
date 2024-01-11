<?php
include_once "RekomendasiRumah.php";
$rekomen = new RekomendasiRumah();
$hasil = $rekomen->getRekomendasi();
// var_dump($hasil);
echo "Rumah Yang Kami Rekomendasikan No = {$hasil[0]['no']}, Nama Rumah = {$hasil[0]['nama']}
<br> Jarak Euclidian = {$hasil[0]['jarakEuclidian']}";

var_dump($hasil);
// var_dump($rekomen->getDataSets());

?>







