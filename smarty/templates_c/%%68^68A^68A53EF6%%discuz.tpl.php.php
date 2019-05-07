<?php /* Smarty version 2.6.16, created on 2007-04-03 22:45:51
         compiled from discuz.tpl.php */ ?>
<div id="discuz">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="class_table">
    <tr>
        <th class="row-title">玩家討論區</th>
    </tr>
    <tr class="row-white">
        <td>
            <?php $_from = $this->_tpl_vars['threads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
                <li>
                    <a href="<?php echo $this->_tpl_vars['value']['link']; ?>
" target="_blank"><?php echo $this->_tpl_vars['value']['subject']; ?>
...</a><br/>
                    　　發表人：<?php echo $this->_tpl_vars['value']['author']; ?>
<br/>
                    　　最後回應日期：<?php echo $this->_tpl_vars['value']['lastpost']; ?>

                </li>
            <?php endforeach; endif; unset($_from); ?>
        </td>
    </tr>
    </table>
</div>