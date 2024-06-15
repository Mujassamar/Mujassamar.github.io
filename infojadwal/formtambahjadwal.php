<?php
  session_start();
  if(!isset($_SESSION['username_admin'])){
    header("location: ../index.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../tambahcss.css">
	<link rel="shortcut icon" href="../assets/images/logobesar.png" type="image/x-icon">
	<title>Tambah Jadwal Imunisasi</title>
	
</head>
<body style=" background-repeat: repeat-y;">
    <?php
        include "../sidebar.html";
    ?>
    <fieldset>
        <form class="form-horizontal shadow p-3 mb-5 bg-body rounded bg-light">
            <h3>Tambah Jadwal Imunisasi</h3><br>
			<div class="form-group">
				<label for="tgl_ready" id="label">Tanggal Imunisasi</label>
				<input type="date" class="form-control" id="tgl_ready">
			</div>

            <div class="form-group">
				<label for="nama_vaksin" id="label">Nama Vaksin</label>
				<select class="form-control" id="nama_vaksin"></select>
				<!-- <input type="text" class="form-control" id="nama_vaksin"> -->
			</div>

			<div class="form-group">
				<label for="catatan" id="label">Catatan</label>
				<!-- <select class="form-control" id="catatan"></select> -->
				<input type="text" class="form-control" id="catatan">
			</div>	

		<div class="form-group row">
			<button onclick="window.location.href='infojadwal.php'" type="button" class="btn btn-success col-form"> KEMBALI </button>
			<button type="button" id="ttambah" class="btn btn-success col-form"> TAMBAH </button>
			<span id="status"></span>
		</div>
</fieldset>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		// Load options
		$("#nama_vaksin").load("../api/infojadwal/create_infojadwal.php", "func_infojadwal=ambil_option_vaksin");

		// Event handler for select changes
		$("#nama_vaksin").change(function(){
			nama_vaksin = $(this).children("option:selected").val();
		});
		$("#ttambah").click(function(){ 
			$("#status").html("");
			$("#ttambah").prop("disabled", true);

			// Ambil nilai dari masing-masing input 
			var tgl_ready = $("#tgl_ready").val();
            var nama_vaksin = $("#nama_vaksin").val();
			var catatan = $("#catatan").val();

			// Validasi input
			if (!tgl_ready || !catatan || !nama_vaksin) {
				alert("Data Tidak Lengkap");
				$("#status").html("");
				$("#ttambah").prop("disabled", false);
				return;
			}

			// Buat objek infojadwal
			var infojadwal = {
				"tgl_ready": tgl_ready,
				"nama_vaksin": nama_vaksin,
                "catatan": catatan,
			};

			// AJAX request
			$.ajax({
				type: "POST",
				url: "../api/infojadwal/create_infojadwal.php",
				data: {infojadwal: infojadwal, func_infojadwal: "tambah_data_infojadwal"},
				cache: true,
				success: function(msg){
					$("#ttambah").prop("disabled", false);
					if (msg.message == "infojadwal was created.") {
						alert("Data Berhasil Ditambah");
						window.location.href = "infojadwal.php";
					} else {
						$("#status").html("ERROR: " + msg.message);
					}
				},
				error: function(xhr, status, error) {
					$("#ttambah").prop("disabled", false);
					$("#status").html("ERROR: " + xhr.responseText);
				}
			});
		});
	});
</script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>


</body>
</html>