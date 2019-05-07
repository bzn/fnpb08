<html>
<!-- Head Contents //-->
{include file='head.tpl.php' htmlobj=$htmlobj}
<body>
<div id="container">
    <div id="inner">
        <!-- Banner Contents //-->
        {include file='banner.tpl.php' showloginwindow=$ShowLoginWindow}
        <br/>
        {$html}
    </div>
</div>
<!-- Bottom Contents //-->
{include file='bottom.tpl.php'}
<!-- Fix Contents //-->
{include file='fix.tpl.php' fix_content=$fix_content}
</body>
</html>