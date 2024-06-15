<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once '../config/database.php' ;
include_once '../objects/imunisasi.php';

//inistantiate database and product object

		$database = new Database();
		$db = $database->getConnection();

		//initialize object
		$imunisasi = new Imunisasi($db);

		//read product
		//query products
		$stmt = $imunisasi->read();
		$num = $stmt->rowCount();

		$dataPerPage = 10;
		$jumlahHalaman = ceil($num / $dataPerPage);
		$halamanAktif = $_GET['page'];
		$startPage = ($dataPerPage * $halamanAktif) - $dataPerPage;

		$imunisasi->dataPerPage = $dataPerPage;
		$imunisasi->startPage = $startPage;

		$stmt2 = $imunisasi->readPagination();
		$num2 = $stmt2->rowCount();
		//check if more than 0 record found
		if($num2>=0){

			$imunisasi_arr=array();
			$imunisasi_arr["records"]=array();
			$imunisasi_arr["jumlahHalaman"] = $jumlahHalaman;
			$imunisasi_arr["halamanAktif"] = $halamanAktif;

			while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){

			extract($row);

			$imunisasi=array(	
					"id_imunisasi"=>$id_imunisasi,
					"tgl_imunisasi"=>$tgl_imunisasi,
					"usia_saat_vaksin"=>$usia_saat_vaksin,
					"tinggi_badan"=>$tinggi_badan,
					"berat_badan"=>$berat_badan,
					"nama_ibu"=>$nama_ibu,
					"nama_vaksin"=>$nama_vaksin,
                    "nama_anak"=>$nama_anak

			);
			array_push($imunisasi_arr["records"], $imunisasi);
			}
			http_response_code(200);

			echo json_encode($imunisasi_arr);

		}
		else{
			http_response_code(500);
			echo json_encode(
				array("message" => "500 ERROR ")
			);
		}
	
?>