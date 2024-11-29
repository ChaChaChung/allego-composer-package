<?php

namespace App\Http\Controllers\GlobalFunc;

use App\Http\Controllers\Controller;

class CTL_G_Helper extends Controller
{
    /**
     * Development by Riekie
     * 2019-03-15
     * 讀取執行端的IP資訊(共用函式)
     * 暫時先以一組為主，後續再來考慮調整方式
     */
    public static function Get_Access_IP() {
        // 取得目前的 IP 位置

        //HTTP_CLIENT_IP
        $client_ip = self::Get_Http_Client_IP();

        //HTTP_X_FORWARDED_FOR
        $forwarded_for = self::Get_Http_X_Forwarded_For() ;

        //REMOTE_ADDR
        $remote_addr = self::Get_Remote_Addr();

        //X-USER-IP
        if (!empty($_SERVER['X-USER-IP'])) {
            $x_user_ip = $_SERVER['X-USER-IP'];
        }else{
            $x_user_ip = '' ;
        }

        // 回傳 IP
        $ip_info = '' ;
        if ($client_ip !== ''){
            $ip_info = 'C:[' . $client_ip . '] ' ;
        }
        if ($forwarded_for !== ''){
            $ip_info = $ip_info . 'F:[' . $forwarded_for . '] ';
        }
        if ($remote_addr !== ''){
            $ip_info = $ip_info . 'R:[' . $remote_addr . '] ';
        }
        if ($x_user_ip !== ''){
            $ip_info = $ip_info . 'U:[' . $x_user_ip . '] ';
        }
        return $ip_info ;
    }

    public static function Get_Http_Client_IP() {
        // 取得目前的 IP 位置
        $ip_address = '';

        //HTTP_CLIENT_IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $Http_Client_Ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        // 回傳 IP
        return $ip_address ;
    }

    public static function Get_Http_X_Forwarded_For() {
        // 取得目前的 IP 位置
        $ip_address = '';

        //HTTP_X_FORWARDED_FOR
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // HTTP_X_FORWARDED_FOR 格式 = client1, proxy1, proxy2 ...
            // $x_client_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            // // 取第一個 client_ip
            // $forwarded_for = $x_client_ip[0];
            $ip_address =$_SERVER['HTTP_X_FORWARDED_FOR'] ;
        }

        // 回傳 IP
        return $ip_address ;
    }

    public static function Get_Remote_Addr() {
        // 取得目前的 IP 位置
        $ip_address = '';

        //REMOTE_ADDR
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        // 回傳 IP
        return $ip_address ;
    }
}
