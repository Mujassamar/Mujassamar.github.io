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
		$daftar = new Daftar($db);

		//read product
		//query products
		$stmt = $daftar->read();
		$num = $stmt->rowCount();

		$dataPerPage = 10;
		$jumlahHalaman = ceil($num / $dataPerPage);
		$halamanAktif = $_GET['page'];
		$startPage = ($dataPerPage * $halamanAktif) - $dataPerPage;

		$daftar->dataPerPage = $dataPerPage;
		$daftar->startPage = $startPage;

		$stmt2 = $daftar->readPagination();
		$num2 = $stmt2->rowCount();
		//check if more than 0 record found
		if($num2>=0){

			$daftar_arr=array();
			$daftar_arr["records"]=array();
			$daftar_arr["jumlahHalaman"] = $jumlahHalaman;
			$daftar_arr["halamanAktif"] = $halamanAktif;

			while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){

			extract($row);

			$daftar=array(
					"id_pendaftaran"=>$id_pendaftaran,
					"nik_anak"=>$nik_anak,
					"nama_anak"=>$nama_anak,
					"tanggal_lahir_anak"=>$tanggal_lahir_anak,
					"nama_ibu"=>$nama_ibu,
					"no_hp"=>$no_hp,
					"alamat"=>$alamat

			);
			array_push($daftar_arr["records"], $daftar);
			}
			http_response_code(200);

			echo json_encode($daftar_arr);

		}
		else{
			http_response_code(500);
			echo json_encode(
				array("message" => "500 ERROR ")
			);
		}
	
?>