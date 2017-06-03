{__NOLAYOUT__}
<!DOCTYPE html>
<html>
<head>
  <title>趣果商城管理后台</title>
  {include file="public/head_import" /}
  <style>
    html,body,.my-flex-container{width:100%;height:100%;}
    .my-flex-container{display:flex;align-items:center;}
  </style>
</head>
<body class="hold-transition lockscreen">
  <div class="my-flex-container">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper" style="margin-top:0%;">
      <div class="lockscreen-logo" style="margin-bottom:10px;">
          <b><?php echo(strip_tags($msg));?></b>
      </div>
      <div class="lockscreen-name" style="font-size:32px;margin-bottom:30px;">
        <?php switch ($code) {?>
            <?php case 1:?>
            ~^o^~
            <?php break;?>
            <?php case 0:?>
            \(╯-╰)/
            <?php break;?>
        <?php } ?>
      </div>
      <div class="help-block text-center"></div>
      <div class="text-center" style="letter-spacing:1px;">
        页面自动<a id="href" href="<?php echo($url);?>">跳转</a>,等待时间：<b id="wait"><?php echo($wait);?></b>s
      </div>
      <div class="lockscreen-footer text-center">
        Copyright &copy; 2016-2017 <b><a href="http://www.quguonet.com" class="text-black">Quguo Co.Ltd</a></b><br>
        All rights reserved
      </div>
    </div>
    <!-- /.center -->
  </div>
  <script type="text/javascript">
      (function(){
          var wait = document.getElementById('wait'),
              href = document.getElementById('href').href;
          var interval = setInterval(function(){
              var time = --wait.innerHTML;
              if(time <= 0) {
                  location.href = href;
                  clearInterval(interval);
              };
          }, 1000);
      })();
  </script>
</body>
</html>
