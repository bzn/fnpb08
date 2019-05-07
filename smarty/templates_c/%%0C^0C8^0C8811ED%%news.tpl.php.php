<?php /* Smarty version 2.6.16, created on 2007-04-24 02:32:32
         compiled from news.tpl.php */ ?>
<!--
<div id="news">
    <table width="100%" border="0" cellpadding="2" cellspacing="1">
    <tr>
        <th class="row-title">新聞</th>
    </tr>
    <tr class="row-white">
        <td>
            <?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
                <li>
                    <span class="news-title" 
                        onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                        onmouseout="this.style.textDecoration='none';" 
                        onclick="NewsSwitch('<?php echo $this->_tpl_vars['key']; ?>
');">
                        <?php echo $this->_tpl_vars['value']['title']; ?>
...
                    </span>
                    <br/>
                    <span class="news-time">
                        (<?php echo $this->_tpl_vars['value']['createtime']; ?>
)
                    </span>
                    <br/>
                    <span id="news_content_<?php echo $this->_tpl_vars['key']; ?>
" class="news-content" style="display:none;">
                        <?php echo $this->_tpl_vars['value']['content']; ?>

                    </span>
                </li>
            <?php endforeach; endif; unset($_from); ?>
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
            <?php $_from = $this->_tpl_vars['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
                <li>
                    <a href="<?php echo $this->_tpl_vars['value']['link']; ?>
" target="_blank"><?php echo $this->_tpl_vars['value']['subject']; ?>
...</a>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </td>
    </tr>
    </table>
</div>