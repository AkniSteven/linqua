<?php

/**
 * Класс с функционалом и обработками
 */
class OrTextFunc {

    const YANDEX_ADD_APLICATION = 'https://oauth.yandex.ru/client/new'; //Урл создания нового приложения Яндекс
    const YANDEX_APP_APLICATION = 'https://oauth.yandex.ru/client/my'; // Урл к выбору прилжоения
    const YANDEX_Callback_FUNCTION = 'https://oauth.yandex.ru/verification_code'; // УРЛ Функции callback для приложения
    const YANDEX_TOKEN_URL = 'https://oauth.yandex.ru/authorize?response_type=code&client_id='; //УРЛ для получения токена
    const YANDEX_WEBMASTER_HOST = 'api.webmaster.yandex.net'; // УРЛ ВебМастера
    const YANDEX_API_REQUEST_TIMEOUT = 5; // Таймаунт запроса
    const YANDEX_MAX_POST_DAY = '100'; //Максимальное количество текстов в сутки
    const YANDEX_MIN_SIZE_POST = '500'; // Минимальное количество символов  в посте
    const YANDEX_MAX_SIZE_POST = '32000'; // Максимальное количество символов в посте

    /**
     * Условия
     */

    public function IfElseUpdate() {
        $ortext_posttype = get_option('ortext_posttype'); //Типы постов
        if (empty($ortext_posttype)) { //установка опции по умолчанию
            update_option('ortext_posttype', array('post' => 'post'));
        }
    }

    /**
     * Получение от Яндекса Токена
     * 
     * @return string
     */
    public function getYandexToken() {
        $ortext_id = get_option('ortext_id');
        $url = self::YANDEX_TOKEN_URL . $ortext_id;
        return $url;
    }

    /**
     * Отправка зпроса Yandex, возврат список сайтов
     * @deprecated since version При переходе на новый API Яндекс
     */
    public function getWebsiteXml() {

        $ortext_id = get_option('ortext_id');
        $ortext_passwd = get_option('ortext_passwd');
        $ortext_token = get_option('ortext_token');
        $ortext_token_key = get_option('ortext_token_key'); // Токен яндекса

        $userID = self::getUserId(); //индификатор пользователя

        $headers = array(
            'GET /api/v2/hosts HTTP/1.1',
            'Host: webmaster.yandex.ru',
            'Authorization: OAuth ' . $ortext_token_key
        );

        $requestOptions = array(
            CURLOPT_URL => 'https://' . self::YANDEX_WEBMASTER_HOST . '/api/v2/hosts',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CONNECTTIMEOUT => self::YANDEX_API_REQUEST_TIMEOUT,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        );

        $response = $this->getPage($requestOptions);
        if ($response['info']['http_code'] == 200 and strlen($response['result']) > 0) {
            $dom = new DOMDocument();
            if ($dom->loadXML($response['result'])) {
                foreach ($dom->getElementsByTagName('host') as $host) {
                    $host_href = $host->getAttribute('href');
//echo $host_href."<br>";
                    $id_array = explode("/", $host_href);
                    $siteid = array_pop($id_array); //id сайта
//echo $siteid."<br>";
                    $name = $host->getElementsByTagName('name')->item(0)->nodeValue;
//print_r($name);
                    $status = $host->getElementsByTagName('verification')->item(0)->getAttribute('state');
                    $result[] = array('name' => $name, 'status' => $status, 'siteid' => $siteid);
                }
            }

// return $response;
            return $result;
        }
        return "Ошибка";
    }

