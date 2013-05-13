<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo G::$pageTitle ?></title>
  <meta name="description" content="D3Bit is an utility software for Diablo III. Its major use includes in-game item tooltip scanning/parsing. It uses OCR technology (Tesseract, to be specific) for parsing item affixes. It also has a handful of neat features that will help Diablo III players in their adventures.">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/css/style.<?php echo G::$version ?>.css">
  <link href='http://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
  <!--[if IE]><style></style><![endif]-->
  <script src="/js/libs/modernizr-2.5.3.min.js"></script>
  <script type="text/javascript">
    var loggedin = false;
    <?php if ($_SESSION["loggedin"] === true): ?>
    loggedin = true;
    <?php endif ?>
  </script>
</head>
<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  <header>
    <div class="inner">
      <a href="/"><img src="/img/topnav_logo.png" /></a>
      <div class="rightLinks">
        <?php if ($_SESSION["loggedin"] === true): ?>
          <a href="/user/">My Account</a> - 
          <a href="/?logout=1">Log Out</a>
        <?php else: ?>
          <a class="zoombox" href="/inc/ha_widget/?_ts=<?php echo time(); ?>&return_to=<?php echo urlencode( Auth::$CURRENT_URL ); ?>">Social Log In</a>
        <?php endif ?>
      </div>
      <div class="nav">
        <a class="navLink" href="http://d3up.com/guide/94/d3bit-user-guide">User Guide</a>
        <a class="navLink" href="/discuss/support/">Support</a>
      </div>
    </div>
  </header>
  <div id="wrapper">
    <div id="contentHolder">
       <?php echo $content ?>
    </div>
  </div>
  <footer>
    © 2012 D3Bit.com. All rights reserved.
  </footer>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="/js/plugins.js"></script>
  <script src="/js/script.<?php echo G::$version ?>.js"></script>

  <script>
  var _gaq=[['_setAccount','UA-13263235-7'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));

  var disqus_shortname = 'd3bit';
  (function () {
      var s = document.createElement('script'); s.async = true;
      s.type = 'text/javascript';
      s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
      (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
  }());

  <?php if (!$_SESSION["loggedin"]): ?>
  $("#newThreadButton a").click(function(){
    $('a.zoombox').click();
    return false;
  });
  <?php endif ?>
  </script>
        
</body>
</html>