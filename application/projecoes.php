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
      <div class="projecoes_capacidade" id="projecoes_capacidade" style="position: relative; border: 10px; margin: auto; width: 90%; height: 400px">
        <b><p style = 'font: arial; color: #666'>Carregando...</p></b>
      </div>
      <div class="projecoes_volume" id="projecoes_volume" style="position: relative; border: 10px; margin: auto; width: 90%; height: 400px"></div>
      <div class="projecoes_distancia" id="projecoes_distancia" style="position: relative; border: 10px; margin: auto; width: 90%; height: 400px"></div>
    </div>
  </body>

  <footer>
    <div class="footer_text" id="footer_text">
      Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
    </div>
  </footer>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    setInterval(function(){
      var time = [];
      var pct = [];
      var result_pct = [];
      $.ajax({
        url:"https://scmb-esp32.000webhostapp.com/api/read.last.few.php",
        data: "",
        type: 'GET',
        dataType: "json",
        success: function(data){
          var a = Object.keys(data['level01']).length;
          for (var i = 0; i < a; i++){
            pct[i] = JSON.parse((data["level01"][i]["pct"]));
            time[i] = (data["level01"][i]["time_create"]);
          }

          for (var i = a-1; i >= 0; i--)
            result_pct.push([time[i], pct[i]]);

          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data_pct = new google.visualization.DataTable();
              data_pct.addColumn('string', 'Data');
              data_pct.addColumn('number', 'Capacidade [%]');
              data_pct.addRows(result_pct);
              var options = {
                title:'Capacidade (%)',
                curveType:'function',
                lineWidth: 3,
                legend: { position:'bottom' },
                colors:  ['#11f'],
                animation: {
                  easing:'inAndOut',
                  duration:1000,
                  startup:false
                },
                backgroundColor:'white',
                axisTitlesPosition:'in',
                chartArea: {
                  top:30,
                  bottom:125,
                  heigth:'50%',
                  width:'75%'
                },
                enableInteractivity: true,
                explorer: {keepInBounds: true},
                focusTarget: 'category',
                fontSize: 12,
                vAxis: {
                  direction: 1,
                  textPosition: 'out',
                  minValue: 0,
                  maxValue: 100
                },
                hAxis: {
                  textPosition: 'out',
                  slantedTextAngle: 30,
                },
                interpolateNulls: true,
              };
              var chart = new google.visualization.AreaChart(document.getElementById('projecoes_capacidade'));
              chart.draw(data_pct, options);
            }
          },
      });
    }, 10000);
  </script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    setInterval(function(){
      var time = [];
      var vol = [];
      var result_vol = [];
      $.ajax({
        url:"https://scmb-esp32.000webhostapp.com/api/read.last.few.php",
        data: "",
        type: 'GET',
        dataType: "json",
        success: function(data){
          var a = Object.keys(data['level01']).length;
          for (var i = 0; i < a; i++){
            vol[i] = JSON.parse((data["level01"][i]["vol"]));
            time[i] = (data["level01"][i]["time_create"]);
          }

          for (var i = a-1; i >= 0; i--)
            result_vol.push([time[i], vol[i]]);

          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data_vol = new google.visualization.DataTable();
              data_vol.addColumn('string', 'Data');
              data_vol.addColumn('number', 'Volume [L]');
              data_vol.addRows(result_vol);
              var options = {
                title: 'Volume (L)',
                curveType: 'function',
                lineWidth: 3,
                legend: { position: 'bottom' },
                colors: ['#55f'],
                animation: {
                  easing:'inAndOut',
                  duration:1000,
                  startup:false
                },
                backgroundColor:'white',
                axisTitlesPosition:'in',
                chartArea: {
                  top:30,
                  bottom:125,
                  heigth:'50%',
                  width:'75%'
                },
                enableInteractivity: true,
                explorer: {keepInBounds: true},
                focusTarget: 'category',
                fontSize: 12,
                vAxis: {
                  direction: 1,
                  textPosition: 'out',
                  minValue: 0,
                },
                hAxis: {
                  textPosition: 'out',
                  slantedTextAngle: 30,
                },
                interpolateNulls: true,
              };
              var chart = new google.visualization.AreaChart(document.getElementById('projecoes_volume'));
              chart.draw(data_vol, options);
            }
          },
      });
    }, 10000);
  </script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    setInterval(function () {
      var time = [];
      var dis = [];
      var result_dis = [];
      $.ajax({
        url:"https://scmb-esp32.000webhostapp.com/api/read.last.few.php",
        data: "",
        type: 'GET',
        dataType: "json",
        success: function(data){
          var a = Object.keys(data['level01']).length;
          for (var i = 0; i < a; i++){
            dis[i] = JSON.parse((data["level01"][i]["dis"]));
            time[i] = (data["level01"][i]["time_create"]);
          }

          for (var i = a-1; i >= 0; i--)
            result_dis.push([time[i], dis[i]]);

          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart);
          function drawChart() {
            var data_dis = new google.visualization.DataTable();
              data_dis.addColumn('string', 'Data');
              data_dis.addColumn('number', 'Distância [cm]');
              data_dis.addRows(result_dis);
              var options = {
                title: 'Distância (cm)',
                curveType: 'function',
                lineWidth: 3,
                legend: { position: 'bottom' },
                colors: ['#99f'],
                animation: {
                  easing:'inAndOut',
                  duration:1000,
                  startup:false
                },
                backgroundColor:'white',
                axisTitlesPosition:'in',
                chartArea: {
                  top:30,
                  bottom:125,
                  heigth:'50%',
                  width:'75%'
                },
                enableInteractivity: true,
                explorer: {keepInBounds: true},
                focusTarget: 'category',
                fontSize: 12,
                vAxis: {
                  direction: 1,
                  textPosition: 'out',
                  minValue: 0,
                  maxValue: 400,
                },
                hAxis: {
                  textPosition: 'out',
                  slantedTextAngle: 30,
                },
                interpolateNulls: true,
              };
              var chart = new google.visualization.AreaChart(document.getElementById('projecoes_distancia'));
              chart.draw(data_dis, options);
            }
          },
      });
    }, 10000);
  </script>
</html>
