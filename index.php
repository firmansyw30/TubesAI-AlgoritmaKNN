<?php
class RekomendasiRumah{

    public $kriteria = [
        "umurBangunan" => 34,
        "lokasi" => 390,
    ];
    public function getDataSets()
    {
        $dataRumah = [
            [
                "id" => 1,
                "umurBangunan" => 40,
                "lokasi" => 410,
            ],
            [
                "id" => 2,
                "umurBangunan" => 45,
                "lokasi" => 380,
            ],
            
        ];
        return $dataRumah;
    }

    public function KNN($kriteria)
    {
        $jarakEuclidian = [];
        $dataSets = self::getDataSets();
        $k = 2;
        foreach($dataSets as $d){
            $jarak = 
            ( 
                pow(($kriteria['umurBangunan'] - $d['umurBangunan']),2) + pow(($kriteria['lokasi'] - $d['lokasi']),2)
            ); 
            $jarak = sqrt($jarak);
            array_push($jarakEuclidian, 
                [
                    "id"=>$d['id'], 
                    "jarakEuclidian"=>$jarak,
                    "umurBangunan" =>$d['umurBangunan'],
                    "lokasi" => $d['lokasi']
                ]);
        }
        return $jarakEuclidian;
    }
    public function getRekomendasi()
    {
        $knn = self::KNN($this->kriteria);
        $key = array_column($knn, 'jarakEuclidian');
        var_dump($key);
        array_multisort($key, SORT_ASC, $knn);
        return $knn;
    }

}

$rekomen = new RekomendasiRumah();
$hasil = $rekomen->getRekomendasi();
var_dump($hasil);
echo "Rumah Yang Kami Rekomendasikan ID = {$hasil[0]['id']} Jarak Euclidian = {$hasil[0]['jarakEuclidian']}";
?>







