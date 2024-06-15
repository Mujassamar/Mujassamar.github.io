
<DOCTYPE! html >
<html lang="en">
  <head>
    <!-- Bootstrap CSS -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Login</title>
    <link rel="shortcut icon" href="../assets/images/logobesar.png" type="image/x-icon">
    <style type="text/css">
      body{

        background-size: 100%;
        background-color: #394360;
        /* background:url(img/Menu/bggg2.png);
        background-repeat: repeat-y;
        overflow-y: hidden;
        
      }
      #container{
        overflow: hidden;
      }
      #Login{
        float: left;
        margin-top: 5px;
      }
      #Mamah{
        padding-left:700px;
        padding-top: 180px;
      }
      .form1{
          margin: -415px 205px;
       }
      @media screen and (max-width: 720px) {  
        #Mamah{
          display: none;
          } */
      }

    </style>
  </head>
	<body>
    <div id="wrapper">
      <div id="container">
        <div id="Login">
          
          <div class="form1">
            <div class="container">
                <center>
                  <br>
                <img src="assets/images/logobesar.png" style="padding-top: 80px; margin-bottom: 40px;" />
                
                <form class="form-horizontal" name="formlogin" onsubmit = "return validation()">
                    <label style="padding-left:0px; color:#fff; font-weight:bold;">Username</label>
                    <input type="text" name="username" id="username" placeholder="username" class="" style="height: 42px; margin-left: 20px; margin-top: 3px; border: none;">
                    <br><br>
                    <label style="padding-left:0px; color:#fff; font-weight:bold;">Password</label>
                    <input type="password" name="password" id="password" placeholder="password" style="height: 42px; margin-left: 20px; margin-top: 16px; border: none;">
                    <br><br>
                    <button type="button" id="tombollogin" style="width: 150px; height: 30px; margin-top: 17px; background-color: #0066ff; border-radius: 5px; border-color: #0066ff; color: white;">Login</button>
                </form>
                <center>
            </div>
        </div>
        <div id="Mamah">
          <!-- <img src="img/Login/Mamah_.png" style=" margin: -150px 45px 0px -80px;"> -->
        </div>
          <!-- <br><center><p>Repost by <a href='https://stokcoding.com/' title='StokCoding.com' target='_blank'>StokCoding.com</a></p></center> --> 
      </div>
    </div>
      <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
      <script type="text/javascript">
        var username;
        var password;
        var data_login;

        $(document).ready(function(){
          $("#tombollogin").click(function(){
            username = $("#username").val();
            password = $("#password").val();

            data_login = {
              "username" : username,
              "password" : password
            };

            $.ajax({
              type : "POST",
              url : "api/Login/syslogin.php",
              data : {data_login : data_login},
              cache : false,
              success : function(msg){
                if(msg.message == "admin berhasil login"){
                  window.location.href="Crud_Imunisasi/prosesCrudImunisasi.php";
    				    } else if(msg.message == "petugas berhasil login"){
                  window.location.href="Petugas/Crud_Imunisasi/crudImunisasi.php";
                } else  {
    					    alert("username dan password tidak sesuai");
    				    }
                }
              
            });
          });
        });

      </script>
      <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
      </script>
  </body>
</html>