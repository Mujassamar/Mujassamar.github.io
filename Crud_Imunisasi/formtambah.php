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
	<title>Tambah Data Imunisasi</title>
	
</head>
<body style=" background-repeat: repeat-y;">
    <?php
        include "../sidebar.html";
    ?>
    <fieldset>
        <form class="form-horizontal shadow p-3 mb-5 bg-body rounded bg-light">
            <h3>Tambah Data Imunisasi</h3><br>
			<div class="form-group">
				<label for="tgl_imunisasi" id="label">Tanggal Imunisasi</label>
				<input type="date" class="form-control" id="tgl_imunisasi">
			</div>

			<div class="form-group">
				<label for="nama_anak" id="label">Nama Anak</label>
				<select class="form-control" id="nama_anak"></select>
				<!-- <input type="text" class="form-control" id="nama_anak"> -->
			</div>

			<!-- <div class="form-group">
				<label for="nama_ibu" id="label">Nama Ibu</label>
				<select class="form-control" id="nama_ibu"></select>
				<input type="text" class="form-control" id="nama_ibu">
			</div> -->

			<div class="form-group">
				<label for="usia_saat_vaksin" id="label">Usia saat vaksin</label>
				<input type="text" class="form-control" id="usia_saat_vaksin">
			</div>

			<div class="form-group">
				<label for="tinggi_badan" id="label">Tinggi badan</label>
				<input type="text" class="form-control" id="tinggi_badan">
			</div>

			<div class="form-group">
				<label for="berat_badan" id="label">Berat badan</label>
				<input type="text" class="form-control" id="berat_badan">
			</div>

			<div class="form-group">
				<label for="nama_vaksin" id="label">Nama Vaksin</label>
				<select class="form-control" id="nama_vaksin"></select>
				<!-- <input type="text" class="form-control" id="nama_vaksin"> -->
			</div>

			<!-- <div class="form-group">
				<label for="nama_petugas" id="label">Nama Petugas</label>
				<select class="form-control" id="nama_petugas"></select>
			</div> -->
		
		<div class="form-group row">
			<button onclick="window.location.href='prosesCrudImunisasi.php'" type="button" class="btn btn-success col-form"> KEMBALI </button>
			<button type="button" id="ttambah" class="btn btn-success col-form"> TAMBAH </button>
			<span id="status"></span>
		</div>
</fieldset>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		// Load options
		$("#nama_anak").load("../api/Imunisasi2/create_imunisasi.php", "func_imunisasi=ambil_option_anak");
		$("#nama_vaksin").load("../api/Imunisasi2/create_imunisasi.php", "func_imunisasi=ambil_option_vaksin");

		// Event handler for select changes
		$("#nama_anak").change(function(){
			nama_anak = $(this).children("option:selected").val();
		});
		$("#nama_vaksin").change(function(){
			nama_vaksin = $(this).children("option:selected").val();
		});
		$("#ttambah").click(function(){ 
			$("#status").html("");
			$("#ttambah").prop("disabled", true);

			// Ambil nilai dari masing-masing input 
			var tgl_imunisasi = $("#tgl_imunisasi").val();
			var usia_saat_vaksin = $("#usia_saat_vaksin").val();
			var tinggi_badan = $("#tinggi_badan").val();
			var berat_badan = $("#berat_badan").val();
			// var nama_ibu = $("#nama_ibu").val();
			var nama_anak = $("#nama_anak").val();
			// var nama_petugas = $("#nama_petugas").val();
			var nama_vaksin = $("#nama_vaksin").val();

			// Validasi input
			if (!tgl_imunisasi || !usia_saat_vaksin || !tinggi_badan || !berat_badan || !nama_anak || !nama_vaksin) {
				alert("Data Tidak Lengkap");
				$("#status").html("");
				$("#ttambah").prop("disabled", false);
				return;
			}

			// Buat objek imunisasi
			var imunisasi = {
				"tgl_imunisasi": tgl_imunisasi,
				"usia_saat_vaksin": usia_saat_vaksin,
				"tinggi_badan": tinggi_badan,
				"berat_badan": berat_badan,
				"nama_anak": nama_anak,
				"nama_vaksin": nama_vaksin,
				// "nama_ibu": nama_ibu
			};

			// AJAX request
			$.ajax({
				type: "POST",
				url: "../api/Imunisasi2/create_imunisasi.php",
				data: {imunisasi: imunisasi, func_imunisasi: "tambah_data_imun"},
				cache: true,
				success: function(msg){
					$("#ttambah").prop("disabled", false);
					if (msg.message == "imunisasi was created.") {
						alert("Data Imunisasi Berhasil Ditambah");
						window.location.href = "prosesCrudImunisasi.php";
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