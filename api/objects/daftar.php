<?php
		
	class Daftar  {
		private $conn;
		private $table_nama = "daftar_imunisasi";

		public $id_pendaftaran;
		public $nik_anak;
		public $nama_anak;
		public $tanggal_lahir_anak;
		public $nama_ibu;
		public $no_hp;
        public $alamat;
		// public $fromDate;
		// public $toDate;
		public $startPage;
        public $dataPerPage;

		public function __construct($db){
			$this->conn = $db;
			$this->id_pendaftaran = uniqid("daftars");
		}
		public function read(){
			$query = "SELECT * FROM " . $this->table_nama;
			// $query = "SELECT daftar_imunisasi.id_pendaftaran, daftar_imunisasi.nik_anak, daftar_imunisasi.nama_anak, 
			// daftar_imunisasi.tanggal_lahir_anak, daftar_imunisasi.nama_ibu, daftar_imunisasi.no_hp, 
            // daftar_imunisasi.alamat FROM ".$this->table_nama. 
			// " LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
			// " LEFT JOIN ref_ibu ON daftar_imunisasi.id_ibu = ref_ibu.id_ibu".
			// " LEFT JOIN ref_petugas ON daftar_imunisasi.id_petugas = ref_petugas.id_petugas";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function readPagination(){
            $query = "SELECT * FROM " . $this->table_nama . " LIMIT $this->startPage, $this->dataPerPage";

			// $query = "SELECT daftar_imunisasi.id_pendaftaran, daftar_imunisasi.nik_anak, daftar_imunisasi.nama_anak, 
			// daftar_imunisasi.tanggal_lahir_anak, daftar_imunisasi.nama_ortu, daftar_imunisasi.no_hp, 
            // daftar_imunisasi.alamat FROM ".$this->table_nama. 
			// // " LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
			// // " LEFT JOIN ref_ibu ON daftar_imunisasi.id_ibu = ref_ibu.id_ibu".
			// " LIMIT $this->startPage, $this->dataPerPage";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function create(){
			
			// query to insert record
			$query = "INSERT INTO
						" . $this->table_nama . " (id_pendaftaran, nik_anak, nama_anak, tanggal_lahir_anak, nama_ibu, no_hp, alamat) 
						values ('$this->id_pendaftaran','$this->nik_anak', '$this->nama_anak', '
						$this->tanggal_lahir_anak', '$this->nama_ibu', '$this->no_hp', '$this->alamat')";
		 	// prepare query
			$stmt = $this->conn->prepare($query);
			
			// sanitize
			// $this->tgl_imunisasi=htmlspecialchars(strip_tags($data['tgl_imunisasi']));
			// $this->usia_saat_vaksin=htmlspecialchars(strip_tags($data['usia_saat_vaksin']));
			// $this->tinggi_badan=htmlspecialchars(strip_tags($data['tinggi_badan']));
			// $this->berat_badan=htmlspecialchars(strip_tags($data['berat_badan']));
			// $this->periode=htmlspecialchars(strip_tags($data['periode']));
		  
			// bind values
			// $stmt->bindParam(":tgl_imunisasi", $this->tgl_imunisasi);
			// $stmt->bindParam(":usia_saat_vaksin", $this->usia_saat_vaksin);
			// $stmt->bindParam(":tinggi_badan", $this->tinggi_badan);
			// $stmt->bindParam(":berat_badan", $this->berat_badan);
			// $stmt->bindParam(":periode", $this->periode);
		  
			// execute query
			if($stmt->execute()){
				return true;
			}
			return false; 
		}

		function read_one(){
  
            // query to read single record
            // $query = "SELECT daftar_imunisasi.id_pendaftaran, daftar_imunisasi.nik_anak, daftar_imunisasi.nama_anak, 
			// daftar_imunisasi.tanggal_lahir_anak, daftar_imunisasi.nama_ibu, daftar_imunisasi.no_hp, 
            // daftar_imunisasi.alamat FROM ".$this->table_nama. 
			// " LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
			// " LEFT JOIN ref_petugas ON daftar_imunisasi.id_petugas = ref_petugas.id_petugas". 
			$query = "SELECT * FROM $this->table_nama WHERE id_pendaftaran = '$this->id_pendaftaran'";
          
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
          
            // bind id of product to be updated
          
            // execute query
            $stmt->execute();
          
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
          
            // set values to object properties
            $this->nik_anak = $row['nik_anak'];
            $this->nama_anak = $row['nama_anak'];
            $this->tanggal_lahir_anak = $row['tanggal_lahir_anak'];
            $this->nama_ibu = $row['nama_ibu'];
            $this->no_hp = $row['no_hp'];
            $this->alamat = $row['alamat'];
        }

		public function update(){
  
			// update query
			$query = "UPDATE $this->table_nama 
					SET nik_anak = '$this->nik_anak', 
						nama_anak = '$this->nama_anak', 
						tanggal_lahir_anak = '$this->tanggal_lahir_anak ', 
						nama_ibu = '$this->nama_ibu',
						no_hp = '$this->no_hp',
						alamat = '$this->alamat'
					WHERE id_pendaftaran = '$this->id_pendaftaran'";
		  
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		  
			// execute the query
			if($stmt->execute()){
				return true;
			}
		  
			return false;
		}

		function delete(){
  
            // delete query
            $query = "DELETE FROM " . $this->table_nama . " WHERE id_pendaftaran = '$this->id_pendaftaran'";
          
            // prepare query
            $stmt = $this->conn->prepare($query);
          
            // execute query
            if($stmt->execute()){
                return true;
            } 
            return false;
        }

		// public function dataRekap(){
        //     $query = "SELECT daftar_imunisasi.id_pendaftaran, daftar_imunisasi.tgl_imunisasi, daftar_imunisasi.usia_saat_vaksin, 
		// 	daftar_imunisasi.tinggi_badan, daftar_imunisasi.berat_badan_umur, daftar_imunisasi.berat_badan_berdiri, daftar_imunisasi.berat_badan_terlentang, daftar_imunisasi.periode, ref_anak.nama_anak, ref_anak.usia_anak, ref_anak.tgl_lahir_anak,
		// 	ref_petugas.nama_petugas, ref_ibu.nama_ibu, ref_ibu.alamat_ibu, daftar_imunisasi.id_vaksin FROM ".$this->table_nama. 
		// 	" LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
		// 	" LEFT JOIN ref_ibu ON daftar_imunisasi.id_ibu = ref_ibu.id_ibu".
		// 	" LEFT JOIN ref_petugas ON daftar_imunisasi.id_petugas = ref_petugas.id_petugas WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate'";

		// 	$query2 = "SELECT ref_anak.id_anak, ref_anak.nama_anak, ref_anak.tgl_lahir_anak, ref_anak.usia_anak, ref_ibu.nama_ibu, ref_ibu.alamat_ibu, daftar_imunisasi.id_pendaftaran, daftar_imunisasi.berat_badan_umur, daftar_imunisasi.berat_badan_berdiri, daftar_imunisasi.berat_badan_terlentang, daftar_imunisasi.tinggi_badan, daftar_imunisasi.id_vaksin, daftar_imunisasi.tgl_imunisasi FROM ref_anak RIGHT JOIN daftar_imunisasi ON ref_anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN ref_ibu ON ref_anak.id_ibu = ref_ibu.id_ibu WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY ref_anak.id_anak";
        
        //     $stmt = $this->conn->prepare($query2);
		// 	$stmt->execute();
			
		// 	return $stmt;
        // }

		// public function ambilVaksin(){
		// 	$query = "SELECT * FROM $this->table_nama WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate'";

		// 	$stmt = $this->conn->prepare($query);
		// 	$stmt->execute();
			
		// 	return $stmt;
		// }
	}
?>