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
        <img class="ipbLogo" src="css/ipb.png" alt="ipb">
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
      <div class="contact-form">
        <form id="contact-form" method="post" action="contact.form.php" style='margin: auto; width: 75%'>
          <h5><b>FORMULÁRIO DE CONTACTO EM CASO DE AVARIA</b></h5>
          <p style='font-size: 12px; opacity: 0.75'>Enviar um email. Todos os campos com um asterisco (*) são obrigatórios.</p><br>
          <p align="left" style='font-size: 15px;'><b>Telemóvel para contacto directo: xxxx-xxxx<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp; &emsp;&emsp;&emsp;&emsp;xxxx-xxxx</b></p>
          <input name="name" type="text" class="form-control" placeholder="Nome">
          <br>
          <input name="subject" type="text" class="form-control" placeholder="Assunto (*)" required>
          <br>
          <input name="email" type="email" class="form-control" placeholder="Seu email (*)" required>
          <br>

          <textarea name="message" class="form-control" placeholder="Descrição do problema (*)" row="20" required style='margin:auto; width:100%; height:150px'></textarea><br>
          <div class="linha">
            <div class="coluna" style="float: left; width: 50%">
              <p ><input type="submit" class="form-control submit" value="ENVIAR EMAIL"></p>
            </div>
            <div class="coluna">
              <p align="right" style="font-size: 12px">Enviar cópia para mim&emsp;<input name="sendToMe" type="checkbox" value="Yes"></p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
  <footer>
    <div class="footer_text" id="footer_text">
      Sistema desenvolvido para a Santa Casa da Misericórdia de Bragança
    </div>
  </footer>
</html>