    /**
     * Получает список сайтов делая запрос в виде JSON
     * @return ассоциативный массив сайтов или false
     */
    public static function getWebsiteJson() {
        $ortext_id = get_option('ortext_id');
        $ortext_passwd = get_option('ortext_passwd');
        $ortext_token = get_option('ortext_token');
        $ortext_token_key = get_option('ortext_token_key'); // Токен яндекса

        $userID = self::getUserId(); //индификатор пользователя
        if (empty($userID)) {
            return false;
        }

        $url = 'https://' . self::YANDEX_WEBMASTER_HOST . '/v3/user/' . $userID . '/hosts/';
        $curlinfo = wp_remote_post(
                $url, array(
            'method' => 'GET',
            'headers' => array('Authorization' => 'OAuth ' . $ortext_token_key, 'content-type' => 'application/json'),
            'timeout' => 7,
            'redirection' => 5,
            'httpversion' => '1.1'
                )
        );
        if (is_wp_error($curlinfo)) { //Проверка переменной на содержание ошибки
            return false;
        } else {
            $response = $curlinfo['response'];
            switch ($response['code']) {
                case'200':
                    $result = json_decode($curlinfo['body'], TRUE);
                    $return = $result;
                    break;
                default:
                    $return = false;
                    break;
            }

            return $return['hosts'];

            //echo $return;
        }

        return "Ошибка";
    }

