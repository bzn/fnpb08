<?php /* Smarty version 2.6.16, created on 2008-04-16 15:42:50
         compiled from menu.tpl.php */ ?>
<div id="menu">
    <table width="100%" cellpadding="4" cellspacing="2" border="0">
    <tr class="menu-main">
        <td>
        <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';MenuSwitch(1);" 
            onmouseout="this.style.textDecoration='none';">我的隊伍</span> | 
        
        <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';MenuSwitch(2);" 
            onmouseout="this.style.textDecoration='none';">我的聯盟</span> | 
        
        <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';MenuSwitch(3);" 
            onmouseout="this.style.textDecoration='none';">研究資料</span> | 
        
        <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';MenuSwitch(4);" 
            onmouseout="this.style.textDecoration='none';">排行榜</span> | 
        
        <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';MenuSwitch(5);" 
            onmouseout="this.style.textDecoration='none';">幫助</span>
                
        <?php if ($_SESSION['loginid']): ?>
            | <span onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" onclick="javascript:top.location.href = '/logout.php';" 
                >登出</span>
        <?php endif; ?>
        </td>
    </tr>
    <tr class="menu-sub">
        <td>
        <div id="menu-sub-1">
            <a href="myteam_lineup.php?view=2" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">我的球員名單</a> | 
        
            <a href="myteam_history.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">我的交易紀錄</a> | 

            <a href="myteam_scorelog.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">我的積分紀錄</a> | 
            
            <a href="myteam_changename.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">更換隊伍名稱</a> | 
            
            <a href="myteam_makepic.php" target="_TOP" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">隊徽工具</a>
        </div>
        <div id="menu-sub-2" style="display:none;">
            <a href="lea_index.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">聯盟首頁</a> | 
        
            <a href="lea_msg.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">聯盟留言板</a> | 
            
            <a href="lea_alllea.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">查看所有聯盟</a> | 
            
            <a href="lea_nolea.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">加入別的聯盟</a>
        </div>
        <div id="menu-sub-3" style="display:none;">
            <a href="res_pricemover.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">薪資變動</a> | 
        
            <a href="res_searchplayer.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">搜尋球員</a> | 
        
            <a href="res_scheduleanalyzer.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">對戰賽程分析</a> | 
        
            <a href="res_yesterdaybest.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">昨日最佳表現</a> | 
            
            <a href="res_bargain.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">物超所值</a><span style="font:10px;color:red;"></span> | 

            <a href="res_performers.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">績優球員</a><span style="font:10px;color:red;"></span>
        </div>
        <div id="menu-sub-4" style="display:none;">
                
            <a href="lea_point.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">聯盟積分排行</a> | 
            
            <a href="lea_money.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">聯盟資產排行</a> | 
            
            <a href="board_point.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">積分Top20</a> | 

            <a href="board_money.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">資產Top20</a> | 
            
            <a href="board_allteam.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">所有玩家隊伍</a>
        </div>
        <div id="menu-sub-5" style="display:none;">
            <a href="http://npb.club.tw/viewforum.php?f=93" target="_blank" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">討論區</a> | 

            <a href="http://npb.ohdada.com/index.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">修改個人資料</a> | 
            
            <a href="mailto:npb@ohdada.com" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">聯絡我們</a> | 
            
            <a href="about_faq.php" style="color:#000;text-decoration:none;" 
            onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
            onmouseout="this.style.textDecoration='none';">什麼是Fantasy NPB</a>
        </div>
        </td>
    </tr>
    </table>
</div>