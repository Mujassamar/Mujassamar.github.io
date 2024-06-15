<?php
  session_start();
  if(!isset($_SESSION['username_admin'])){
    header("location: ../index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/logobesar.png" type="image/x-icon">
    <title>Info Jadwal Imunisasi</title>
    <style type="text/css">
        body {
            font-family: "Futura Md BT";
            /* background-image: url(../img/Menu/bg1.png); */
            background-size: cover;
            background-repeat: repeat-y;
        }
        .form-group{
            margin-left: -15px;
        }
    </style>
</head>

<body>
    <?php
        include "../sidebar.html";
    ?>

    <div id="content1" style="margin-left: 230px; margin-top: 130px;">
    <h1 >Info Jadwal Imunisasi</h1>
    <button onclick="window.location.href='formtambahjadwal.php'" class="btn shadow-sm p-2 bg-success rounded text-white" id="button" style="margin-top: 10px;">Tambah Jadwal Imunisasi</button><br><br>
    <!-- <table id="ttable"border="1" >
      <button onclick="window.location.href='form_tambah_vaksin.php'">Tambah Data Vaksin</button> -->
      <table id="ttable" border="0" class="table table-hover table-light table-striped">
        <thead class="" style="background-color:#394360;">
            <tr class="text-white">
                <th width="10%">ID</th>
                <th>Tanggal Imunisasi</th>
                <th>Vaksin Tersedia</th>
                <th>Catatan</th>
                <th colspan=2 style="text-align: center; width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody id="content">
        </tbody>
      </table>
      <br>
      <div id="contentPagination"></div>
      <br>
      <span id="status"></span>
      <!-- <button type="button" onclick="window.location.href='../home3.php'" class="btn shadow-lg p-2 bg-success rounded" id="buttonn" style="color: white;">Kembali</button><br><br> -->
   </div>
    <button type="button" onclick="window.location.href='../home3.php'" class="btn shadow-sm p-2 bg-success rounded" id="button">Kembali</button>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var id_ready;
    var tgl_ready;
    var nama_vaksin;
    var catatan;
    var infojadwal;
    var jumlahHalaman;
    var halamanAktif;
    $(document).ready(function() {
      $("#ttable").val();
    });

	  function getAllData(){
      $.ajax({
		      type : "GET",	
          url : "../api/infojadwal/read_infojadwal.php",
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
              content+= "<td class='text-center'>"+element.id_ready+"</td>"+
              "<td>"+element.tgl_ready+"</td>" +
              "<td>"+element.nama_vaksin+"</td>" +
              "<td>"+element.catatan+"</td>" +
              '<td><button onclick="window.location.href=\'formeditjadwal.php?id_ready='+ element.id_ready +'\'" class="btn btn-info" style="padding: 0px 10px 0px 10px;">EDIT</button></td>' +
              '<td><button class="tdelete btn btn-danger" style="padding: 0px 10px 0px 10px;" value="'+element.id_ready+'" >HAPUS</button></td>'
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
      $("#id_ready").change(function() {
        id_ready = $("#id_ready").val();
      });

      $(document).on('click', '.tdelete', function(){
        var yakin = confirm("Apakah anda yakin ingin menghapus data ? ");
        if(yakin == true){
          $.ajax({
          type : "POST",
					url : "../api/infojadwal/delete_infojadwal.php",
					data : {func_infojadwal : "delete", id_ready : $(this).val()},
					cache: false,
					success: function(msg){
						if (msg.message=="infojadwal was deleted.") {
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>