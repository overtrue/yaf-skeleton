<!doctype html>
<html lang="<?= $lang ?? 'zh-CN'; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $name; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html,body{background-color:#fff;color:#636b6f;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-weight:100;height:100vh;margin:0}
        .full-height{height:100vh}
        .flex-center{align-items:center;display:flex;justify-content:center}
        .position-ref{position:relative}
        .top-right{position:absolute;right:10px;top:18px}
        .content{text-align:center}
        .title{font-size:84px}
        .links>a{color:#636b6f;padding:0 25px;font-size:12px;font-weight:600;letter-spacing:.1rem;text-decoration:none;text-transform:uppercase}
        .m-b-md{margin-bottom:30px}
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="top-right links">
        <a href="/">Home</a>
        <a href="https://github.com/overtrue/yaf-skeleton">GitHub</a>
    </div>

    <div class="content">
        <div class="title m-b-md"><?= $name; ?></div>

        <div class="links">
            <a href="https://github.com/overtrue/yaf-skeleton">Documentation</a>
            <a href="https://easywechat.com">EasyWeChat</a>
            <a href="https://github.com/laruence/yaf">Yaf</a>
            <a href="https://github.com/overtrue/yaf-skeleton">GitHub</a>
        </div>
    </div>
</div>
</body>
</html>