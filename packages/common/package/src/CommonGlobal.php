<?php

namespace Common\Package;

use App\Http\Controllers\Controller;

class CommonGlobal extends Controller
{
    public static $Company_SID = 0; // 儲存組織 SID
    public static $Terminal_SID = ''; // 儲存終端 SID

    /* 處理API共用回傳資料格式 */
    /**
     * @param int    $http_code  // Response HTTP Status Code
     * @param string $api_status // Response API Status
     * @param string $api_msg    // Response API Message [option]
     * @param object $data       // Response Data [option]
     * @return \Illuminate\Http\JsonResponse
     */
    public static function APIResponseMsg($http_code, $api_status, $api_msg = '', $data = null)
    {
        $resp_data = array('status' => $api_status, 'message' => $api_msg);

        // 若有需要回傳的資料，則加入
        if (isset($data)) {
            $resp_data = array_merge($resp_data, array('data' => $data));
        }

        // 回傳資料
        return response()->json($resp_data, $http_code);
    }
}
