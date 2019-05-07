var Marquee = 0;
function GetMarquee()
{
    Marquee++;
    var url     = '/ajax/ajax_broadcast.php';
    var pars    = '';
    var myAjax  = new Ajax.Request(
        url,
        {
            method : 'get',
            parameters : pars,
            onComplete : ShowMarquee
        }
    );
}

function ShowMarquee(originalRequest)
{
    var resText = originalRequest.responseText;
    var marqueeElement = $('marquee');
    marqueeElement.style.color = 'yellow';
    marqueeElement.innerHTML = resText;
}

window.onload = function()
{
    GetMarquee();
    setInterval(GetMarquee,2000);
}