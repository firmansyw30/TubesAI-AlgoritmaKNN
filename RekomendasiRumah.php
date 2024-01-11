<?php 
class RekomendasiRumah{

    public $kriteria = [
        "HARGA" => 4600000000,
        "LB" => 180,
        "LT" => 137,
        "KT" => 4,
        "KM" => 3,
        "GRS" => 2,
    ];
    public function getDataSets()
    {
        $fp = fopen('dataSets/dataRumah.csv', 'r');
        $headers = fgetcsv($fp); // Get column headers

        $dataRumah = array();
        while (($row = fgetcsv($fp))) {
            $dataRumah[] = array_combine($headers, $row);
        }
        fclose($fp);
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
                pow(($kriteria['HARGA'] - $d['HARGA']),2) + pow(($kriteria['LB'] - $d['LB']),2) +
                pow(($kriteria['LT'] - $d['LT']),2) + pow(($kriteria['KT'] - $d['KT']),2) +
                pow(($kriteria['KM'] - $d['KM']),2) + pow(($kriteria['GRS'] - $d['GRS']),2)
            ); 
            $jarak = sqrt($jarak);
            array_push($jarakEuclidian, 
                [
                    "no"=>$d['NO'], 
                    "nama"=>$d['NAMA RUMAH'], 
                    "jarakEuclidian"=>$jarak,
                ]);
        }
        return $jarakEuclidian;
    }
    public function getRekomendasi()
    {
        $knn = self::KNN($this->kriteria);
        $key = array_column($knn, 'jarakEuclidian');
        // var_dump($key);
        array_multisort($key, SORT_ASC, $knn);
        return $knn;
    }

}



 ?>