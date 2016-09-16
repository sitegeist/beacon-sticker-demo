<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//code.jquery.com" />

    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,400italic,700italic,700' rel='stylesheet' type='text/css'>
    <title>Default page</title>
    <style type="text/css">

        body{
            font: 62.5% "Trebuchet MS", sans-serif;
            margin: 0px;
            background-color: #000;
            height: 100vh;
        }

        h1 {
            font-family: Roboto, Verdana, sans-serif;
            color: #000;
            font-style: normal;
            font-variant: normal;
            letter-spacing: -.05em;
            font-weight: 100;
            font-size: 6rem;
            line-height: 1;
            text-align: center;
        }

        p {
            color: #000;
            font-family: Roboto, Verdana, sans-serif;
            font-size: 2rem;
            font-weight: 100;
            padding: 20px;
            margin: 0px;
        }

        .middle-centered {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            text-align: center;
        }

        .centered {

        }
    </style>
</head>
<body>
<h1 style="position: absolute; top:350px; left:200px; z-index:1000; color: #fff; font-weight: bold"><?php if(isset($_GET['username'])) {echo urldecode($_GET['username']).' wants to steal my notebook!';}?></h1>
    <div class="middle-centered">
        <img src="images/stolen-mac.jpg" style="width:100%"/>
    </div>
</body>
</html>