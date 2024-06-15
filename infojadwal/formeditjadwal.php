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
	<title>Edit Info Jadwal </title>


</head>
<body style=" background-repeat: repeat-y;">
    <?php
        include "../sidebar.html";
    ?>
    <fieldset>
        <form class="form-horizontal shadow p-3 mb-5 bg-body rounded bg-light">
            <h3>Edit Info Jadwal</h3><br> 
			<div class="form-group">
				<label for="tgl_ready" id="label">Tanggal Imunisasi</label>
				<input type="date" class="form-control" id="tgl_ready">
			</div>

			<div class="form-group">
				<label for="nama_vaksin" id="label">Nama Vaksin</label>
				<select class="form-control" id="nama_vaksin"></select>
			</div>

			<div class="form-group">
				<label for="catatan" id="label">Catatan</label>
				<input type="text" class="form-control" id="catatan">
			</div>

 	<div class="form-group row">
		<button onclick="window.location.href='infojadwal.php'" type="button" class="btn btn-success col-form"> KEMBALI </button>
		<button id="tupdate" type="button" class="btn btn-success col-form"> PERBARUI </button>
		<span id="status"></span>
	</div>
</fieldset>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
 	<script type="text/javascript">
 	var id_ready;
    var tgl_ready;
    var id_vaksin;
    var nama_vaksin;
    var infojadwal;

    $(document).ready(function () {
    	$(document).ready(function(){

			$("#nama_vaksin").load("../api/infojadwal/read_one_infojadwal.php", "func_infojadwal=ambil_option_vaksin");
			
			$.ajax({
					type : "GET",
					url: "../api/infojadwal/read_one_infojadwal.php",
					data: {func_infojadwal : "ambil_single_data", id_ready: "<?php echo $_GET['id_ready']?>"},
					cache: false,
					success: function(data) {
                // Populate form fields
                $("#tgl_ready").val(data['tgl_ready']);
                $("#nama_vaksin").val(data['nama_vaksin']);
                $("#catatan").val(data['catatan']);
            }
			});

				$("#nama_vaksin").change(function(){
					nama_vaksin = $(this).children("option:selected").val();
				});

    		$("#tupdate").click(function(){
    			tgl_ready = $("#tgl_ready").val();
    			id_vaksin = $("#nama_vaksin").val();
                catatan = $("#catatan").val();

				infojadwal = {
					"tgl_ready" : tgl_ready,
					"nama_vaksin" : id_vaksin,
                    "catatan" : catatan
				};	
   
    			$("#loading").show();
    			$.ajax({
    			type : "POST",
    			url : "../api/infojadwal/update_infojadwal.php",
    			data : {infojadwal : infojadwal, func_infojadwal : "update_data_infojadwal", id_ready: "<?php echo $_GET['id_ready']?>"},
    			cache : false,
    			success : function(msg){
    				if(msg.message=="infojadwal was updated."){
    					alert("Data Berhasil Diperbarui");
    					window.location.href="infojadwal.php";
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