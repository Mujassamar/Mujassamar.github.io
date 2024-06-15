<?php

	class Imunisasi  {
		private $conn;
		private $table_nama = "ref_imunisasi";

		public $id_imunisasi;
		public $tgl_imunisasi;
		public $usia_saat_vaksin;
		public $tinggi_badan;
		public $berat_badan;
		public $nama_anak;
		// public $nama_petugas;
		public $nama_vaksin;
		// public $nama_ibu;
		// public $alamat;
		// public $nik_anak;
		public $id_pendaftaran;
		public $fromDate;
		public $toDate;
		public $startPage;
        public $dataPerPage;

		public function __construct($db){
			$this->conn = $db;
			$this->id_imunisasi = uniqid("imu");
		}
		
		public function read(){
			$query = "
			SELECT 
				ri.id_imunisasi,
				ri.tgl_imunisasi,
				ri.usia_saat_vaksin,
				ri.tinggi_badan,
				ri.berat_badan,
				di.nama_ibu,
				rv.nama_vaksin,
				di.nama_anak
			FROM 
				ref_imunisasi ri
			JOIN 
				ref_vaksin rv ON ri.id_vaksin = rv.id_vaksin
			JOIN 
				daftar_imunisasi di ON ri.id_pendaftaran = di.id_pendaftaran
		";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function readPagination(){

			$query =  $query = "
			SELECT 
				ri.id_imunisasi,
				ri.tgl_imunisasi,
				ri.usia_saat_vaksin,
				ri.tinggi_badan,
				ri.berat_badan,
				di.nama_ibu,
				rv.nama_vaksin,
				di.nama_anak
			FROM 
				ref_imunisasi ri
			JOIN 
				ref_vaksin rv ON ri.id_vaksin = rv.id_vaksin
			JOIN 
				daftar_imunisasi di ON ri.id_pendaftaran = di.id_pendaftaran
			LIMIT $this->startPage, $this->dataPerPage
		";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function create(){
			
			// query to insert record
			$query = "INSERT INTO
						" . $this->table_nama . " (id_imunisasi, tgl_imunisasi, usia_saat_vaksin, tinggi_badan, berat_badan, id_vaksin, id_pendaftaran) 
						values ('$this->id_imunisasi','$this->tgl_imunisasi', '$this->usia_saat_vaksin', '$this->tinggi_badan', '$this->berat_badan', '$this->nama_vaksin', '$this->nama_anak')";
		 	// prepare query
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				return true;
			}
			return false; 
		}

		function read_one(){
			// Query untuk mengambil satu data berdasarkan id_imunisasi
			$query = "
				SELECT 
					ri.id_imunisasi,
					ri.tgl_imunisasi,
					ri.usia_saat_vaksin,
					ri.tinggi_badan,
					ri.berat_badan,
					di.nama_ibu,
					rv.nama_vaksin,
					di.nama_anak
				FROM 
					ref_imunisasi ri
				JOIN 
					ref_vaksin rv ON ri.id_vaksin = rv.id_vaksin
				JOIN 
					daftar_imunisasi di ON ri.id_pendaftaran = di.id_pendaftaran 
				WHERE 
					ri.id_imunisasi = :id_imunisasi"; // Menggunakan parameter bertanda tanya untuk mempersiapkan binding
		
			// Prepare query statement
			$stmt = $this->conn->prepare($query);
		
			// Bind parameter
			$stmt->bindParam(':id_imunisasi', $this->id_imunisasi);
		
			// Execute query
			$stmt->execute();
		
			// Ambil baris data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
			// Set nilai ke properti objek
			$this->tgl_imunisasi = $row['tgl_imunisasi'];
			$this->usia_saat_vaksin = $row['usia_saat_vaksin'];
			$this->tinggi_badan = $row['tinggi_badan'];
			$this->berat_badan = $row['berat_badan'];
			$this->nama_ibu = $row['nama_ibu'];
			$this->nama_vaksin = $row['nama_vaksin']; // Menggunakan kolom nama_vaksin dari tabel ref_vaksin
			$this->nama_anak = $row['nama_anak'];
		}

		public function update(){
			$query = "UPDATE $this->table_nama 
					SET tgl_imunisasi = :tgl_imunisasi, 
						id_pendaftaran = :nama_anak,
						usia_saat_vaksin = :usia_saat_vaksin, 
						tinggi_badan = :tinggi_badan, 
						berat_badan = :berat_badan,    
						id_vaksin = :nama_vaksin
					WHERE id_imunisasi = :id_imunisasi";
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':tgl_imunisasi', $this->tgl_imunisasi);
			$stmt->bindParam(':nama_anak', $this->id_pendaftaran);
			$stmt->bindParam(':usia_saat_vaksin', $this->usia_saat_vaksin);
			$stmt->bindParam(':tinggi_badan', $this->tinggi_badan);
			$stmt->bindParam(':berat_badan', $this->berat_badan);
			$stmt->bindParam(':nama_vaksin', $this->id_vaksin);
			$stmt->bindParam(':id_imunisasi', $this->id_imunisasi);
			
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
        //     $query = "SELECT ref_imunisasi.id_imunisasi, ref_imunisasi.tgl_imunisasi, ref_imunisasi.usia_saat_vaksin, 
		// 	ref_imunisasi.tinggi_badan, ref_imunisasi.berat_badan,
		// 	ref_anak.nama_anak, ref_anak.usia_anak, ref_anak.tgl_lahir_anak,
		// 	ref_petugas.nama_petugas, ref_ibu.nama_ibu, ref_vaksin.nama_vaksin FROM ".$this->table_nama. 
		// 	" LEFT JOIN ref_anak ON ref_imunisasi.id_anak = ref_anak.id_anak".
		// 	// " LEFT JOIN ref_ibu ON ref_imunisasi.id_ibu = ref_ibu.id_ibu".
		// 	" LEFT JOIN ref_petugas ON ref_imunisasi.id_petugas = ref_petugas.id_petugas". 
		// 	" LEFT JOIN ref_vaksin ON ref_imunisasi.id_vaksin = ref_vaksin.id_vaksin WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate'";

		// 	$query2 = "SELECT ref_anak.id_anak, ref_anak.nama_anak, ref_anak.tgl_lahir_anak, ref_anak.usia_anak, ref_imunisasi.id_imunisasi, ref_imunisasi.berat_badan, ref_imunisasi.tinggi_badan, ref_imunisasi.nama_vaksin, ref_imunisasi.tgl_imunisasi FROM ref_anak RIGHT JOIN ref_imunisasi ON ref_anak.id_anak = ref_imunisasi.id_anak LEFT JOIN ref_ibu ON ref_anak.id_ibu = ref_ibu.id_ibu WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate' GROUP BY ref_anak.id_anak";
        
        //     $stmt = $this->conn->prepare($query2);
		// 	$stmt->execute();
			
		// 	return $stmt;
        // }

		public function ambilVaksin(){
			$query = "SELECT * FROM $this->table_nama WHERE tgl_imunisasi BETWEEN '$this->fromDate' AND '$this->toDate'";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}
	}
?>