<script type="text/javascript">

    jQuery("document").ready(function () {


        jQuery("#toltipstatus").tooltip({placement: 'bottom'});


    });


</script>	


<h2>Журнал работы плагина</h2>
<?php
$plugins_url = admin_url() . 'options-general.php?page=' . OrTextBase::URL_ADMIN_MENU_PLUGIN . '&tab=jornal'; //URL страницы плагина
$ortextfun = new OrTextFunc();
$jornalarray = get_option('ortext_jornal');
$includ_jornal = get_option('ortext_jornal_inc'); //Включалка журнала
$ortext_error_inc=  get_option('ortext_error_inc');//Включатель сообщений об ошибках в редакторе




if (isset($_GET['clearjornal'])) {
    update_option('ortext_jornal', array());
    ?>
    <script type = "text/javascript">
        document.location.href = "<?php echo $plugins_url; ?>";
    </script>
    <?php
}
?>

<table class="form-table formclientsent">
    <tr valign="top">
        <th scope="row">Вести журнал?</th>
        <td>
            <input type="checkbox" name="ortext_jornal_inc" <?php checked($includ_jornal, '1', 1); ?>/>
            <span class="description">Если галочки нет, записи в журнал не будут идти</span>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Показывать сообщения об ошибках в редакторе</th>
        <td>
            <input type="checkbox" name="ortext_error_inc" <?php checked($ortext_error_inc, '1', 1); ?>/>
            <span class="description">Если галочки нет, дополнительных сообщений в редакторе показанно не будет</span>
        </td>
    </tr>
</table>

<a class="btn btn-primary" href="<?php echo $plugins_url . '&clearjornal'; ?>">Очистить журнал</a>
<p>Информация по ошибкам</p>
<table class="table table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th>Код ошибки</th> 
            <th>Расшифровка</th>

        </tr>
    </thead>
    <tbody>

        <tr class="success">
            <th>201</th>
            <th>Текст добавлен</th>
        </tr>
        <tr class="warning">
            <th>400</th>
            <th>Bad request (Не верный запрос)</th>
        </tr>
        <tr class="warning">
            <th>401</th>
            <th>Срок действия токена истёк</th>
        </tr>
        <tr class="danger">
            <th>403</th>
            <th>-Оригинальный текст слишком короткий или длинный.<br> -Превышен суточный лимит на добавление оригинальных текстов.<br>
                -Неверное значение токена.<br>-Права пользователя на сайт не подтверждены.
            </th>
        </tr>
        <tr class="info">
            <th>409</th>
            <th>Оригинальный текст уже добавлен</th>
        </tr>
        <tr class="warning">
            <th>500</th>
            <th>Внутренняя ошибка сервера</th>
        </tr>
        <tr class="danger">
            <th>777</th>
            <th>Не определённая ошибка, сообщите разработчику плагина - он подумает над этим :)</th>
        </tr>
        <tr>
            <th>error</th>
            <th>Ошибка может быть вызвана конфликтом функций или хука при сохранение/публикации текста. Текст в этом случае не отправляется в Яндекс. </th>
        </tr>

    </tbody>
</table>

<table class="table table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th>Дата и время добавления</th> 
            <th>Номер записи (id поста по Wordpress)</th>
            <th>Заголовок записи</th>
            <th>Тип записи</th>
            <th>Статус добавления</th>
            <th>ID текста в Яндекс</th>
            <th>Квота текстов на сутки</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($jornalarray as $jornalprint) { ?>
            <tr class="<?php
            switch (trim($jornalprint['status'])) {
                case 201: echo 'success';
                    break;
                case 400: echo 'warning';
                    break;
                case 401: echo 'warning';
                    break;
                case 409: echo 'info';
                    break;
                case 500: echo 'warning';
                    break;
                case 777: echo 'danger';
                    break;
                case 403: echo 'danger';
                    break;
            }
            ?>">
                <th><?php echo $jornalprint['time']; ?></th>
                <th><?php echo $jornalprint['idpost']; ?></th>
                <th><?php echo $jornalprint['title']; ?></th>
                <th><?php echo $jornalprint['post_type']; ?></th>
                <th><?php echo $jornalprint['status']; ?></th>
                <th><?php echo $jornalprint['idyandex']; ?></th>
                <th><?php echo $jornalprint['quota']; ?></th>
            </tr>
        <?php } ?>
    </tbody>



</table>