<?php
class History {
    private $conn;
    private $table_nama = "ref_imunisasi";

    public $id_pendaftaran;
    public $nama_vaksin;
    public $id_vaksin;
    public $startPage;
    public $dataPerPage;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readHistory() {
        $query = "
            SELECT 
                ref_imunisasi.tgl_imunisasi, 
                ref_imunisasi.id_vaksin,
                ref_vaksin.nama_vaksin 
            FROM 
                $this->table_nama
            INNER JOIN 
                ref_vaksin 
            ON 
                ref_imunisasi.id_vaksin = ref_vaksin.id_vaksin 
            WHERE 
                id_pendaftaran = :id_pendaftaran";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pendaftaran', $this->id_pendaftaran);
        $stmt->execute();

        return $stmt;
    }
}
?>
