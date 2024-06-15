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
    <link rel="shortcut icon" href="../assets/images/logobesar.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../tambahcss.css">
    <title>EDIT DATA PENDAFTARAN IMUNISASI</title>

</head>
<body style="background-repeat: repeat-y;">
    <?php
        include "../sidebar.html";
    ?>
    <fieldset>
        <form class="form-horizontal shadow p-3 mb-5 bg-body rounded bg-light">
            <h3>Edit Data Pendaftaran</h3><br>
            <div class="form-group">
                <label for="nik_anak" id="label">NIK Anak </label>
                <input type="text" class="form-control" id="nik_anak">
            </div>

            <div class="form-group">
                <label for="nama_anak" id="label">Nama Anak</label>
                <input type="text" class="form-control" id="nama_anak">
            </div>

            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="tanggal_lahir_anak" id="label">Tanggal Lahir Anak</label>
                    <input type="text" class="form-control" id="tanggal_lahir_anak">
                </div>

                <div class="form-group col-md-7">
                    <label for="nama_ibu" id="label">Nama Ibu</label>
                    <input type="text" class="form-control" id="nama_ibu">
                </div>
            </div>

            <div class="form-group">
                <label for="no_hp" id="label">No HP</label>
                <input type="text" class="form-control" id="no_hp">
            </div>

            <div class="form-group">
                <label for="alamat" id="label">Alamat</label>
                <input type="text" class="form-control" id="alamat">
            </div>


    <div class="form-group row">
        <button onclick="window.location.href='daftarimunisasi.php'" type="button" class="btn btn-success col-form"> KEMBALI </button>
        <button type="button" id="tupdate" class="btn btn-success col-form">PERBARUI</button> 
        <span id="status"></span>
    </div>
        </form>
    </fieldset> 

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var id_pendaftaran;
        var nama_anak;
        var nik_anak;
        var tanggal_lahir_anak;
        var nama_ibu;
        var no_hp;
        var alamat;
        var daftar;

    $(document).ready(function () {
        $(document).ready(function(){

            //$("#id_imun").load("prosesCrudImunisasi.php", "func_imun=ambil_data_imun");

            $.ajax({
                    type : "GET",
                    url: "../api/daftar/read_one_daftar.php",
                    data: {func_daftar : "ambil_single_data", id_pendaftaran: "<?php echo $_GET['id_pendaftaran']?>"},
                    cache: false,
                    success: function(msg){
                        //karna di server pembatas setiap data adalah |
                        //maka kita split dan akan membentuk array
                        data = msg;
                        nik_anak = data['nik_anak'];
                        nama_anak = data['nama_anak'];
                        tanggal_lahir_anak = data['tanggal_lahir_anak'];
                        nama_ibu = data['nama_ibu'];
                        no_hp = data['no_hp'];
                        alamat = data['alamat'];

                        //masukan ke masing - masing textfield
                        $("#nik_anak").val(nik_anak);
                        $("#nama_anak").val(nama_anak);
                        $("#tanggal_lahir_anak").val(tanggal_lahir_anak);
                        $("#nama_ibu").val(nama_ibu);
                        $("#no_hp").val(no_hp);
                        $("#alamat").val(alamat);
                    
                    }
            });

            $("#tupdate").click(function(){
                nik_anak = $("#nik_anak").val();
                nama_anak = $("#nama_anak").val();
                tanggal_lahir_anak = $("#tanggal_lahir_anak").val();
                nama_ibu = $("#nama_ibu").val();
                no_hp = $("#no_hp").val();
                alamat = $("#alamat").val();

                //data = "&tgl_imun="+tgl_imun+"&usia_saat_vaksin="+usia_saat_vaksin+"&tinggi_badan="+tinggi_badan+"&berat_badan="+berat_badan+"&periode="+periode;
                daftar = {
                    "nik_anak" : nik_anak,
                    "nama_anak" : nama_anak,
                    "tanggal_lahir_anak" : tanggal_lahir_anak,
                    "nama_ibu" : nama_ibu,
                    "no_hp" : no_hp,
                    "alamat" : alamat
                };  

                
                $("#loading").show();
                $.ajax({
                type : "POST",
                url : "../api/daftar/update_daftar.php",
                data : {daftar : daftar, func_daftar : "update_data_daftar", id_pendaftaran : "<?php echo $_GET['id_pendaftaran']?>"},
                cache : false,
                success : function(msg){
                    if(msg.message=="daftar was updated."){
                        alert("Data daftar Berhasil Diperbarui");
                        window.location.href="daftarimunisasi.php";
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