<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">

    <title>Medidor de Nivel da SCMB</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/application.css">
  </head>

  <body>
      <div class="row">
        <div class="column">
          <img class="ipbLogo" src="css/ipb.png" alt="ipb" style="padding-top:15px;">
        </div>
        <div class="column">
          <div class="logo">
            <b><h3>SCM-Bragança</h3></b>
            <h7>Mais que solidariedade...</h7>
          </div>
        </div>
        <div class="column"></div>
      </div>

      <div class="initialMenu">
        <table>
            <tr>
              <th><a href="index.php"><button id="btn_inicio"><b>início</b></button></a></th>
              <th><a href="status.php"><button id="btn_status"><b>status</b></button></a></th>
              <th><a href="historico.php"><button id="btn_historico"><b>histórico</b></button></a></th>
              <th><a href="projecoes.php"><button id="btn_projecoes"><b>projeções</b></button></th>
              <th><a href="contacto.php"><button id="btn_contacto"><b>contacto</b></button></th>
              <th><a href="sobre.php"><button id="btn_sobre"><b>sobre</b></button></a></th>
            </tr>
        </table>
      </div>

  	<div class="content" id="content">
      <div class="historico" id="historico">
       <br>
       <table class="myTable" id="myTable" class="display" style="width:85%;">
         <thead>
           <tr>
             <th><b>data e hora</b></th>
             <th><b>distancia (cm)</b></th>
             <th><b>volume (L)</b></th>
             <th><b>porcentagem (%)</b></th>
           </tr>
         </thead>
         <tfoot>
           <tr>
             <th><b>data e hora</b></th>
             <th><b>distancia (cm)</b></th>
             <th><b>volume (L)</b></th>
             <th><b>porcentagem (%)</b></th>
           </tr>
         </tfoot>
       </table>
     </div>
  	</div>
    <br>
  </body>
    <footer>
      <div class="footer_text" id="footer_text">
        Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
      </div>
    </footer>
    <script type="text/javascript">
          $(document).ready(function() {
              $('#myTable').DataTable( {
                  "ajax": "https://scmb-esp32.000webhostapp.com/api/read.all.php",
                  "columns": [
                    { "data": "time_create" },
                    { "data": "dis" },
                    { "data": "vol" },
                    { "data": "pct" },
                  ]
              } );
          } );
    </script>
</html>
