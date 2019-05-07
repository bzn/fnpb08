<html>
<!-- Head Contents //-->
{include file='head.tpl.php' htmlobj=$htmlobj}
<body>
<div id="container">
    <div id="inner">
        <!-- Banner Contents //-->
        {include file='banner.tpl.php' showloginwindow=$ShowLoginWindow}
        {include file='menu.tpl.php'}
        <br/>
        <div id="center">
        {$center}
        </div>
        <div id="left">
        <!-- News Contents //-->
        {$html}
        </div>
        <div id="right">
        <!-- Login Contents //-->
        {include file='news.tpl.php' news=$news}
        {include file='discuz.tpl.php' threads=$threads}
        {include file='link.tpl.php' link=$link}
        </div>
    </div>
</div>
<!-- Bottom Contents //-->
{include file='bottom.tpl.php'}
<!-- Fix Contents //-->
{include file='fix.tpl.php' fix_content=$fix_content}
</body>
</html>