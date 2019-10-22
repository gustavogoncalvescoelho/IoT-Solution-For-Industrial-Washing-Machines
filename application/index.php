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
      <div class="index" id="index">
        <div class="linha">
          <div class="coluna" style="margin-left: 10px; height: 360px; float: left; width: 48%">
            <b>
              <p style="margin-top: 25px; margin-left: 10%; float:left; color: white; font-family: Arial; font-size: 14px;">Capacidade actual é de </p>
              <p id="pct-actual" style="margin-top: 25px; margin-left: 3px; float:left; color: white; font-family: Arial; font-size: 14px;">x %</p>
              <p style="margin-top: 30px; float:left; margin-left: 10%; color: white; font-family: Arial; font-size: 14px;">O sistema está</p>
              <p id="verificacao" style="margin-top: 30px; float:left; margin-left: 3px; color: white; font-family: Arial; font-size: 14px;"></p>
              <p style="margin-top: 30px; float:left; margin-left: 10%; color: white; font-family: Arial; font-size: 14px;">Tempo estimado restante é de</p>
              <p id="tempo-predict" style="clear: both; margin-left: 10%; float: left; display: block; position: relative; color: white; font-family: Arial; font-size: 14px;">...</p>
              <p style="margin-top: 30px;clear: both; display: block; position: relative; float:left; margin-left: 10%; color: white; font-family: Arial; font-size: 14px;">Previsão para acabar em</p>
              <p id="data-predict" style="text-align: left; width: 75%; clear: both; margin-left: 10%; float: left; display: block; position: relative; float:left; color: white; font-family: Arial; font-size: 12px;">...</p>
            </b>
          </div>
          <div class="coluna" id="predict" style="float: right; width: 50%; height: 350px">
            <p style="font: arial; font-size: 14px; color: '#666'; padding-top: 150px;"><b>Carregando...</b></p>
          </div>
        </div>
          <p style="margin-left: auto; margin-right: auto; background: #3a6070; border-radius: 4px; position: absolute; bottom: 0px; width: 75%; font-family: Arial; color: white; font-size: 12px;">
            Estimativa calculada com base nas medições do dispositivo.
        </p>
    </div>
  </div>
  </body>

  <footer>
    <div class="footer_text" id="footer_text">
      Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
    </div>
  </footer>

  <script type="text/javascript">
    window.onload = function() {
      loaddata();
    };
    function loaddata(){
      $.ajax({
        url: "https://scmb-esp32.000webhostapp.com/api/readFromPredict.php",
        type: "GET",
        data: "",
        dataType: "json",
        success: function(data){
          var pct = JSON.parse(data["predict"][0]["pct"]);
          document.getElementById("pct-actual").innerHTML = pct + " %";

          if ((data["predict"][0]["verify"]) == 1){
            document.getElementById("verificacao").innerHTML = "carregado/carregando.";
            document.getElementById("data-predict").innerHTML = "...";
            document.getElementById("tempo-predict").innerHTML = "...";
          }else{
            document.getElementById("verificacao").innerHTML = "descarregando.";

            var predict = new Date(data["predict"][0]["time_predict"]);
            document.getElementById("data-predict").innerHTML = predict;

            var actual_time = new Date(data["predict"][0]["time_create"]);
            var dif = (predict - actual_time);

            days = Math.floor(dif / (24*60*60*1000));
            daysms=dif % (24*60*60*1000);
            hours = Math.floor((daysms)/(60*60*1000));
            hoursms=dif % (60*60*1000);
            minutes = Math.floor((hoursms)/(60*1000));
            minutesms=dif % (60*1000);
            sec = Math.floor((minutesms)/(1000));

            if (days > 0){
              document.getElementById("tempo-predict").innerHTML = days + " dias "+ hours + "h" + minutes + " min " + sec + "s";
            }else if (hours > 0) {
              document.getElementById("tempo-predict").innerHTML = hours + "h " + minutes + "min " + sec + "s";
            }else if (minutes > 0) {
              document.getElementById("tempo-predict").innerHTML = minutes + " minutos e " + sec + " segundos";
            }else{
              document.getElementById("tempo-predict").innerHTML = sec + " segundos";
            }
          }

        }
      });
    }
    window.setInterval(function(){ loaddata(); }, 1000);
  </script>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    setInterval(function(){
      var pct = [];
      var pct_old = [];
      var time_create = [];
      var result_predict = [];
      var time_predict = [];
      var time_old = [];
      $.ajax({
        url:"https://scmb-esp32.000webhostapp.com/api/readFromPredict.php",
        data:"",
        type:"GET",
        dataType:"json",
        success: function(data){
          time_predict = (data["predict"][0]["time_predict"]);
          time_old = (data["predict"][0]["time_old"]);
          pct_old = JSON.parse(data["predict"][0]["pct_old"]);

          var a = Object.keys(data["predict"]).length;
          if ((data["predict"][0]["verify"]) == 1){
            // As verify is equal to 1, the system is loading/loaded
            // Therefore, the system will show the graph from the last loading period
            for (var i = 0; i < a; i++){
              pct[i] = JSON.parse((data["predict"][i]["pct"]));
              time_create[i] = (data["predict"][i]["time_create"]);
              if ((data["predict"][i]["verify"]) == 0){
                break;
              }
            }

            for (var i = a-1; i >= 0; i--)
              result_predict.push([new Date(time_create[i]), pct[i]]);

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data_predict = new google.visualization.DataTable();
                data_predict.addColumn('datetime', 'Data');
                data_predict.addColumn('number', 'Capacidade Actual');
                data_predict.addRows(result_predict);
                var options = {
                  title: 'Estimativa de Consumo',
                  lineWidth: 4,
                  legend: 'bottom',
                  backgroundColor: { fill: "#3a6070", fillOpacity: 0.001},
                  colors: ['blue'],
                  chartArea: {
                    heigth:'10%',
                    width:'75%'
                  },
                  hAxis: {gridlines: {count: 0}},
                  vAxis: {minValue: 0, maxValue: 100, gridlines: {count: 4 }}
                };
                var chart = new google.visualization.AreaChart(document.getElementById('predict'));
                chart.draw(data_predict, options);
            }
          }else{
            for (var i = 0; i < a; i++){
              pct[i] = JSON.parse((data["predict"][i]["pct"]));
              time_create[i] = (data["predict"][i]["time_create"]);
              if (time_create[i] == time_old){
                break;
              }
            }
            for (var i = a-1; i >= 0; i--){
              result_predict.push([new Date(time_create[i]), pct[i], null]);
            }
            result_predict.push([new Date(time_create[0]), null, pct[0]]);
            result_predict.push([new Date(time_predict), null, 0]);

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
              var data_predict = new google.visualization.DataTable();
                data_predict.addColumn('datetime', 'Data');
                data_predict.addColumn('number', 'Capacidade Actual');
                data_predict.addColumn('number', 'Estimativa');
                data_predict.addRows(result_predict);
                var options = {
                  title: 'Estimativa de Consumo',
                  lineWidth: 4,
                  legend: 'bottom',
                  backgroundColor: { fill: "#3a6070", fillOpacity: 0.001},
                  colors: ['blue','red'],
                  series: {1: {lineDashStyle: [4,4]} },
                  chartArea: {
                    heigth:'10%',
                    width:'75%'
                  },
                  hAxis: {gridlines: {count: 0}},
                  vAxis: {minValue: 0, maxValue: 100, gridlines: {count: 4 }}
                };
                var chart = new google.visualization.AreaChart(document.getElementById('predict'));
                chart.draw(data_predict, options);
            }
          }
        }
      });
    }, 1000);
  </script>
</html>
