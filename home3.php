<?php
  session_start();
  if(!isset($_SESSION['username_admin'])){
    header("location: index.php");
  }
?>
<!DOCTYPE html>
<html>
  <head><html lang="en">
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes"> -->
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/images/logobesar.png" type="image/x-icon">
    <title>SIIMUN | ADMIN</title>
    <style type="text/css">
      .bawahnav {
        background-attachment: scroll;
        background-size: cover;
        background-origin: inherit;
      }
      #judul{
        font-size: 35px;
        margin: 0px 0px 0px 18px;
        font-family: "futura Md BT";
        color: black;
      } 
      #logonav{
        margin-left: 30px;
      }

      .t-inline-block{
        font-size: 50px;
      }
      #box{
        border: none;
      }
      .box{
        padding: 20px;
        margin-bottom: 10px;
      }
      #content{
        position: absolute;
        align-content: center;
      }

      .card{
        height:230px; 
        padding:30px; 
        margin:10px;
        background-color:#1B98D2; 
        color:white; 
        font-weight:bold;
        text-decoration:none;
        justify-content: center;
        font-size: 30px;
      }

      @media screen and (max-height:  640px) {
        #wraper {width: 640px; 
            position: relative;}
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
            .card-img-top {width: 50px;}
      }
    </style>
  </head>
  <body>

   <div id="wrapper">
    <div id="container">
      <nav class="navbar bg-light">
        <a class="navbar-brand">
          <img src="assets/images/logobesar.png" width="80px" height="80px" class="align-center" id="logonav">
          <p class="d-inline-block align-middle" id="judul">SIIMUN - ADMIN DASHBOARD </p>
        </a> 
        <div class="nav-item dropleft">
          <a class="nav-link " href="" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="img/login.png" width="70px"></a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="AccountAdmin/formEditAccountAdmin.php">Edit Account</a>
              <a class="dropdown-item" href="Crud_Account/accountPetugas.php">Account Petugas</a>
              <a class="dropdown-item" href="HistoryVaksin/historyVaksin.php">Riwayat Vaksin Anak</a>
              <a class="dropdown-item" href="kritiksaran/crudkritiksaran.php">Kritik dan Saran</a>
              <!-- <a class="dropdown-item" href="tentang/tentangposyandu.php">Tentang Posyandu</a> -->
              <!-- <a class="dropdown-item" href="Bantuan/bantuan.php">Bantuan</a> -->
              <a class="dropdown-item" href="logout.php">Logout</a>
             </div>
          </div> 
      </nav>
    </div>
    <div id="container align-self-center" class="bawahnav">
      <div class="box">
        <div class="row justify-content-lg-center">
          <div class="col-md-3">
          <center><a href="Crud_Imunisasi/crudImunisasi.php" class="card">Data Imunisasi</a></center>
          </div>
          <div class="col-md-3">
          <center><a href="Crud_Vaksin/crudVaksin.php" class="card">Data Vaksin</a></center>
          </div>
          <div class="col-md-3">
          <center><a href="Crud_Anak/crudAnak.php" class="card">Data Anak</a></center>
          </div>
        </div>
        <br>
        <div class="row justify-content-lg-center">
          <!-- <div class="col-md-3">
            <center><a href="Crud_Ibu/crudIbu.php" class="card">Data Ibu</a></center>
          </div> -->
          <div class="col-md-3">
          <center><a href="Crud_Petugas/crudPetugas.php" class="card">Data Petugas</a></center>
          </div>
          <div class="col-md-3">
          <center><a href="HistoryVaksin/historyVaksin.php" class="card">Riwayat Vaksin</a></center>
          </div>
        </div>
      </div>
    </div>
        
    
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script type="text/javascript">
    var nama_posyandu;
    var alamat_posyandu;
    var kel_posyandu;
    var kec_posyandu;
    var kota_kab_posyandu;
    var posyandu;

    $(document).ready(function() 
      $("#content").ready(function(){
      $.ajax({
		  type : "GET",	
          url : "../api/Posyandu/read.php",
          data : {func_posyandu : "ambil_data_posyandu"},
          cache : false,
          success : function(msg){
          data = msg.records;
          $("#content").val();
          });
      });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  </body>
</html>