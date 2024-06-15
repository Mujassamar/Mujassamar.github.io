<?php

	class Infojadwal  {
		private $conn;
		private $table_nama = "vaksin_ready";

		public $id_ready;
		public $tgl_ready;
		public $nama_vaksin;
		public $catatan;
		public $fromDate;
		public $toDate;
		public $startPage;
        public $dataPerPage;

		public function __construct($db){
			$this->conn = $db;
			$this->id_ready = uniqid("idr");
		}
		
		public function read(){
			$query = "
			SELECT 
				vr.id_ready,
				vr.tgl_ready,
                vr.catatan,
				rv.nama_vaksin
			FROM 
				vaksin_ready vr
			JOIN 
				ref_vaksin rv ON vr.id_vaksin = rv.id_vaksin
		";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function readPagination(){

			$query = "
			SELECT 
				vr.id_ready,
				vr.tgl_ready,
                vr.catatan,
				rv.nama_vaksin
			FROM 
				vaksin_ready vr
			JOIN 
				ref_vaksin rv ON vr.id_vaksin = rv.id_vaksin
			LIMIT $this->startPage, $this->dataPerPage
		";

			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}

		public function create(){
			
			// query to insert record
			$query = "INSERT INTO
						" . $this->table_nama . " (id_ready, tgl_ready, id_vaksin, catatan) 
						values ('$this->id_ready','$this->tgl_ready', '$this->nama_vaksin', '$this->catatan')";
		 	// prepare query
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				return true;
			}
			return false; 
		}

		function read_one(){
			// Query untuk mengambil satu data berdasarkan id_ready
			$query = "
				SELECT 
				vr.id_ready,
				vr.tgl_ready,
				rv.nama_vaksin,
				vr.catatan
			FROM 
				vaksin_ready vr
			JOIN 
				ref_vaksin rv ON vr.id_vaksin = rv.id_vaksin
				WHERE 
					vr.id_ready = :id_ready"; // Menggunakan parameter bertanda tanya untuk mempersiapkan binding
		
			// Prepare query statement
			$stmt = $this->conn->prepare($query);
		
			// Bind parameter
			$stmt->bindParam(':id_ready', $this->id_ready);
		
			// Execute query
			$stmt->execute();
		
			// Ambil baris data
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
			// Set nilai ke properti objek
			$this->tgl_ready = $row['tgl_ready'];
			$this->nama_vaksin = $row['nama_vaksin'];
			$this->catatan = $row['catatan'];
		}

		public function update(){
			$query = "UPDATE $this->table_nama 
					SET tgl_ready = '$this->tgl_ready', 
						id_vaksin = '$this->nama_vaksin', 
						catatan = '$this->catatan '
					WHERE id_ready = '$this->id_ready'";
		  
			// prepare query statement
			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){
				return true;
			}
			return false;
		}

		function delete(){
  
            // delete query
            $query = "DELETE FROM " . $this->table_nama . " WHERE id_ready = '$this->id_ready'";
          
            // prepare query
            $stmt = $this->conn->prepare($query);
          
            // execute query
            if($stmt->execute()){
                return true;
            } 
            return false;
        }

		
	}
?>