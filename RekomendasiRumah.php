<?php 
class RekomendasiRumah{

    // public $kriteria = [
    //     "HARGA" => 4600000000,
    //     "LB" => 180,
    //     "LT" => 137,
    //     "KT" => 4,
    //     "KM" => 3,
    //     "GRS" => 2,
    // ];
    public $kriteria = [];
    public function getDataSets()
    {
        // CONVERT CSV TO ARRAY
        $fp = fopen('dataSets/dataRumah.csv', 'r');
        $headers = fgetcsv($fp); // Get column headers

        $dataRumah = array();
        while (($row = fgetcsv($fp))) {
            $dataRumah[] = array_combine($headers, $row);
        }
        // convert csv to json (untuk datatable) (TIDAK JADI PAKE DATATABLE)
        // $json = json_encode($dataRumah, JSON_PRETTY_PRINT);
        // $output_filename = 'dataSets/dataRumah.json';
        // file_put_contents($output_filename, $json);
        fclose($fp);

        return $dataRumah;
    }

    public function KNN($kriteria)
    {
        $jarakEuclidian = [];
        $dataSets = self::getDataSets();

        foreach($dataSets as $d){
        // set angka default untuk harga, lb,lt jika dikosongkan
            if($kriteria['HARGA'] === ''){
                $kriteria['HARGA'] = $d['HARGA'];
            }
            if($kriteria['LT'] === ''){
                $kriteria['LT'] = $d['LT'];
            }
            if($kriteria['LB'] === ''){
                $kriteria['LB'] = $d['LB'];
            }

            $jarak = 
            ( 
                pow(($kriteria['HARGA'] - $d['HARGA']),2) + pow(($kriteria['LB'] - $d['LB']),2) +
                pow(($kriteria['LT'] - $d['LT']),2) + pow(($kriteria['KT'] - $d['KT']),2) +
                pow(($kriteria['KM'] - $d['KM']),2) + pow(($kriteria['GRS'] - $d['GRS']),2)
            ); 
            $jarak = sqrt($jarak);
            array_push($jarakEuclidian, 
                [
                    "NO"=>$d['NO'], 
                    "NAMA RUMAH"=>$d['NAMA RUMAH'], 
                    "HARGA"=>$d['HARGA'], 
                    "LB"=>$d['LB'], 
                    "LT"=>$d['LT'], 
                    "KT"=>$d['KT'], 
                    "KM"=>$d['KM'], 
                    "GRS"=>$d['GRS'], 
                    "jarakEuclidian"=>$jarak,
                    "perhitungan" => 
                    "&#8730;( 
                        ({$kriteria['HARGA']} - {$kriteria['HARGA']})<sup>2</sup> + ({$kriteria['LB']} - {$kriteria['LB']})<sup>2</sup> +
                        ({$kriteria['LT']} - {$kriteria['LT']})<sup>2</sup> + ({$kriteria['KT']} - {$kriteria['KT']})<sup>2</sup> +
                        ({$kriteria['KM']} - {$kriteria['KM']})<sup>2</sup> + ({$kriteria['GRS']} - {$kriteria['GRS']})<sup>2</sup>)
                        = {$jarak}
                    "
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