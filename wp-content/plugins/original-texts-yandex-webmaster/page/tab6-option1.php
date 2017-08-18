
<script type="text/javascript">
    jQuery("document").ready(function () {

        jQuery("#toltipemail1").tooltip({placement: 'bottom'});



    });





</script>	

<?php
$ortextfun = new OrTextFunc;
$ortextfun->IfElseUpdate(); //опции
?>



<?php
$ortextprol = get_option('ortextprol'); //
$plugins_url = admin_url() . 'options-general.php?page=' . OrTextBase::URL_ADMIN_MENU_PLUGIN; //URL страницы плагина
$dir_plugin_abdolut = plugin_dir_path(__FILE__);
?>


<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <table class="form-table">


        <tr valign="top">
            <th scope="row">Email</th>
            <td>
                <input type="checkbox" name="ortextprol[ck_email]" <?php
                if (isset($ortextprol['ck_email'])) {
                    checked($ortextprol['ck_email'], 'on', 1);
                }
                ?>/>
                <span class="description">Включить уведомления на Email</span>
            </td>
            <td>
                <input id="toltipemail1" data-toggle="tooltip" title="Введите email для уведомлений" placeholder="Например: djo@mail.ru" type="email" name="ortextprol[email]" value="<?php
                if (!empty($ortextprol['email'])) {
                    echo $ortextprol['email'];
                }
                ?>" />
                <span class="description">На этот Email будет приходить уведомление о завершение срока работы токена, вы можете не указывать email. Можно указать несколько email через ", "</span>
            </td>
        </tr>
    </table>
    <fieldset>
        <legend>Правила обработки текста при помощи preg_replace</legend>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Правила очистки текста №1</th>
                <td>
                    <input type="checkbox" name="ortextprol[ck_reg1]" <?php
                    if (isset($ortextprol['ck_reg1'])) {
                        checked($ortextprol['ck_reg1'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Включить ваше правило №1 очистки текста?</span>
                </td>
                <td>
                    <input placeholder="Например: Рубить шорткоды" type="text" name="ortextprol[namereg1]" value="<?php
                    if (!empty($ortextprol['namereg1'])) {
                        echo $ortextprol['namereg1'];
                    }
                    ?>" />
                    <span class="description">Имя вашего правила, для удобства испоьзования в записях</span>
                </td>
                <td>
                    <input size="40" placeholder="Например: /\[[^\]]+\]/u" type="text" name="ortextprol[reg1]" value="<?php
                    if (!empty($ortextprol['reg1'])) {
                        echo $ortextprol['reg1'];
                    }
                    ?>" />
                    <span class="description">Здесь вы можете указать регулярное выражение, которое будет использовано при очистке текста перед публикацией в Яндекс.</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Правила очистки текста №2</th>
                <td>
                    <input type="checkbox" name="ortextprol[ck_reg2]" <?php
                    if (isset($ortextprol['ck_reg2'])) {
                        checked($ortextprol['ck_reg2'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Включить ваше правило №2 очистки текста?</span>
                </td>
                <td>
                    <input placeholder="Например: Рубить картинки" type="text" name="ortextprol[namereg2]" value="<?php
                    if (!empty($ortextprol['namereg2'])) {
                        echo $ortextprol['namereg2'];
                    }
                    ?>" />
                    <span class="description">Имя вашего правила, для удобства испоьзования в записях</span>
                </td>
                <td>
                    <input size="40" placeholder="Например: /\[[^\]]+\]/u" type="text" name="ortextprol[reg2]" value="<?php
                    if (!empty($ortextprol['reg2'])) {
                        echo $ortextprol['reg2'];
                    }
                    ?>" />
                    <span class="description">Здесь вы можете указать регулярное выражение, которое будет использовано при очистке текста перед публикацией в Яндекс.</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Правила очистки текста №3</th>
                <td>
                    <input type="checkbox" name="ortextprol[ck_reg3]" <?php
                    if (isset($ortextprol['ck_reg3'])) {
                        checked($ortextprol['ck_reg3'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Включить ваше правило №3 очистки текста?</span>
                </td>
                <td>
                    <input placeholder="Например: Рубить дрова" type="text" name="ortextprol[namereg3]" value="<?php
                    if (!empty($ortextprol['namereg3'])) {
                        echo $ortextprol['namereg3'];
                    }
                    ?>" />
                    <span class="description">Имя вашего правила, для удобства испоьзования в записях</span>
                </td>
                <td>
                    <input size="40" placeholder="Например: /\[[^\]]+\]/u" type="text" name="ortextprol[reg3]" value="<?php
                    if (!empty($ortextprol['reg3'])) {
                        echo $ortextprol['reg3'];
                    }
                    ?>" />
                    <span class="description">Здесь вы можете указать регулярное выражение, которое будет использовано при очистке текста перед публикацией в Яндекс.</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Правила очистки текста №4</th>
                <td>
                    <input type="checkbox" name="ortextprol[ck_reg4]" <?php
                    if (isset($ortextprol['ck_reg4'])) {
                        checked($ortextprol['ck_reg4'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Включить ваше правило №4 очистки текста?</span>
                </td>
                <td>
                    <input placeholder="Например: Рубить капусту" type="text" name="ortextprol[namereg4]" value="<?php
                    if (!empty($ortextprol['namereg4'])) {
                        echo $ortextprol['namereg4'];
                    }
                    ?>" />
                    <span class="description">Имя вашего правила, для удобства испоьзования в записях</span>
                </td>
                <td>
                    <input size="40" placeholder="Например: /\[[^\]]+\]/u" type="text" name="ortextprol[reg4]" value="<?php if (!empty($ortextprol['reg4'])) {
                        echo $ortextprol['reg4'];
                    } ?>" />
                    <span class="description">Здесь вы можете указать регулярное выражение, которое будет использовано при очистке текста перед публикацией в Яндекс.</span>
                </td>
            </tr>


            </tr>
        </table>
    </fieldset>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="ortextprol" />
    <p class="submit">
        <input type="submit" class="btn btn-large btn-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>


