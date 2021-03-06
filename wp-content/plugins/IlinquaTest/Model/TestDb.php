<?php

namespace IlinquaTest\Model;

Class TestDb
{
    const TABLE_NAME = 'test';

    public function add_customer($name, $phone, $email)
    {
        global $wpdb;
        $status = $_SERVER['HTTP_USER_AGENT'];
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $wpdb->query( $wpdb->prepare(
            "
            INSERT INTO  $table_name ( name, phone, email, status, date)
            VALUES ( %s, %s, %s, %s, NOW());
	        ",
            array(
                esc_sql($name),
                esc_sql($phone),
                esc_sql($email),
                esc_sql($status),
            )
        ));
        return $wpdb->insert_id;
    }

    public function getTests()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $sql = "SELECT id, name, email, phone, status, info, test, score , date FROM  $table_name";
        $wpdb->query($sql);
        $result = $wpdb->get_results($sql, ARRAY_A);
        return $result;
    }

    public function getTestById($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $sql = "SELECT id, name, phone, info, email, test from $table_name WHERE id='$id'";
        $wpdb->query($sql);
        $result = $wpdb->get_results($sql, ARRAY_A);
        return $result;
    }

    public function update_status($id, $status)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $sql = "UPDATE $table_name SET status = '$status' WHERE id= '$id'";
        return $wpdb->query($sql);


    }

    public function updateTest($testerId, $testId, $answers)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . self::TABLE_NAME;
        $sql = "UPDATE $table_name SET test = '$testId', info='$answers' WHERE id='$testerId'";
        return $wpdb->query($sql);
    }

    public function deleteTest($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix .self::TABLE_NAME;
        $sql = "DELETE FROM $table_name WHERE id=$id";
        $wpdb->query($sql);

    }

    public function change_charset($string){
        mb_convert_encoding($string, 'windows-1251', 'utf-8');
        return $string;
    }

    public function export_csv()
    {
        $customers = $this->get_customers();
        if ($customers) {
            $exportfile = array();
            foreach($customers as $customer){

                $name = $this->change_charset($customer['name']);
                $phone = $this->change_charset($customer['phone']);
                $status = $this->change_charset($customer['status']);
                switch($status){
                    case 0 : $status = 'New!'; break;
                    case 1 : $status = 'Processed'; break;
                    case 2 : $status = 'Rejected'; break;
                    default : $status = 'unknown';
                }
                $date = $this->change_charset($customer['date']);

                $exportfile[] = array($customer['id'],$name , $phone , $status, $date);
            }
            return $exportfile;
        }
    }

    public function download_send_headers($filename)
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    public  function array2csv($titles)
    {
        $array = $this->export_csv();
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, $titles, ';');
        foreach ($array as $row) {
            fputcsv($df, $row, ';');
        }
        fclose($df);
        return ob_get_clean();
    }
}