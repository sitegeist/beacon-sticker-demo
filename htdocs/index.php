<?php
    function generateRandomString($length = 10) {
        return substr(str_shuffle("123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ"), 0, $length);
    }
    if(isset($_COOKIE['token']) && !isset($_GET['newtoken'])) {
        $token = $_COOKIE['token'];
    }
    else {
        $token = generateRandomString(4);
        setcookie('token', $token, time()+3600 * 24 * 365); // 1 year
        if(isset($_GET['newtoken'])){
            header('Location: /');
        }
    }
?>
<!doctype html>
<html lang="us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="expires" content="-1" />
    <meta name="viewport" content="initial-scale=1, minimal-ui" />

    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//code.jquery.com" />

    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700' rel='stylesheet' type='text/css'>
    <title>estimote stickers demo</title>
    <link href="css/animate.css" rel="stylesheet">
    <style>
        body{
            font: 62.5% "Trebuchet MS", sans-serif;
            margin: 0px;
            background-color: #000;
            overflow: hidden;
        }

        h1 {
            font-family: Roboto, Verdana, sans-serif;
            color: #fff;
            font-style: normal;
            font-variant: normal;
            letter-spacing: -.05em;
            font-weight: 100;
            font-size: 4rem;
            line-height: 1;
            text-align: center;
        }

        p {
            color: #fff;
            font-family: Roboto, Verdana, sans-serif;
            font-size: 2rem;
            font-weight: 100;
            padding: 20px;
            margin: 0px;
        }
        .demoHeaders {
            margin-top: 2em;
        }
        #dialog-link {
            padding: .4em 1em .4em 20px;
            text-decoration: none;
            position: relative;
        }
        #dialog-link span.ui-icon {
            margin: 0 5px 0 0;
            position: absolute;
            left: .2em;
            top: 50%;
            margin-top: -8px;
        }
        #icons {
            margin: 0;
            padding: 0;
        }
        #icons li {
            margin: 2px;
            position: relative;
            padding: 4px 0;
            cursor: pointer;
            float: left;
            list-style: none;
        }
        #icons span.ui-icon {
            float: left;
            margin: 0 4px;
        }
        .fakewindowcontain .ui-widget-overlay {
            position: absolute;
        }
        select {
            width: 200px;
        }

        #dog {
            bottom: 50%;
            left: 20px;
            position: absolute;
            display: none;
        }

        #bike {
            bottom: 50%;
            right: 20px;
            position: absolute;
            display: none;
        }

        #contentFrame {
            display: none;       /* iframes are inline by default */
            border: none;         /* Reset default border */
            height: 100vh;        /* Viewport-relative units */
            width: 100vw;
            overflow: hidden;
        }
        .logo-header {
            padding-top: 50px;
            text-align: center;
            vertical-align: middle;
        }

        .button {
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            border:2px solid #fff;
            padding: 20px;
            display: inline-block;
            color: #fff;
            font-family: Roboto, Verdana, sans-serif;
            font-size: 2rem;
            font-weight: 100;
        }
        span.button:hover {
            cursor: pointer;
        }

        a.button  {
            color: #fff;
            text-decoration: none;
        }

        .slide {
            height: 100vh;
        }

        #header {
            float: left;
            width: 100%;
            background: #EBA100;
            min-height: 100vh;
        }

        .visible {
            visibility: visible;
            opacity: 1;
            transition: opacity 1s linear;
        }

        .hidden {
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s 1s, opacity 1s linear;
        }

        .col-50 {
            float: left;
            width: 50%;
            margin: 0px;
            padding: 0px;
        }
        @media screen and (max-width: 480px) {
            h1 {
                font-size: 3rem;
            }
            .col-50 {
                width: 100%;
                padding-bottom: 10px;
                padding-top: 10px;
                border-bottom: solid 1px white;
            }
            .only-desktop {
                display: none;
            }

            p {
                padding: 5px;
            }
        }
        @media screen and (min-width: 480px) {
            .only-mobile {
                display: none;
            }
        }

        .innerContainer {
            margin: 10px;
        }
        .centered {
            text-align: center;
        }
        .licence {
            color: #fff;
            font-family: Roboto, Verdana, sans-serif;
            font-size: 0.7rem;
            font-weight: 100;
        }
        .licence a {
            color: #fff;
            text-decoration: none;
        }
    </style>

