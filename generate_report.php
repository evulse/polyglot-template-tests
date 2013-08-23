<?php

$results['liquid'] = json_decode(file_get_contents('results/Liquid/current/results.json'), true);
$results['mustache'] = json_decode(file_get_contents('results/Mustache/current/results.json'), true);

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
    <title>Polyglot Template Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
        <style>
        body {
            background: #f8f8f8;
        }
        .wrapword{
            white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            white-space: pre-wrap;       /* css-3 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
            word-break: break-all;
            white-space: normal;
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
        <h2>Current Template Results</h2>
        <ul class="list-group">
<?php foreach($results as $templateLang => $json) { ?>
    <li class="list-group-item"><a href="#<?=$templateLang?>"><?=ucwords($templateLang)?></a></li>
<?}?>
            </ul>
    <?php foreach($results as $templateLang => $json) { 
    $libraries = reset(reset(reset(reset($json))))["results"];
    
    ?>
<div class="col-lg-12">
            <h2 id="<?=$templateLang?>">Results - <?=ucwords($templateLang)?></h2>
            <p>Results of each <?=ucwords($templateLang)?> library against the <?=ucwords($templateLang)?> tests.</p>
<div class="panel">
  <div class="panel-body">
      <?php foreach($json as $typeName => $type) { ?>
          <h1><?=ucwords($typeName)?></h1>
                <?php foreach($type as $tagName => $tag) { ?>
        <h2><?=ucwords($tagName)?></h2>
              
           
<table class="table table-hover">
    <thead>
        <tr>
            <th style="width:20%;" class="wrapword">Test</th>
            <th style="width:30%">Template</th>
            <th style="width:30%">Data</th>
            <th style="width:30%">Result</th>
            <?php foreach($libraries as $vendorName => $vendor) { ?>
                <th style="width:50px;"><?=$vendorName?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
              <?php foreach($tag as $testGroupName => $testGroup) { ?>
                  <?php foreach($testGroup as $test) { ?>
        <tr>
            <td  class="wrapword"><?=ucwords(nl2br($testGroupName))?></td>
            <td><pre><?=htmlentities($test['template'])?></pre></td>
            <td><pre><?=htmlentities($test['data'])?></pre></td>
            <td><pre><?=htmlentities($test['result'])?></pre></td>
           <?php foreach($test['results'] as $vendor) { ?>
            <td><?=showResult($vendor)?></td>
                        <?php } ?>

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
<? } ?>
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