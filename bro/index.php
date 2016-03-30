<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require_once('factory.php');
$allow_chars = array(",");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MySummer Home</title>
<head>
  <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
        type="text/css"/>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
  <link href="css/style.css" rel="stylesheet" type="text/css"/>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
          integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
          crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script>
    $(document).ready(function () {
      $('form').formValidate();
      $('[data-toggle="popover"]').popover({
        content: function() {
          return $("#popcontact").html();
        }
      });
      var total_ads = $("#total_ads").val();
      setInterval(function () {
        var t = parseInt($("#remaining_time").text()) - parseInt(total_ads);
        $("#remaining_time").empty().text(t);
      }, 1000);
      $(".tracking").click(function () {
        var t = parseInt($("#remaining_time").text()) - parseInt(60);
        $("#remaining_time").empty().text(t);
      });
      setInterval(function () {
        $(".time_management").each(function(){
          var seconds;
          var minutes;
          var hours;
          var res = $(this).text().split(":");
          if(res[2] >= 59){
            seconds = pad(0, 2);
            minutes = pad(parseInt(res[1])+1, 2);
            hours = pad(res[0], 4);
            if(minutes == 60){
              minutes = pad(0, 2);
              hours = pad(parseInt(res[0])+1, 4);
            }
          }
          else{
            seconds = pad(parseInt(res[2]) + 1, 2);
            minutes = pad(res[1], 2);
            hours = pad(res[0], 4);
          }
          $(this).empty().append(hours+":"+minutes+":"+seconds);
        });
      }, 1000);

      if($("#error_log").length == 1){
        $("#open_button").popover("show");
      }
    });

    function pad(number, length) {
      var str = '' + number;
      while (str.length < length) {
        str = '0' + str;
      }
      return str;
    }
  </script>
</head>
<body>
<div class="wrapper">
  <header class="main-header">
  </header>
  <div class="col-md-12" style="display: none;" id="popcontact">
    <div class="col-md-6">
      <form method="POST" action="validate.php" enctype="multipart/form-data">
        <div class="form-group">
          <div class="controls">
            <div>
              <input name="title" data-chars='<?php echo json_encode($allow_chars);?>' type="text" class="form-control input-sm" placeholder="<?php echo (!empty($_SESSION['userinput']['title']) ? urldecode($_SESSION['userinput']['title']) : "Title");
              ?>"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <div>
              <input  name="description" date-required="true" type="text" class="form-control input-sm" placeholder="<?php echo (!empty($_SESSION['userinput']['description']) ? urldecode($_SESSION['userinput']['description']) : "Description");
              ?>" style="background-color: rgb(255, 255, 255);">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <div>
              <input name="url"  type="text" class="form-control input-sm" placeholder="<?php echo (!empty($_SESSION['userinput']['url']) ? urldecode($_SESSION['userinput']['url']) : "Url");
              ?>" style="background-color: rgb(255, 255, 255);">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <div>
              <input type="file" name="image"/>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <input type="submit" class="btn btn-success btn-sm" value="Add"/>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <address>
        <strong>How to Contact US</strong><br>
        1355 Market Street, Suite 900<br>
        San Francisco, CA 94103<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
      </address>
    </div>
  </div>

  <div class="content-wrapper" style="min-height: 1178px;">
    <section class="content">
      <div class="pull-right" style="margin-bottom:10px; margin-right: 12%;">
        <button class="btn btn-xs btn-danger" id="open_button" data-toggle="popover" title="" data-html="true" data-placement="bottom">Contact US</button><br />
      </div>
      <?php
      if(!empty($_SESSION['msgs'])){
        ?>
      <input type="hidden" value="1" id="error_log" />
      <?php
        echo '
<div class="alert alert-warning" style="margin-top:25px;">
    <h4 class="text-center"><i class="fa fa-warning"> Warning! </i></h4>';
        foreach($_SESSION['msgs'] as $msg){
          echo '<li style="list-style: none;">'.$msg.'</li>';
        }
        echo '</div>';
        unset($_SESSION['msgs']);
      }
      ?>
      <div class="col-md-12" style="height:60px; border: solid 1px #E6E6E6;">
        <div class="pull-right">
        </div>
        <div class="pull-right" style="margin-right: 35px;">
          <h4>
            Time Remaining
          </h4>
          <h5>
            <span id="remaining_time">
            <?php
            echo ads::getRemainingTime();
            ?>
            </span>
            <input type="hidden" id="total_ads" value="<?php echo ads::getTotalAds(); ?>"/>
          </h5>
        </div>
        <div class="pull-right" style="margin-right: 35px;">
          <h3>
          </h3>
        </div>
        <div class="pull-left" style="margin-right: 35px;">
          <h5>
            Total Clicks: <?php echo $totalclicks; ?>
          </h5>
        </div>
      </div>
      <div class="col-md-12" style="height:60px; border: solid 1px #E6E6E6; margin-top:5px;">

      </div>
      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 65%;
    position: relative;"  src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/>
              </a>
              <p class="bg-danger time_management"><?php echo $mode->getDifferenceTime(); ?></p>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <div class="col-md-12" style="height:180px; border: solid 1px #E6E6E6; ">
          <?php
          if (current($objs) !== false) {
            $mode = current($objs);
            ?>
            <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
               class="tracking" target="_blank">
              <img style=" width: 100%;
    height: 88%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
            <p class="bg-danger time_management"><?php echo $mode->getDifferenceTime(); ?></p>
            <?php
            next($objs);
          }
          ?>
        </div>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 65%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <p class="bg-danger time_management"><?php echo $mode->getDifferenceTime(); ?></p>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>


      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 100%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <p class="bg-danger time_management"><?php echo $mode->getDifferenceTime(); ?></p>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 2; $i++) {
          ?>
          <div class="col-md-6" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 100%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <p class="bg-danger time_management"><?php echo $mode->getDifferenceTime(); ?>asdf</p>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 100%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <?php
      for ($i = 0; $i < 12; $i++) {
        ?>
        <div class="col-md-2" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
          <?php
          if (current($objs) !== false) {
            $mode = current($objs);
            ?>
            <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
               class="tracking" target="_blank">
              <img style=" width: 100%;
    height: 100%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
            <?php
            next($objs);
          }
          ?>
        </div>
        <?php
      }
      ?>


      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 12; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%;
    height: 100%;
    position: relative;" src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 1; $i++) {
          ?>
          <div class="col-md-12" style="height:240px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%; height: 100%; position: relative;"
                     src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 12; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%; height: 100%; position: relative;"
                     src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>


      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%; height: 100%; position: relative;"
                     src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 2; $i++) {
          ?>
          <div class="col-md-6" style="height:180px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%; height: 100%; position: relative;"
                     src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="col-md-4" style="margin-top:5px; padding: 0">
        <?php
        for ($i = 0; $i < 9; $i++) {
          ?>
          <div class="col-md-4" style="height:60px; padding-right: 0px; padding-left:0px; border: solid 1px #E6E6E6;">
            <?php
            if (current($objs) !== false) {
              $mode = current($objs);
              ?>
              <a href="tracking.php?id=<?php echo $mode->getId(); ?>&url=<?php echo urlencode($mode->getURL()); ?>"
                 class="tracking" target="_blank">
                <img style=" width: 100%; height: 100%; position: relative;"
                     src="vfs/<?php echo $mode->getUserId() . '/' . $mode->getFileName() ?>"/> </a>
              <?php
              next($objs);
            }
            ?>
          </div>
          <?php
        }
        ?>
      </div>

    </section>
  </div>
</div>
</div>
</body>
</html>