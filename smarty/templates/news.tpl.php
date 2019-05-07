<!--
<div id="news">
    <table width="100%" border="0" cellpadding="2" cellspacing="1">
    <tr>
        <th class="row-title">新聞</th>
    </tr>
    <tr class="row-white">
        <td>
            {foreach from=$news key=key item=value}
                <li>
                    <span class="news-title" 
                        onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                        onmouseout="this.style.textDecoration='none';" 
                        onclick="NewsSwitch('{$key}');">
                        {$value.title}...
                    </span>
                    <br/>
                    <span class="news-time">
                        ({$value.createtime})
                    </span>
                    <br/>
                    <span id="news_content_{$key}" class="news-content" style="display:none;">
                        {$value.content}
                    </span>
                </li>
            {/foreach}
        </td>
    </tr>
    </table>
</div>
//-->
<div id="news">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="class_table">
    <tr>
        <th class="row-title">新聞發佈區</th>
    </tr>
    <tr class="row-white">
        <td>
            {foreach from=$news item=value}
                <li>
                    <a href="{$value.link}" target="_blank">{$value.subject}...</a>
                </li>
            {/foreach}
        </td>
    </tr>
    </table>
</div>