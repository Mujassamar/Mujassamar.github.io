<?php
		
	class Imunisasis  {
		private $conn;
		private $table_nama = "ref_imunisasi";

		public $id_imunisasi;
        public $id_pendaftaran;
		public $tgl_imunisasi;
		public $usia_saat_vaksin;
		public $tinggi_badan;
		public $berat_badan;
		public $nama_ibu;
        public $id_vaksin;
		// public $fromDate;
		// public $toDate;
		public $startPage;
        public $dataPerPage;

		public function __construct($db){
			$this->conn = $db;
			$this->id_imunisasi = uniqid("imunisasis");
		}
		public function read(){
			 $query = "SELECT * FROM " . $this->table_nama;
            // $query = "SELECT ref_imunisasi.id_imunisasi, ref_imunisasi.tgl_imunisasi, ref_imunisasi.usia_saat_vaksin, 
			// ref_imunisasi.tinggi_badan, ref_imunisasi.berat_badan, ref_imunisasi.nama_ibu, daftar_imunisasi.nama_anak,
			// ref_petugas.nama_petugas, ref_imunisasi.nama_vaksin FROM ".$this->table_nama. 
			// " LEFT JOIN daftar_imunisasi ON ref_imunisasi.id_pendaftaran = daftar_imunisasi.id_pendaftaran".
			// " LEFT JOIN ref_petugas ON ref_imunisasi.id_petugas = ref_petugas.id_petugas".
			// " LEFT JOIN ref_vaksin ON ref_imunisasi.id_vaksin = ref_vaksin.id_vaksin";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function readPagination(){
             $query = "SELECT * FROM " . $this->table_nama . " LIMIT $this->startPage, $this->dataPerPage";
            // $query = "SELECT ref_imunisasi.id_imunisasi, ref_imunisasi.tgl_imunisasi, ref_imunisasi.usia_saat_vaksin, 
			// ref_imunisasi.tinggi_badan, ref_imunisasi.berat_badan, ref_imunisasi.nama_ibu, daftar_imunisasi.nama_anak,
			// ref_petugas.nama_petugas, ref_imunisasi.nama_vaksin FROM ".$this->table_nama. 
			// " LEFT JOIN daftar_imunisasi ON ref_imunisasi.id_pendaftaran = daftar_imunisasi.id_pendaftaran".
			// " LEFT JOIN ref_petugas ON ref_imunisasi.id_petugas = ref_petugas.id_petugas". 
			// " LEFT JOIN ref_vaksin ON ref_imunisasi.id_vaksin = ref_vaksin.id_vaksin LIMIT $this->startPage, $this->dataPerPage";


			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function create(){
			
			// query to insert record
			$query = "INSERT INTO
						" . $this->table_nama . " (id_imunisasi, tgl_imunisasi, usia_saat_vaksin, tinggi_badan, berat_badan, nama_ibu, id_vaksin, id_pendaftaran) 
						values ('$this->id_imunisasi','$this->tgl_imunisasi', '$this->usia_saat_vaksin', '$this->tinggi_badan', '$this->berat_badan', '$this->nama_ibu', '$this->nama_vaksin', '$this->nama_anak')";
		 	// prepare query
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				return true;
			}
			return false; 
		}

		function read_one(){
  
            // query to read single record
            // $query = "SELECT daftar_imunisasi.id_imunisasi, daftar_imunisasi.tgl_imunisasi, daftar_imunisasi.usia_saat_vaksin, 
			// daftar_imunisasi.tinggi_badan, daftar_imunisasi.nama_ibu, daftar_imunisasi.nama_ibu, 
            // daftar_imunisasi.id_vaksin FROM ".$this->table_nama. 
			// " LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
			// " LEFT JOIN ref_petugas ON daftar_imunisasi.id_petugas = ref_petugas.id_petugas". 
			$query = "SELECT * FROM $this->table_nama WHERE id_imunisasi = '$this->id_imunisasi'";
          
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
          
            // bind id of product to be updated
          
            // execute query
            $stmt->execute();
          
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
          
            // set values to object properties
            $this->tgl_imunisasi = $row['tgl_imunisasi'];
            $this->usia_saat_vaksin = $row['usia_saat_vaksin'];
            $this->tinggi_badan = $row['tinggi_badan'];
            $this->berat_badan = $row['berat_badan'];
            $this->nama_ibu = $row['nama_ibu'];
            $this->id_vaksin = $row['id_vaksin'];
            $this->id_pendaftaran = $row['id_pendaftaran'];
            $this->id_petugas = $row['id_petugas'];
            // $this->periode = $row['periode'];
			// $this->usia_saat_vaksin = $row['id_anak'];
			// $this->nama_petugas = $row['id_petugas'];
			// $this->nama_vaksin = $row['id_vaksin'];
			// $this->nama_ibu = $row['id_ibu'];
        }

		public function update(){
  
			// update query
			$query = "UPDATE $this->table_nama 
					SET tgl_imunisasi = '$this->tgl_imunisasi', 
						usia_saat_vaksin = '$this->usia_saat_vaksin', 
						tinggi_badan = '$this->tinggi_badan ', 
                        berat_badan = '$this->berat_badan ', 
						nama_ibu = '$this->nama_ibu',
						id_vaksin = '$this->id_vaksin',
                        id_pendaftaran = '$this->id_pendaftaran',
						-- id_petugas = '$this->id_petugas'
                        -- periode = '$this->periode',
						-- id_anak = '$this->usia_saat_vaksin',
						-- id_petugas = '$this->nama_petugas',
						-- id_vaksin = '$this->nama_vaksin',
						-- id_ibu = '$this->nama_ibu'
					WHERE id_imunisasi = '$this->id_imunisasi'";
		  
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
            $query = "DELETE FROM " . $this->table_nama . " WHERE id_imunisasi = '$this->id_imunisasi'";
          
            // prepare query
            $stmt = $this->conn->prepare($query);
          
            // execute query
            if($stmt->execute()){
                return true;
            } 
            return false;
        }

		// public function dataRekap(){
        //     $query = "SELECT daftar_imunisasi.id_imunisasi, daftar_imunisasi.tgl_imunisasi, daftar_imunisasi.usia_saat_vaksin, 
		// 	daftar_imunisasi.tinggi_badan, daftar_imunisasi.berat_badan_umur, daftar_imunisasi.berat_badan_berdiri, daftar_imunisasi.berat_badan_terlentang, daftar_imunisasi.periode, ref_anak.usia_saat_vaksin, ref_anak.usia_anak, ref_anak.tgl_lahir_anak,
		// 	ref_petugas.nama_petugas, ref_ibu.nama_ibu, ref_ibu.id_vaksin_ibu, daftar_imunisasi.id_vaksin FROM ".$this->table_nama. 
		// 	" LEFT JOIN ref_anak ON daftar_imunisasi.id_anak = ref_anak.id_anak".
		// 	" LEFT JOIN ref_ibu ON daftar_imunisasi.id_ibu = ref_ibu.id_ibu".
		// 	" LEFT JOIN ref_petugas ON daftar_imunisasi.id_petugas = ref_petugas.id_petugas WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate'";

		// 	$query2 = "SELECT ref_anak.id_anak, ref_anak.usia_saat_vaksin, ref_anak.tgl_lahir_anak, ref_anak.usia_anak, ref_ibu.nama_ibu, ref_ibu.id_vaksin_ibu, daftar_imunisasi.id_imunisasi, daftar_imunisasi.berat_badan_umur, daftar_imunisasi.berat_badan_berdiri, daftar_imunisasi.berat_badan_terlentang, daftar_imunisasi.tinggi_badan, daftar_imunisasi.id_vaksin, daftar_imunisasi.tgl_imunisasi FROM ref_anak RIGHT JOIN daftar_imunisasi ON ref_anak.id_anak = daftar_imunisasi.id_anak LEFT JOIN ref_ibu ON ref_anak.id_ibu = ref_ibu.id_ibu WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY ref_anak.id_anak";
        
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