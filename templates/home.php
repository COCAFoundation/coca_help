<DOCTYPE html>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html>
  <head>
  <meta name="google-site-verification" content="bo4VH478YFeWvahD1hAmX2m1ukQg4HkATGRY9LgvRjw" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 3 CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Bootstrap 3 Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


  <!-- Custom CSS -->
  <link href="./static/css/system.css" rel="stylesheet" type="text/css" />
  <link href="./static/css/general.css" rel="stylesheet" type="text/css" />
  <link href="./static/css/default.css" rel="stylesheet" type="text/css" />   

  <!-- Pnotify CSS -->
  <link href="./static/css/pnotify.custom.min.css" rel="stylesheet" type="text/css" /> 


  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400|Rokkitt|Josefin+Slab:300,400|Karla' rel='stylesheet' type='text/css'>

  <meta name="google-translate-customization" content="cdf027e5440b9c8f-cb40fc80eac9fe21-g025a20baa11a5cbc-19"></meta>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body ng-app="myApp">   
  <div class="container ctr" style="background:#fff;">
    <div class="cleafix" style="height:55px;">&nbsp;</div>
      <div class="row banner">           
          <div class="row banner-left hidden-sm hidden-xs"></div>           
          <div class="col-md-7 col-sm-7 col-xs-7">
            <a href="/">
              <img src="./static/images/logo_1.png" class="img-responsive" alt="Children of Central Asia Foundation"/>
            </a>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4">
             <div class="social-bar"> 
                <a href="http://www.facebook.com/COCAFoundation" target="_blank" class="">
                    <img src="./static/images/social-icons-32x32/facebook.png" alt="Children of Central Asia Foundation"/>
                </a>
                <a href="https://twitter.com/cocafoundation" target="_blank" class="">
                    <img src="./static/images/social-icons-32x32/twitter.png" alt="Children of Central Asia Foundation"/>
                </a>
                <a href="http://www.youtube.com/cocafoundation" target="_blank" class="">
                    <img src="./static/images/social-icons-32x32/youtube.png" alt="Children of Central Asia Foundation"/>
                </a>
                <a href="http://www.flickr.com/photos/cocafoundation/" target="_blank" class="">
                    <img src="./static/images/social-icons-32x32/flickr.png" alt="Children of Central Asia Foundation"/>
                </a>
            </div>
        <div class="clearfix">&nbsp;</div>
        </div>
        <div class="row banner-right hidden-sm hidden-xs"></div>   
        </div>
        <div class="row banner-bottom hidden-sm hidden-xs"></div> 
        <div class="row">
          <div class="col-md-12">                  
            <!-- ANGULAR VIEW-FRAME -->
            <div ng-view class="view-frame"></div></div>
        </div>        
    </div>               
</div>

  <div class="container ftr">
    <div class="row">
      <div class="col-md-12" style="padding-top:5px;">
        <div class="custom">
          <div class="col-md-4 col-md-offset-8"><address><strong>Children of Central Asia Foundation, Inc.</strong><br> PO Box 2611<br> Falls Church VA, 22042<br> <abbr title="Phone">Phone:</abbr> <strong>1 (888) 954-6616</strong><br> <abbr title="Email">Email:</abbr> <a style="color: #0088cc;" href="mailto:info@childrenofcentralasia.org">info@childrenofcentralasia.org</a></address></div>
        </div>
      </div>
    </div>
  </div>

    <div class="container">
      <div class="clearfix" style="height:6px;"></div>
    </div>

  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

  <!-- Latest compiled and minified JavaScript for Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <!-- Latest compiled and minified JavaScript for AngularJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.3/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.3/angular-resource.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.5/angular-route.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.5/angular-animate.min.js"></script>

  <!-- 2Weeks AngularJS Files -->
  <script src="./static/js/app.js"></script>
  <script src="./static/js/controller.js"></script>


  <!-- pNotify JS File -->
  <script src="./static/js/pnotify.custom.min.js"></script>
  <script src="./static/js/angular-pnotify.js"></script>



  <!-- Recaptcha -->
  <script src='https://www.google.com/recaptcha/api.js'></script>

  <!-- Track Google Analytics Actions -->
  <script type="text/javascript">  
    (function($){   
        $(document).ready(function($) {
          //alert('hello world');
          var filetypes = /\.(zip|exe|pdf|doc*|xls*|ppt*|mp3)$/i;
          var baseHref = '';
          if ($('base').attr('href') != undefined)
            baseHref = $('base').attr('href');
          $('a').each(function() {
            var href = $(this).attr('href');
            if (href && (href.match(/^https?\:/i)) && (!href.match(document.domain))) {
              $(this).click(function() {
                var extLink = href.replace(/^https?\:\/\//i, '');
                _gaq.push(['_trackEvent', 'External', 'Click', extLink]);
                if ($(this).attr('target') != undefined && $(this).attr('target').toLowerCase() != '_blank') {
                  setTimeout(function() { location.href = href; }, 200);
                  return false;
                }
              });
            }
            else if (href && href.match(/^mailto\:/i)) {
              $(this).click(function() {
                var mailLink = href.replace(/^mailto\:/i, '');
                _gaq.push(['_trackEvent', 'Email', 'Click', mailLink]);
              });
            }
              else if (href && href.match(filetypes)) {
                $(this).click(function() {
                  var extension = (/[.]/.exec(href)) ? /[^.]+$/.exec(href) : undefined;
                  var filePath = href;
                  _gaq.push(['_trackEvent', 'Download', 'Click-' + extension, filePath]);
                  if ($(this).attr('target') != undefined && $(this).attr('target').toLowerCase() != '_blank') {
                    setTimeout(function() { location.href = baseHref + href; }, 200);
                    return false;
                  }
                });
              }
          });
        });
      })(jQuery);
  </script>
</body>
</html>
