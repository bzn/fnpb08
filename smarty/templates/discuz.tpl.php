<div id="discuz">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="class_table">
    <tr>
        <th class="row-title">玩家討論區</th>
    </tr>
    <tr class="row-white">
        <td>
            {foreach from=$threads item=value}
                <li>
                    <a href="{$value.link}" target="_blank">{$value.subject}...</a><br/>
                    　　發表人：{$value.author}<br/>
                    　　最後回應日期：{$value.lastpost}
                </li>
            {/foreach}
        </td>
    </tr>
    </table>
</div>