</head>
<body>
<div id="header">
    <div class="logo-header">
        <img src="images/logo_sitegeist.svg" width="232" height="57" alt="sitegeist | Online. Marketing. Performance.">
        <h1>sitegeist estimote stickers Demo</h1>
    </div>
    <div class="col-100 centered only-mobile">
        <p class="centered"><img src="images/smartphone-white.svg" height="150" /></p>
        <p><a class="button" href="evo://<?php echo $_SERVER['HTTP_HOST'];?>/app/index.html">Open the App</a></p>
        <p>Click this button on your Smartphone (iOS only for now) to start the app.</p>
        <p>Please activate bluetooth on your smartphone before starting the app.</p>
        <p>You need EvoViewer App installed for that.<br />
            <a href="https://itunes.apple.com/se/app/evothings-viewer/id1029452707?mt=8" target="_new"><img style="height: 40px;" src="images/Download_on_the_App_Store_Badge_US-UK_135x40.png" alt="Download_on_the_App_Store_Badge_US-UK_135x40"></a>
        </p>
        <div class="licence">Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </div>
    <div class="col-100 centered only-desktop">
        <p><img src="images/screen-white.svg" height="150" /></p>
        <p>This page demonstrates the Usage of estimote stickers.</p>
        <p>On your iPhone open your favorite browser with the URL <strong>https://<?php echo $_SERVER['HTTP_HOST'];?>.</strong></p>
        <p class="only-desktop">Enter Token <strong><?php echo $token;?></strong> in the app to connect to this screen.</p>
        <p><span id="btnNewToken" class="button">&raquo; Get a new token</span></p>
        <p>Press "Run" to start after you started the app on your iPhone.</p>
        <p>Click reload to come back to this screen if you want to exit the kiosk mode.</p>
        <p><span id="btnRun" class="button">&raquo; Run</span></p>
        <p class="result"></p>
        <div class="licence">Icons made by <a href="http://www.flaticon.com/authors/anhgreen" title="AnhGreen">AnhGreen</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </div>
</div>
<script src="js/external/jquery/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
    $.fn.extend({
        animateCss: function (animationName, hideAfterAnimation) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            $(this).show();
            $(this).addClass('animated ' + animationName).one(animationEnd, function() {
                $(this).removeClass('animated ' + animationName);
                if(hideAfterAnimation) {
                    $(this).hide();
                }
            });
        }
    });
    $.fn.extend({
        /* fade out, load new url and fade in */
        changeSlide: function (url){
            /*
            $(this).fadeOut(1000,function(){
                $(this).attr('src',url).load(function(){
                    $(this).fadeIn(1000);
                });
            });
            */
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend oTransitionEnd otransitionend';
            $(this).addClass('hidden').one(animationEnd, function() {
                $(this).attr('src', url).load(function(){
                    $(this).removeClass('hidden');
                    $(this).addClass('visible').one(animationEnd, function(){
                        $(this).removeClass('visible');
                    })
                })
            });
        }
    });

    $('#btnNewToken').click(function(){
        window.location.href = '?newtoken=1';
    });
    $('#btnRun').click(function() {

        var ttl = 10000;
        var timeOutUntilShowDefault = ttl;

        $('#header').animateCss('fadeOut',true);
        $('#contentFrame').animateCss('fadeIn',false);

        setInterval(function(){
            var interval = 1000;
            if(timeOutUntilShowDefault >= interval) {
                timeOutUntilShowDefault = timeOutUntilShowDefault - interval;
                if(timeOutUntilShowDefault < 0 ) {
                    timeOutUntilShowDefault = 0;
                }
            }
        },1000);

        setInterval(function(){
            $.get( "ajax.php?token=<?php echo urlencode($token);?>", function(data) {
                // $( ".result" ).html(JSON.stringify(data));
                if(data.length==0 && $('#contentFrame').attr('src') != 'welcome.php' && timeOutUntilShowDefault <= 0){
                    $('#contentFrame').changeSlide('welcome.php');
                }
                else {
                    if(data.length>0) {
                        console.log('Expected token: ' + '<?php echo $token;?>');
                        console.log(JSON.stringify(data));
                        for (var i = 0; i < data.length; i++) {
                            if(data[i].token == '<?php echo $token;?>') {
                                var url = data[i].url;
                                if(url.indexOf('?')==-1) {
                                    url = url + '?'
                                }
                                else {
                                    url = url + '&';
                                }
                                url = url + 'username=' + encodeURIComponent(data[i].username);
                                if ($('#contentFrame').attr('src') != url) {
                                    $('#contentFrame').changeSlide(url);
                                    timeOutUntilShowDefault = ttl;
                                }
                            }
                        }
                    }
                }
            });
        },300);
    });
</script>
<iframe scrolling="no" id="contentFrame" src="welcome.php"></iframe>
</body>
</html>
