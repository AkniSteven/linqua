<?php

namespace IlinquaTest\Model;

class Mailer
{
    /**
     * This is Mailer object.
     * @var $_instance
     */
    private static $_instance;
    /**
     * @var $_senderName
     */
    private $_senderName;
    /**
     * @var $_senderEmail
     */
    private $_senderEmail;
    /**
     * @var $_recipient
     */
    private $_recipient;

    /**
     * @var $_mailTemplate
     */
    private $_mailTemplate;

    /**
     * @var $_customerMailTemplate
     */
    private $_customerMailTemplate;

    /**
     * @var $_mailTheme
     */
    private $_mailTheme;

    /**
     * @var $_customerMailTheme
     */
    private $_customerMailTheme;


    /**
     * Mail variables
     *
     * @var array
     */
    private $_mailVariables = [
        'tester_name' => '{tester_name}',
        'tester_email' => '{tester_email}',
        'tester_tel' => '{tester_tel}',
        'test_result' => '{test_result}',
        'test_name' => '{test_name}',
        'test_date' => '{test_date}',
        'test_score' => '{test_score}'
    ];

    public function __construct()
    {
        $options = (array) get_option('test-config');

        $this->_senderEmail =  $options['sender_email']
            ? $options['sender_email'] : get_option('admin_email');
        $this->_senderName = $options['sender_name']
            ? $options['sender_name'] : '';
        $this->_recipient = $options['recipient']
            ? $options['recipient'] : '';
        $this->_mailTemplate = $options['mail']
            ? $options['mail'] : '';
        $this->_customerMailTemplate = $options['customer_mail']
            ? $options['customer_mail'] : '';
        $this->_mailTheme = $options['mail_theme']
            ? $options['mail_theme'] : 'Test';
        $this->_customerMailTheme = $options['customer_mail_theme']
            ? $options['customer_mail_theme'] : 'Test';
    }

    /**
     * @param array $data
     * @return string
     */
    private function getMailBody(array $data)
    {
        $mailBody = $this->_mailTemplate;

        if (is_array($data)) {
            $mailBody = str_replace($this->_mailVariables, $data, $mailBody);
        }
        return $mailBody;
    }


    /**
     * @param array $data
     * @return string
     */
    private function getCustomerMailBody(array $data)
    {
        $mailBody = $this->_customerMailTemplate;

        if (is_array($data)) {
            $mailBody = str_replace($this->_mailVariables, $data, $mailBody);
        }
        return $mailBody;
    }

    /**
     * SendMail method
     * @param array $data
     * @return bool
     */
    public function sendMail(array $data)
    {
        if (!empty($data)) {
            $mailBody = $this->getMailBody($data);
            if ($this->_senderEmail != '' && $this->_recipient != '' && $mailBody !='') {
                $headers[] = "Content-type: text/html; charset=utf-8";
                do_action('plugins_loaded');
                $headers[] = "From:{$this->_senderName} <{$this->_senderEmail}>";
                $headers[] = $this->_mailTheme;
                $send = wp_mail( $this->_recipient, $this->_mailTheme, $mailBody, $headers);
                return  $send;
            }
        }
        return false;
    }

    /**
     * SendCustomerMail method
     * @param array $data
     * @return bool
     */
    public function sendCustomerMail(array $data)
    {
        //specify the email address you are sending to, and the email subject
        if (!empty($data)) {
            $mailBody = $this->getCustomerMailBody($data);
            $boundary = uniqid('np');

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "From: $this->_senderName $this->_senderEmail\r\n";
            $headers .= "To: " . $data['tester_email'] . "\r\n";
            $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

            $message = strip_tags($mailBody);
            $message .= "\r\n\r\n--" . $boundary . "\r\n";
            $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

            $message .= "Hello,\nThis is a text email, the text/plain version.\n\nRegards,\nYour Name";
            $message .= "\r\n\r\n--" . $boundary . "\r\n";
            $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";

            $message .= $mailBody;
            $message .= "\r\n\r\n--" . $boundary . "--";

            mail('', $this->_customerMailTheme, $message, $headers);
        }

        return true;

//        if (!empty($data)) {
//            $mailBody = $this->getCustomerMailBody($data);
//            if ($data['tester_email'] != ''  && $mailBody !='') {
//                $headers[] = "Content-type: text/html; charset=utf-8";
//                do_action('plugins_loaded');
//                $headers[] = "From:{$this->_senderName} <{$this->_senderEmail}>";
//                $headers[] = $this->_customerMailTheme;
//                $send = wp_mail($data['tester_email'], $this->_customerMailTheme, $mailBody, $headers);
//                return  $send;
//            }
//        }
//        return false;
    }
}