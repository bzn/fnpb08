<?php /* Smarty version 2.6.16, created on 2007-04-24 05:02:24
         compiled from index.tpl.php */ ?>
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
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'menu.tpl.php', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <br/>
        <div id="center">
        <?php echo $this->_tpl_vars['center']; ?>

        </div>
        <div id="left">
        <!-- News Contents //-->
        <?php echo $this->_tpl_vars['html']; ?>

        </div>
        <div id="right">
        <!-- Login Contents //-->
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'news.tpl.php', 'smarty_include_vars' => array('news' => $this->_tpl_vars['news'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'discuz.tpl.php', 'smarty_include_vars' => array('threads' => $this->_tpl_vars['threads'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'link.tpl.php', 'smarty_include_vars' => array('link' => $this->_tpl_vars['link'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
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