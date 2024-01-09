<?php

// Data rumah yang tersedia
$rumah = [
    ['id' => 1, 'luas_tanah' => 150, 'jumlah_kamar' => 3, 'harga' => 500000000],
    ['id' => 2, 'luas_tanah' => 200, 'jumlah_kamar' => 4, 'harga' => 700000000],
    ['id' => 3, 'luas_tanah' => 120, 'jumlah_kamar' => 2, 'harga' => 400000000],
    ['id' => 4, 'luas_tanah' => 180, 'jumlah_kamar' => 3, 'harga' => 600000000],
    ['id' => 5, 'luas_tanah' => 160, 'jumlah_kamar' => 3, 'harga' => 550000000],
    // Tambahkan data rumah lainnya sesuai kebutuhan
];

// Kriteria yang diinginkan oleh customer
$kriteria = ['luas_tanah' => 170, 'jumlah_kamar' => 3, 'harga' => 650000000];

// Fungsi untuk menghitung jarak euclidean antara dua rumah
function hitungJarakEuclidean($rumah1, $rumah2) {
    $jarak = 0;
    foreach ($rumah1 as $k => $v) {
        if ($k !== 'id') {
            $jarak += pow($v - $rumah2[$k], 2);
        }
    }
    return sqrt($jarak);
}

// Fungsi untuk mendapatkan rekomendasi rumah menggunakan k-NN
function rekomendasiPembelianKNN($rumah, $kriteria, $k) {
    $jarakRumah = [];
    foreach ($rumah as $r) {
        $jarak = hitungJarakEuclidean($r, $kriteria);
        $jarakRumah[] = ['id' => $r['id'], 'jarak' => $jarak];
    }

    // Urutkan berdasarkan jarak (semakin rendah, semakin sesuai)
    usort($jarakRumah, function ($a, $b) {
        return $a['jarak'] - $b['jarak'];
    });

    // Ambil k rumah terdekat
    $kTerdekat = array_slice($jarakRumah, 0, $k);

    // Hitung rata-rata atribut rumah yang terdekat
    $rekomendasi = array_fill_keys(array_keys(reset($rumah)), 0);
    $totalBobot = 0;
    foreach ($kTerdekat as $r) {
        $rumahTerdekat = array_filter($rumah, function ($item) use ($r) {
            return $item['id'] == $r['id'];
        });
        $rumahTerdekat = reset($rumahTerdekat);
        $bobot = 1 / ($r['jarak'] + 1);  // Menambahkan 1 untuk menghindari pembagian dengan 0
        $totalBobot += $bobot;
        foreach ($rekomendasi as $k => $v) {
            $rekomendasi[$k] += $rumahTerdekat[$k] * $bobot;
        }
    }

    // Ambil rata-rata sebagai rekomendasi
    foreach ($rekomendasi as $k => $v) {
        $rekomendasi[$k] /= $totalBobot;
    }

    return $rekomendasi;
}

// Tentukan nilai k (jumlah tetangga terdekat yang akan diambil)
$k = 2;

// Dapatkan rekomendasi pembelian rumah menggunakan k-NN
$rekomendasiKNN = rekomendasiPembelianKNN($rumah, $kriteria, $k);

// Tampilkan hasil rekomendasi
echo "Rekomendasi Pembelian Rumah menggunakan k-NN:\n";
echo "ID: " . intval($rekomendasiKNN['id']) . ", Luas Tanah: {$rekomendasiKNN['luas_tanah']}, Jumlah Kamar: {$rekomendasiKNN['jumlah_kamar']}, Harga: {$rekomendasiKNN['harga']}\n";

?>
