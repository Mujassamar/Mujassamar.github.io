<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once '../config/database.php' ;
include_once '../objects/daftar.php';

//inistantiate database and product object

		$database = new Database();
		$db = $database->getConnection();

		//initialize object
		$imuns = new Imunisasi($db);

		//read product
		//query products
		$stmt = $imuns->read();
		$num = $stmt->rowCount();

		$dataPerPage = 10;
		$jumlahHalaman = ceil($num / $dataPerPage);
		$halamanAktif = $_GET['page'];
		$startPage = ($dataPerPage * $halamanAktif) - $dataPerPage;

		$imuns->dataPerPage = $dataPerPage;
		$imuns->startPage = $startPage;

		$stmt2 = $imuns->readPagination();
		$num2 = $stmt2->rowCount();
		//check if more than 0 record found
		if($num2>=0){

			$imuns_arr=array();
			$imuns_arr["records"]=array();
			$imuns_arr["jumlahHalaman"] = $jumlahHalaman;
			$imuns_arr["halamanAktif"] = $halamanAktif;

			while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){

			extract($row);

			$imuns=array(
					"id_pendaftaran"=>$id_pendaftaran,
					"nik_anak"=>$nik_anak,
					"nama_anak"=>$nama_anak,
					"tanggal_lahir_anak"=>$tanggal_lahir_anak,
					"nama_ortu"=>$nama_ortu,
					// "nama_ortu_berdiri"=>$nama_ortu_berdiri,
					// "nama_ortu_terlentang"=>$nama_ortu_terlentang,
					"no_hp"=>$no_hp,
					"alamat"=>$alamat
					// "nama_petugas"=>$nama_petugas,
					// "nama_vaksin"=>$id_vaksin,
					// "nama_ibu"=>$nama_ibu
			);
			array_push($imuns_arr["records"], $imuns);
			}
			http_response_code(200);

			echo json_encode($imuns_arr);

		}
		else{
			http_response_code(500);
			echo json_encode(
				array("message" => "500 ERROR ")
			);
		}
	
?>