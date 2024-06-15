<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database
include_once '../config/database.php';
include_once '../objects/infojadwal.php';

//inistantiate database and product object

		$database = new Database();
		$db = $database->getConnection();

		//initialize object
		$infojadwal = new Infojadwal($db);

		//read product
		//query products
		$stmt = $infojadwal->read();
		$num = $stmt->rowCount();

		$dataPerPage = 10;
		$jumlahHalaman = ceil($num / $dataPerPage);
		$halamanAktif = $_GET['page'];
		$startPage = ($dataPerPage * $halamanAktif) - $dataPerPage;

		$infojadwal->dataPerPage = $dataPerPage;
		$infojadwal->startPage = $startPage;

		$stmt2 = $infojadwal->readPagination();
		$num2 = $stmt2->rowCount();
		//check if more than 0 record found
		if($num2>=0){

			$infojadwal_arr=array();
			$infojadwal_arr["records"]=array();
			$infojadwal_arr["jumlahHalaman"] = $jumlahHalaman;
			$infojadwal_arr["halamanAktif"] = $halamanAktif;

			while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			$infojadwal_item=array(
					"id_ready" => $id_ready,
					"tgl_ready" => $tgl_ready,
					"nama_vaksin" => $nama_vaksin,
					"catatan" => $catatan	
			);
			array_push($infojadwal_arr["records"], $infojadwal_item);
			}
			http_response_code(200);

			echo json_encode($infojadwal_arr);

		}
		else{
			http_response_code(500);
			echo json_encode(
				array("message" => "500 ERROR ")
			);
		}
	
?>
