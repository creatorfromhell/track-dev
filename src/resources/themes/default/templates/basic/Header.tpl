<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title>{ language->site->title }</title>
    <!--[if le IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <![endif]-->
    { theme->includes }
</head>
<body>
<header>
    <div class="login">
        <p>{ site->user_bar }</p>
    </div>
    { navigation->main->template }
    <div class="h1-holder">
        <h1>{ site->header->h1 }</h1>
        { pages->switch }
    </div>
</header>
<div id="msg" onclick="closeMessage(); return false;" class="{ message->type }" style="{ message->style }">{ message->text }</div>