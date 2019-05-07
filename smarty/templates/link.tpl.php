<div id="link">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="class_table">
    <tr>
        <th class="row-title">連結</th>
    </tr>
    <tr class="row-white">
        <td>
            {foreach from=$link key=key item=value}
                <li>
                    <a href="{$value}" target="_blank">{$key}</a>
                </li>
            {/foreach}
        </td>
    </tr>
    </table>
</div>