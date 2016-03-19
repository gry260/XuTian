<?php
date_default_timezone_set('America/Los_Angeles');
require_once('factory.php');
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
  <script>
    $(document).ready(function () {
      $('[data-toggle="popover"]').popover();
      var total_ads = $("#total_ads").val();
      setInterval(function () {
        var t = parseInt($("#remaining_time").text()) - parseInt(total_ads);
        $("#remaining_time").empty().text(t);
      }, 1000);
      $(".tracking").click(function () {
        var t = parseInt($("#remaining_time").text()) - parseInt(60);
        $("#remaining_time").empty().text(t);
      });
    });
  </script>
</head>
<body>
<div class="wrapper">
  <header class="main-header">
  </header>
  <div class="content-wrapper" style="min-height: 1178px;">
    <section class="content">
      <?php
      $s =  '<div class="col-md-4">
        <div class="col-md-6">
          <form method="POST" action="validate.php" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label">Title<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="title" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Description<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="description" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Url<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="url" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">File<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input type="file" name="image"/>
                </div>
              </div>
            </div>
            <br/>
            <div class="form-group">
              <div class="controls">
                <div>
                  <input type="submit" class="btn btn-primary btn-sm" value="Add"/>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>';
      ?>
      <div class="pull-right" style="margin-bottom:10px; margin-right: 20%;">
        <button class="btn btn-sm btn-danger" data-toggle="popover" title="Popover Header" data-html="true" data-placement="bottom" data-content='
        <div class="col-md-12">
        <div class="col-md-6">
<form method="POST" action="validate.php" enctype="multipart/form-data">
            <div class="form-group">
              <label class="control-label">Title<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="title" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Description<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="description" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">Url<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input id="relationship" name="url" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label">File<span class="text-danger bold">&nbsp;* </span></label>
              <div class="controls">
                <div>
                  <input type="file" name="image"/>
                </div>
              </div>
            </div>
            <br/>
            <div class="form-group">
              <div class="controls">
                <div>
                  <input type="submit" class="btn btn-primary btn-sm" value="Add"/>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <address>
            <strong>Contact US</strong><br>
            1355 Market Street, Suite 900<br>
            San Francisco, CA 94103<br>
            <abbr title="Phone">P:</abbr> (123) 456-7890
          </address>
        </div>
            </div>
        '>Contact US</button><br />
      </div>
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
        <div class="col-md-12" style="height:180px; border: solid 1px #E6E6E6; ">
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

    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add a Advertisement</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="validate.php" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label">Title<span class="text-danger bold">&nbsp;* </span></label>
                <div class="controls">
                  <div>
                    <input id="relationship" name="title" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Description<span class="text-danger bold">&nbsp;* </span></label>
                <div class="controls">
                  <div>
                    <input id="relationship" name="description" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">Url<span class="text-danger bold">&nbsp;* </span></label>
                <div class="controls">
                  <div>
                    <input id="relationship" name="url" date-required="true" type="text" class="form-control input-sm" placeholder="" style="background-color: rgb(255, 255, 255);">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label">File<span class="text-danger bold">&nbsp;* </span></label>
                <div class="controls">
                  <div>
                    <input type="file" name="image"/>
                  </div>
                </div>
              </div>
              <br/>
              <div class="form-group">
                <div class="controls">
                  <div>
                    <input type="submit" class="btn btn-primary btn-sm" value="Add"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>