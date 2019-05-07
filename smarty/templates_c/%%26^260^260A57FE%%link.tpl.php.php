<?php /* Smarty version 2.6.16, created on 2007-03-26 22:44:41
         compiled from link.tpl.php */ ?>
<div id="link">
    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="class_table">
    <tr>
        <th class="row-title">連結</th>
    </tr>
    <tr class="row-white">
        <td>
            <?php $_from = $this->_tpl_vars['link']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
?>
                <li>
                    <a href="<?php echo $this->_tpl_vars['value']; ?>
" target="_blank"><?php echo $this->_tpl_vars['key']; ?>
</a>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </td>
    </tr>
    </table>
</div>