<?php

/**
 * Класс для работы с JavaScript функциями отправляемыми через скрипты
 */
class OrtextJavaScript {

    /**
     * Конструктор класса
     */
    public function __construct() {
        $this->addaction();
    }

    /**
     * Адды
     */
    public function addaction() {
        //Управление галкой ведения журнала
        add_action('wp_ajax_incjornal', array($this, 'ajaxClearChek'));
        add_action('wp_ajax_nopriv_incjornal', array($this, 'ajaxClearChek'));
        //Включатель сообщений об ошибках

        add_action('wp_ajax_incerrormessage', array($this, 'ajaxChekError'));
        add_action('wp_ajax_nopriv_incerrormessage', array($this, 'ajaxChekError'));
        //Отправлялка через кнопку в редакторе записи
        add_action('wp_ajax_posttoyandex', array($this, 'ajaxSentYandex'));
        add_action('wp_ajax_nopriv_posttoyandex', array($this, 'ajaxSentYandex'));
    }

    /**
     * Обаботка приходящих данных о галочке Журнала
     * Установка чекбокса
     */
    public function ajaxClearChek() {
        $text = $_POST['text'];
        if ($text === 'checked') {
            $opt = 1;
        } else {
            $opt = 0;
        }
        update_option('ortext_jornal_inc', $opt);
        wp_die();
    }

    /**
     * Обаботка приходящих данных о галочке ведения сообщений ошибок
     * Установка чекбокса
     */
    public function ajaxChekError() {
        $text = $_POST['text'];
        if ($text === 'checked') {
            $opt = 1;
        } else {
            $opt = 0;
        }
        update_option('ortext_error_inc', $opt);
        wp_die();
    }

    /**
     * Принимает вызов кнопки с редактора, для повторной отправки текста в яндекс
     */
    public function ajaxSentYandex() {
        $post_id = $_POST['text'];
        $coreclass = new OrTextBase();
        $inf = $coreclass->metaboxSentYandex($post_id, 'ajaxsent');
        if ($inf == '201' OR $inf == '409') {
            update_post_meta($post_id, '_ortext_error', '201');
            echo "good";
        }
        wp_die();
    }

}
