<?php
  session_start();
  if(!isset($_SESSION['username_admin'])){
    header("location: ../index.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="shortcut icon" href="../assets/images/logobesar.png" type="image/x-icon">

  <title>DATA IMUNISASI</title>
  <style type="text/css">
      body{
        font-family: "Futura Md BT";
        /* background-image: url(../img/Menu/bg1.png); */
        background-color: blue;
        background-repeat: repeat;
        background-size: cover;
      }
      #button{
        color: white;
      }

      
    </style>
</head>
<body>
  <?php
    include "../sidebar.html";
  ?>
<div id="content1" style="margin-left: 230px; margin-top: 130px;">
  <h1>Data Imunisasi</h1>
  
  <div class="row">
  <div class="col-5">
  <button onclick="window.location.href='formtambah.php'" class="btn shadow-sm p-2 bg-success rounded" id="button" style="margin-top: 10px;">Tambah Data Imunisasi</button><br><br>
  </div>
  <div class="col">
          <!-- <form action="cetak_imunisasi.php" method="GET"> -->
          <!-- <div class="row">
              <div class="col-5">
                  <input class="form-control" name="fromDate" type="date" id="fromDate" value="">

              </div>
              <div class="col-5">
                  <input class="form-control" name="toDate" type="date" id="toDate" value="">
                </div>
                <div class="col">
                    
                    <button type="submit" class="btn shadow-sm p-2 bg-success rounded" id="cetakHasil" style="margin-top: 10px;">Cetak Hasil</button>
              </div>
          </div> -->
          <!-- </form> -->
    </div>
  </div>
  
  <table id="ttable" border="0" class="table table-hover table-light table-striped">
    <thead class="" style="background-color:#394360;">
        <tr class="text-white text-center align-middle">
        <th class="align-middle" style="width: 10%;">ID Imunisasi</th>
            <!-- <th class="align-middle">Tanggal Imunisasi</th>
            <th class="align-middle">Nama Anak</th>
            <th class="align-middle">Nama Ibu</th>
            <th class="align-middle">Usia Saat Vaksin</th>
            <th class="align-middle">Tinggi Badan</th>
            <th class="align-middle">Berat Badan</th>
            <th class="align-middle">Nama Petugas</th>
            <th class="align-middle">Nama Vaksin</th>
            <th colspan=2 style="text-align: center;" class="align-middle">Aksi</th> -->
            <!-- <th class="align-middle" style="width: 10%;">ID Imunisasi</th> -->
            <th class="align-middle">Tanggal Imunisasi</th>
            <th class="align-middle">Nama Anak</th>
            <th class="align-middle">Usia Saat Vaksin</th>
            <th class="align-middle">Tinggi Badan</th>
            <th class="align-middle">Berat Badan</th>
            <th class="align-middle">Nama Ibu</th>
            <th class="align-middle">Nama Vaksin</th>
            
            <!-- <th class="align-middle">Id Petugas</th> -->
            <th colspan=2 style="text-align: center;" class="align-middle">Aksi</th>

        </tr>
    </thead>
    <tbody id="content">
    
    </tbody>
  </table>
  <br>
  <div id="contentPagination"></div>
  <br>
  <span id="status"></span>
	<!-- <button onclick="window.location.href='../home3.php'" class="btn shadow-sm p-2 bg-success rounded" id="button">Kembali</button><br><br><br> -->
</div>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript">
    var id_pendaftaran;
    var tgl_imunisasi;
    var id_imunisasi;
    // var tgl_imunisasi;
    var nama_anak;
    // var nama_ibu;
    var usia_saat_vaksin;
    var tinggi_badan;
    var berat_badan;
    // var nama_petugas;
    var nama_vaksin;
    var imunisasi;
    var jumlahHalaman;
    var halamanAktif;
    $(document).ready(function() {
      $("#ttable").val();
    });

    // $(document).ready(function(){
    //   $("#id_imun").load("http://localhost/Aplikasi_EPosyandu/api/Imunisasi/read.php", "func_imun=ambil_data_imun");

	  function getAllData(){
      $.ajax({
		      type : "GET",	
          url : "../api/Imunisasi2/read_imunisasi.php",
          data : {page : "<?php $page = isset($_GET['page']) ? $_GET['page'] : 1; echo $page ?>"},
          cache : false,
          success : function(msg){
          data = msg.records;
          jumlahHalaman = msg['jumlahHalaman'];
          halamanAktif = parseInt(msg['halamanAktif']);
          console.log(msg);
          var content = "";
            for (let index = 0; index < data.length; index++) {
              const element = data[index];
              content+="<tr>";
              content+= "<td class='text-center'>"+element.id_imunisasi+"</td>"+
              "<td>"+element.tgl_imunisasi+"</td>" +
              "<td>"+element.nama_anak+"</td>" +
              "<td>"+element.usia_saat_vaksin+" bulan</td>" +
              "<td>"+element.tinggi_badan+" cm</td>" +
              "<td>"+element.berat_badan+" kg</td>"+
              "<td>"+element.nama_ibu+"</td>" +
              "<td>"+element.nama_vaksin+"</td>" +
              
            //   "<td>"+element.id_petugas+"</td>" +
            //  "<td>"+element.tgl_imunisasi+"</td>" +
            //   "<td>"+element.nama_anak+"</td>" +
            //   "<td>"+element.nama_ibu+"</td>" +
            //   "<td>"+element.usia_saat_vaksin+"</td>"+
            //   "<td>"+element.tinggi_badan+"</td>" +
            //   "<td>"+element.berat_badan+"</td>" +
            //   "<td>"+element.nama_petugas+"</td>" +
            //   "<td>"+element.nama_vaksin+"</td>" +
              '<td><button onclick="window.location.href=\'formedit.php?id_imunisasi='+ element.id_imunisasi +'\'" class="btn btn-info" style="padding: 0px 10px 0px 10px;">EDIT</button></td>' +
              '<td><button class="tdelete btn btn-danger" style="padding: 0px 10px 0px 10px;" value="'+element.id_imunisasi+'" >HAPUS</button></td>'
              content+="</tr>";
            }
            var contentPagination = "";
            contentPagination = "<h5>";
            if (halamanAktif > 1){
              contentPagination += "<a href='?page=" + (halamanAktif - 1) + "' style='color:silver'><b>&#10094;</b></a>";
            } 
            
            contentPagination += "&ensp;" + halamanAktif + "&ensp;of&ensp;" + jumlahHalaman + " &ensp;";

            if (halamanAktif < jumlahHalaman){
              contentPagination += "<a href='?page=" + (halamanAktif + 1) + "' style='color:silver'><b>&#10095;</b></a>";
            }
            contentPagination += " &#9;</h5>";
            content+="</tr>";
            $("#content").html(content);
            $("#contentPagination").html(contentPagination);
          }
          
        });
      }
      getAllData();
      $("#id_imunisasi").change(function() {
        id_imunisasi = $("#id_imunisasi").val();
      });

      $(document).on('click', '.tdelete', function(){
        var yakin = confirm("Apakah anda yakin ingin menghapus data ? ");
        if(yakin == true){
          $.ajax({
          type : "POST",
					url : "../api/Imunisasi2/delete_imunisasi.php",
					data : {func_imunisasi : "delete", id_imunisasi : $(this).val()},
					cache: false,
					success: function(msg){
						if (msg.message=="imunisasi was deleted.") {
              getAllData();
						} else {
							$("#status").html("EROR. . .");
						}
						$("#loading").hide();
					}
				});
        }
        else{
          alert("data tidak jadi dihapus");
        }
			
			});

  </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>