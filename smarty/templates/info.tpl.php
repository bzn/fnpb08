<div id="info">
    <table width="100%" border="0" align="center">
    <tr>
        <td colspan="6"><span class="style3">{$info.team_name}</span></td>
    </tr>
    <tr>
        <td colspan="6"><span class="style2">隊伍資訊</span></td>
    </tr>
    <tr>
        <td width="60">玩家名稱</td>
        <td width="190">{$info.user_name}</td>
        <td width="62">球隊資金</td>
        <td width="199">{$info.value_total}</td>
        <td width="82">世界積分排名</td>
        <td width="149">{$info.world_tsnd_rank}(共計{$info.total_member}人)</td>
    </tr>
    <tr>
        <td>投手次數</td>
        <td>{$info.trade_p}</td>
        <td>剩下資金</td>
        <td>{$info.value_left}</td>
        <td>聯盟積分排名</td>
        <td>{$info.division_rank}</td>
    </tr>
    <tr>
        <td>打者次數</td>
        <td>{$info.trade_h}</td>
        <td>昨日積分</td>
        <td>{$info.tsnd_yesterday}</td>
        <td>世界金錢排名</td>
        <td>{$info.world_value_rank}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>總積分</td>
        <td>{$info.tsnd_total}</td>
        <td>聯盟金錢排名</td>
        <td>{$info.division_value_rank}</td>
    </tr>
    </table>
</div>