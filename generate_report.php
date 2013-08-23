<?php

$json = json_decode(file_get_contents('results/liquid/current/results.json'), true);

function showResult($result) {
    if($result == "pass") {
        return '<span class="label label-success">Pass</span>';
    } else {
        return '<span class="label label-danger">Fail</span>';
    }
}

ob_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <style>
        body {
            background: #f8f8f8;
        }
        </style>

  </head>
  <body>

    <div class="container">

      <!-- Jumbotron -->
      <div class="jumbotron">
        <h1>Polyglot Template Test</h1>
        <p class="lead">Tests written in a Polyglot format so that cross platform templating languages can be tested across different language implementations without the need to rewrite as many tests and hopefully create consistency between languages. This will make users and designers comfortable with working and interacting across different backend platforms.</p>
      </div>

<div class="col-lg-12">
            <h2>Results - Liquid</h2>
            <p>Results of each Liquid library against the Liquid tests.</p>
<div class="panel">
  <div class="panel-body">
      <?php foreach($json as $typeName => $type) { ?>
          <h1><?=ucwords($typeName)?></h1>
                <?php foreach($type as $tagName => $tag) { ?>
        <h2><?=ucwords($tagName)?></h2>
              
           
<table class="table table-hover">
    <thead>
        <tr>
            <th>Test</th>
            <th>Template</th>
            <th>Data</th>
            <th style="width:50px;">liquid</th>
            <th style="width:50px;">liquid-node</th>
            <th style="width:50px;">php-liquid</th>
            <th style="width:50px;">swig</th>
            <th style="width:50px;">twig</th>
        </tr>
    </thead>
    <tbody>
              <?php foreach($tag as $testGroupName => $testGroup) { ?>
                  <?php foreach($testGroup as $test) { ?>
        <tr>
            <td><?=ucwords(nl2br($testGroupName))?></td>
            <td><?=nl2br($test['template'])?></td>
            <td><?=nl2br($test['data'])?></td>
            <td><?=showResult($test['results']['liquid'])?></td>
            <td><?=showResult($test['results']['liquid-node'])?></td>
            <td><?=showResult($test['results']['php-liquid'])?></td>
            <td><?=showResult($test['results']['swig'])?></td>
            <td><?=showResult($test['results']['twig'])?></td>
        </tr>

                  <?php } ?>
              <?php } ?>
    </tbody>

</table>
                 
           
        <?php } ?>
      <?php } ?>
  </div>
</div>
        </div>

      <!-- Site footer -->
      <div class="footer">
        <p>&copy; Michael Angell 2013</p>
      </div>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  </body>
</html>

<? 

file_put_contents('index.html', ob_get_contents());

ob_end_flush();

?>