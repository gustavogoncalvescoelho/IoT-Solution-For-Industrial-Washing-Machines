<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">

    <title>Medidor de Nivel da SCMB</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
   		<div class="sobre" id="sobre">
          <p style = 'margin: auto; width: 75%; line-height: 28px; font-family: Arial;color: white;font-size: 18px;' id="sobre1">
        &emsp;O sistema desenvolvido tem como objetivo realizar a monitorização de reservatórios para a Santa Casa da Misericórdia de Bragança.
        <br>&emsp;O projeto foi realizado pelo aluno Gustavo Gonçalves Coelho sobre a orientação do Prof.Dr. João Paulo Coelho para obtenção do título de Mestrado em Engenharia Industrial pelo Instituto Politécnico de Bragança.
        	</p>
       	</div>
    </div>
  </body>
  <footer>
    <div class="footer_text" id="footer_text">
      Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
    </div>
  </footer>
</html>
