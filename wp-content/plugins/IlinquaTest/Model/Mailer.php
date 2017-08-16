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
                $headers[] = "Test";
                $send = wp_mail( $this->_recipient, 'Test', $mailBody, $headers);
                return  $send;
            }
        }
        return false;
    }
}