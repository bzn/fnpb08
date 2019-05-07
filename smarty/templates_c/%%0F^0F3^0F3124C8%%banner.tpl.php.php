<?php /* Smarty version 2.6.16, created on 2008-03-27 14:59:44
         compiled from banner.tpl.php */ ?>
<div id="banner">

<BR><BR>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="40%"><a href="/" target="_top"><img src="/images/logo.gif" style="border:0;"></a></td>
        <td width="60%" align="right" valign="bottom">
        <?php if (! $this->_tpl_vars['HideLoginWindow']): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'login.tpl.php', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
        </td>
    </tr>
    </table>        
</div>

<?php echo '<?php'; ?>
 
//GOOGLE 分析
<?php echo '?>'; ?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-252630-3";
urchinTracker();
</script>