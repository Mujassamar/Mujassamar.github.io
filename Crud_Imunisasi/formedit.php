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
	<title>EDIT DATA IMUNISASI</title>

</head>
<body style=" background-repeat: repeat-y;">
    <?php
        include "../sidebar.html";
    ?>
    <fieldset>
        <form class="form-horizontal shadow p-3 mb-5 bg-body rounded bg-light">
            <h3>Edit Data Imunisasi</h3><br> 
			<div class="form-group">
				<label for="tgl_imunisasi" id="label">Tanggal Imunisasi</label>
				<input type="date" class="form-control" id="tgl_imunisasi">
			</div>

			<div class="form-group">
				<label for="nama_anak" id="label">Nama Anak</label>
				<select class="form-control" id="nama_anak"></select>
			</div>

			<div class="form-group">
				<label for="usia_saat_vaksin" id="label">Usia Saat Vaksin</label>
				<input type="text" class="form-control" id="usia_saat_vaksin">
			</div>

			<div class="form-group">
				<label for="tinggi_badan" id="label">Tinggi Badan</label>
				<input type="text" class="form-control" id="tinggi_badan">
			</div>

			<div class="form-group">
				<label for="berat_badan" id="label">Berat Badan</label>
				<input type="text" class="form-control" id="berat_badan">
			</div>

			<div class="form-group">
				<label for="nama_ibu" id="label">Nama Ibu</label>
				<input type="text" class="form-control" id="nama_ibu" disabled>
			</div>

			<div class="form-group">
				<label for="nama_vaksin" id="label">Nama Vaksin</label>
				<select class="form-control" id="nama_vaksin"></select>
			</div>

 	<div class="form-group row">
		<button onclick="window.location.href='prosesCrudImunisasi.php'" type="button" class="btn btn-success col-form"> KEMBALI </button>
		<button id="tupdate" type="button" class="btn btn-success col-form"> PERBARUI </button>
		<span id="status"></span>
	</div>
</fieldset>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
 	<script type="text/javascript">
 	var id_imunisasi;
    var nama_anak;
	var nama_ibu;
    // var nama_petugas;
    var nama_vaksin;
    var tgl_imunisasi;
    var tinggi_badan;
    var berat_badan;
	var id_pendaftaran;
    var usia_saat_vaksin;
    var imunisasi;

    $(document).ready(function () {
    	$(document).ready(function(){

    		//$("#id_imun").load("prosesCrudImunisasi.php", "func_imunisasi=ambil_data_imun");
			$("#nama_anak").load("../api/Imunisasi2/read_one_imunisasi.php", "func_imunisasi=ambil_option_anak");
			$("#nama_vaksin").load("../api/Imunisasi2/read_one_imunisasi.php", "func_imunisasi=ambil_option_vaksin");
			
			$.ajax({
					type : "GET",
					url: "../api/Imunisasi2/read_one_imunisasi.php",
					data: {func_imunisasi : "ambil_single_data", id_imunisasi: "<?php echo $_GET['id_imunisasi']?>"},
					cache: false,
					success: function(data) {
                // Populate form fields
                $("#tgl_imunisasi").val(data['tgl_imunisasi']);
                $("#nama_anak").val(data['nama_anak']);
                $("#usia_saat_vaksin").val(data['usia_saat_vaksin']);
                $("#tinggi_badan").val(data['tinggi_badan']);
                $("#berat_badan").val(data['berat_badan']);
                $("#nama_ibu").val(data['nama_ibu']);
                $("#nama_vaksin").val(data['nama_vaksin']);
            }
			});
				$("#nama_anak").change(function(){
					nama_anak = $(this).children("option:selected").val();
				});
				$("#nama_vaksin").change(function(){
					nama_vaksin = $(this).children("option:selected").val();
				});

    		$("#tupdate").click(function(){
    			tgl_imunisasi = $("#tgl_imunisasi").val();
				id_pendaftaran = $("#nama_anak").val();
    			usia_saat_vaksin = $("#usia_saat_vaksin").val();
    			tinggi_badan = $("#tinggi_badan").val();
    			berat_badan = $("#berat_badan").val();
    			nama_ibu = $("#nama_ibu").val();
    			id_vaksin = $("#nama_vaksin").val();

				imunisasi = {
					"tgl_imunisasi" : tgl_imunisasi,
					"nama_anak" : id_pendaftaran,
					"usia_saat_vaksin" : usia_saat_vaksin,
					"tinggi_badan" : tinggi_badan,
					"berat_badan" : berat_badan,
					"nama_ibu" : nama_ibu,
					"nama_vaksin" : id_vaksin
				};	
   
    			$("#loading").show();
    			$.ajax({
    			type : "POST",
    			url : "../api/Imunisasi2/update_imunisasi.php",
    			data : {imunisasi : imunisasi, func_imunisasi : "update_data_imun", id_imunisasi: "<?php echo $_GET['id_imunisasi']?>"},
    			cache : false,
    			success : function(msg){
    				if(msg.message=="imunisasi was updated."){
    					alert("Data Imunisasi Berhasil Diperbarui");
    					window.location.href="prosesCrudImunisasi.php";
    				}else{
    					$("#status").html("ERROR. . . ");
    				}
    				$("#loading").hide();
       			}
    			});
    		});
    	});
    });
 	</script>
 	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

</body>
</html>