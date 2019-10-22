<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">

    <title>Medidor de Nivel da SCMB</title>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
      <div class="status" id="status">
        <script type="text/javascript">
            var table = '';
            var rows = 8;

            table += '<th>' + '<b>' + 'ULTIMA LEITURA' + '</b>' + '</th>';

            for (var r = 0; r < rows; r++) {
              table += '<tr>';
                  switch (r) {
                    case 0:
                      table += '<td>' + '<b>' + "Distancia" + '</b>' + '</td>';
                    break;
                    case 1:
                      table += '<td>' + '<p id="distance">' + "00.00 cm" + '</p>' + '</td>';
                    break;
                    case 2:
                      table += '<td>' + '<b>' + "Volume: " + '</b>' + '</td>';
                    break;
                    case 3:
                      table += '<td>' + '<p id="volume">' + "00.00 L" + '</p>' + '</td>';
                    break;
                    case 4:
                      table += '<td>' + '<b>' + "Capacidade: " + '</b>' + '</td>';
                    break;
                    case 5:
                      table += '<td>' + '<p id="percentage">' + "00.00 %" + '</p>' + '</td>';
                    break;
                    case 6:
                      table += '<td>' + '<b>' + "Data e hora: " + '</b>' + '</td>';
                    break;
                    case 7:
                      table += '<td>' + '<p id="time">' + "xxxx-xx-xx 00:00:00" + '</p>' +'</td>';
                    break;
                    }
                table += '</tr>';
            }
            document.write('<table style="width:35%">' + table + '</table>');
        </script>
      </div>
    </div>
  </body>

  <script type="text/javascript">
    	window.onload = function() {
        loaddata();
        };
        function loaddata(){
        	$.ajax({
        		url:"https://scmb-esp32.000webhostapp.com/api/read.last.php",
        		type: 'GET',
        		dataType: "json",
        		success: function(data){
        			var dis = (data["data"][0]["dis"]);
        			document.getElementById("distance").innerHTML = dis + " cm";
        			var vol = (data["data"][0]["vol"]);
        			document.getElementById("volume").innerHTML = vol + " L";
        			var pct = (data["data"][0]["pct"]);
        			document.getElementById("percentage").innerHTML = pct + " %";
        			var time_create = (data["data"][0]["time_create"]);
        			document.getElementById("time").innerHTML = time_create;
        		},
        	});
        }
        window.setInterval(function(){ loaddata(); }, 1000);
  </script>
  <footer>
    <div class="footer_text" id="footer_text">
      Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
    </div>
  </footer>
</html>
