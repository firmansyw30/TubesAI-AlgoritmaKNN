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
    public $k;
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

    public function KNN($krt) // krt = kriteria
    {
        $hasilKNN = [];
        $dataSets = self::getDataSets();

        foreach($dataSets as $d){

        // set angka default untuk harga, lb,lt jika dikosongkan
            if($this->kriteria['HARGA'] === ''){
                $krt['HARGA'] = $d['HARGA'];
            }
            if($this->kriteria['LT'] === ''){
                $krt['LT'] = $d['LT'];
            }
            if($this->kriteria['LB'] === ''){
                $krt['LB'] = $d['LB'];
            }
            if($this->kriteria['KT'] === ''){
                $krt['KT'] = $d['KT'];
            }
            if($this->kriteria['KM'] === ''){
                $krt['KM'] = $d['KM'];
            }
            if($this->kriteria['GRS'] === ''){
                $krt['GRS'] = $d['GRS'];
            }
            // perbandingan sebelum dan sesudah diset defaultnya
            // var_dump($this->kriteria);
            // var_dump($krt);
            // die();

            $jarak = 
            ( 
                pow(($krt['HARGA'] - $d['HARGA']),2) + pow(($krt['LB'] - $d['LB']),2) +
                pow(($krt['LT'] - $d['LT']),2) + pow(($krt['KT'] - $d['KT']),2) +
                pow(($krt['KM'] - $d['KM']),2) + pow(($krt['GRS'] - $d['GRS']),2)
            ); 
            $jarak = sqrt($jarak);
            array_push($hasilKNN, 
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
                        ({$krt['HARGA']} - {$d['HARGA']})<sup>2</sup> + ({$krt['LB']} - {$d['LB']})<sup>2</sup> +
                        ({$krt['LT']} - {$d['LT']})<sup>2</sup> + ({$krt['KT']} - {$d['KT']})<sup>2</sup> +
                        ({$krt['KM']} - {$krt['KM']})<sup>2</sup> + ({$krt['GRS']} - {$d['GRS']})<sup>2</sup>
                        ) = {$jarak}",
                ]);
        }
        return $hasilKNN;
    }
    public function getRekomendasi()
    {
        $knn = self::KNN($this->kriteria);
        $key = array_column($knn, 'jarakEuclidian');
        // var_dump($key);
        array_multisort($key, SORT_ASC, $knn);
        // var_dump($knn); die();
        return $knn;
    }

}



 ?>