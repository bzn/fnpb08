<?php /* Smarty version 2.6.16, created on 2007-03-26 22:44:42
         compiled from list.tpl.php */ ?>
<html>
<!-- Head Contents //-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'head.tpl.php', 'smarty_include_vars' => array('htmlobj' => $this->_tpl_vars['htmlobj'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<div id="container">
    <div id="inner">
        <!-- Banner Contents //-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'banner.tpl.php', 'smarty_include_vars' => array('showloginwindow' => $this->_tpl_vars['ShowLoginWindow'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <br/>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'menu.tpl.php', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <br/>
        <?php echo $this->_tpl_vars['html']; ?>

    </div>
</div>
<!-- Bottom Contents //-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'bottom.tpl.php', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Fix Contents //-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'fix.tpl.php', 'smarty_include_vars' => array('fix_content' => $this->_tpl_vars['fix_content'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>