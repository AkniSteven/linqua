
<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
    <a class="nav-tab <?php OrTextBase::adminActiveTab('general'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'general'), 'admin.php'); ?>"><span class="glyphicon glyphicon-cog"></span> Настройки</a>
    <a class="nav-tab <?php OrTextBase::adminActiveTab('progeneral'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'progeneral'), 'admin.php'); ?>"><span class="glyphicon glyphicon-asterisk"></span>PRO-Настройки</a>
    <a class="nav-tab <?php OrTextBase::adminActiveTab('project'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'project'), 'admin.php'); ?>"><span class="glyphicon glyphicon-envelope"></span> Проекты</a>
    <a class="nav-tab <?php OrTextBase::adminActiveTab('jornal'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'jornal'), 'admin.php'); ?>"><span class="glyphicon glyphicon-list"></span> Журнал</a>
    <a class="nav-tab <?php OrTextBase::adminActiveTab('help'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'help'), 'admin.php'); ?>"><span class="glyphicon glyphicon-pencil"></span> Справка</a>
    <a class="nav-tab <?php OrTextBase::adminActiveTab('about'); ?>" href="<?php echo add_query_arg(array('page' => OrTextBase::URL_ADMIN_MENU_PLUGIN, 'tab' => 'about'), 'admin.php'); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> Разработчик</a>
</h2>
<?php OrTextBase::tabViwer(); //Показать страницу в зависимости от закладки ?>