    /**
     * Запрос токена у яндекса + время жизни токена
     * @return object     $result->access_token - Токен
     * $result->expires_in - Время жизни токена в секундах
     * 
     */
    public function zaprosToken() {
        $url = 'https://oauth.yandex.ru/token';
        $ortext_id = get_option('ortext_id');
        $ortext_passwd = get_option('ortext_passwd');
        $ortext_token = get_option('ortext_token');
        $postData = "grant_type=authorization_code&code=" . $ortext_token . "&client_id=" . $ortext_id .
                "&client_secret=" . $ortext_passwd;
        $headers = array(
            "POST /token HTTP/1.1",
            "Host: oauth.yandex.ru",
            "Content-type: application/x-www-form-urlencoded",
            "Content-Length: " . strlen($postData)
        );
        $curlOptions = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => self::YANDEX_API_REQUEST_TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => $headers
        );
        $response = $this->getPage($curlOptions);
//print_r($response);
        if ($response['info']['http_code'] == 200) {
            return json_decode($response['result']);
        }
        return "Не получилось";
    }

    /**
     * Запрос параметров через Курл
     * @param type $curlOptions
     * @return type
     */
    public function getPage($curlOptions = array()) {
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        return array('result' => $result, 'info' => $info);
    }

    /**
     * Отправка Текстов в Сервис Оригинальные тексты
     * @param string $text2 Текст для загрузки
     * @return array code Код ошибки
     */
    public static function sendTextOriginal2($text2) {
//        ini_set('display_errors', 'Off');
//        error_reporting('E_ALL');
        $ortext_loadsite = get_option('ortext_loadsite'); //Текущий загруженный проект
        $ortext_token_key = get_option('ortext_token_key'); // Токен яндекса
        $text = array('content' => $text2);



        $userID = self::getUserId(); //индификатор пользователя
        if (empty($userID)) {
            return false;
        }

        $url = 'https://' . self::YANDEX_WEBMASTER_HOST . '/v3/user/' . $userID . '/hosts/' . $ortext_loadsite . '/original-texts/';
        $curlinfo = wp_remote_post(
                $url, array(
            'method' => 'POST',
            'headers' => array('Authorization' => 'OAuth ' . $ortext_token_key, 'content-type' => 'application/json'),
            'body' => json_encode($text),
            'timeout' => 7,
            'redirection' => 5,
            'httpversion' => '1.1'
                )
        );
        $idYa = '';
        $quota = ''; //Квота на день (осталось)
        if (is_wp_error($curlinfo)) { //Проверка переменной на содержание ошибки
            return array('code' => 000, 'id' => $idYa);
        } else {
            $response = $curlinfo['response'];
            $body = json_decode($curlinfo['body'], TRUE);
            if ($response['code'] == '201') {
//Не xml, так как выбивает белый экран
                $idYa = $body['text_id'];
                $quota = $body['quota_remainder'];
                return array('code' => 201, 'id' => $idYa, 'quota' => $quota);
            } elseif ($response['code'] == '400') {
                return array('code' => 400, 'id' => $idYa, 'quota' => $quota);
            } elseif ($response['code'] == '403') {
                return array('code' => 403, 'id' => $idYa, 'quota' => $quota);
            } elseif ($response['code'] == '401') {
                return array('code' => 401, 'id' => $idYa, 'quota' => $quota);
            } elseif ($response['code'] == '409') {
                return array('code' => 409, 'id' => $idYa, 'quota' => $quota);
            } elseif ($response['code'] == '500') {
                return array('code' => 500, 'id' => $idYa, 'quota' => $quota);
            } else {
                return array('code' => 777, 'id' => $idYa, 'quota' => $quota);
            }
        }
    }

    /**
     * Получение индификатора пользователя
     * @return int Индификатор пользователя Яндекс или false
     * 
     */
    public static function getUserId() {
        $url = 'https://api.webmaster.yandex.net/v3/user/';
        $ortext_loadsite = get_option('ortext_loadsite'); //Текущий загруженный проект
        $ortext_token_key = get_option('ortext_token_key'); // Токен яндекса
        $curlinfo = wp_remote_post(
                $url, array(
            'method' => 'GET',
            'headers' => array('Authorization' => 'OAuth ' . $ortext_token_key, 'content-type' => 'application/json'),
            'timeout' => 7,
            'redirection' => 5,
            'httpversion' => '1.1'
                )
        );

        if (is_wp_error($curlinfo)) { //Проверка переменной на содержание ошибки
            return false;
        } else {
            $response = $curlinfo['response'];
            switch ($response['code']) {
                case'200':
                    $result = json_decode($curlinfo['body'], TRUE);
                    $return = $result['user_id'];
                    break;
                default:
                    $return = false;
                    break;
            }


            return $return;
            //echo $return;
        }
    }

    /**
     * Проверка Чекеда
     * @param string $options Опция из базы данных
     * @param string $value Текущее значение для сравнения (например значение из цикла)
     * @return echo checked или пусто
     */
    public function chekedOptions($options, $value) {
        if (!empty($options) or ! empty($value)) {
            if ($options == $value) {
                echo 'checked';
            } elseif ($options !== $value) {
                echo '';
            }
        }
    }

    /**
     * Функция логирования, для вкладки журнал
     * @param int $idpost ид поста
     * @param string $title Заголовок поста
     * @param string $status Статуст поста
     * @param string $post_type Тип поста
     * @param string $idyandex Ид добавленного текста в яндексе
     */
    public static function logJornal($idpost, $title, $status, $post_type, $idyandex = '', $quota = '') {
        $includ_jornal = get_option('ortext_jornal_inc');
        if ($includ_jornal == '1') {

            $ortext_jornal_old = get_option('ortext_jornal');
//$time=date('d-m-Y', time()); // Дата запуска функции
            $time = current_time('mysql');
            $ortext_jornal_temp = array('time' => $time, 'idpost' => $idpost, 'title' => $title, 'status' => $status, 'post_type' => $post_type, 'idyandex' => $idyandex,'quota'=>$quota);
            $ortext_jornal_new = array();
            $ortext_jornal_new = $ortext_jornal_old;
            array_push($ortext_jornal_new, $ortext_jornal_temp);
            update_option('ortext_jornal', $ortext_jornal_new);
        }
    }

    /**
     * Поиск строки по началу и концу
     */
    private static function cutTextStartEnd($text, $start, $end) {
        $posStart = stripos($text, $start);
        if ($posStart === false)
            return false;

        $text = substr($text, $posStart + strlen($start));
        $posEnd = stripos($text, $end);
        if ($posEnd === false)
            return false;

        $result = substr($text, 0, 0 - (strlen($text) - $posEnd));
        return $result;
    }

}
