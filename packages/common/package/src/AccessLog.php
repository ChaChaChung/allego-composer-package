<?php

namespace Common\Package;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use App\Models\MDL_Access_Log;

class AccessLog extends Controller
{
    public static function AccessLog()
    {
        return 'AccessLog';
    }

    protected static function checkAndCreateTable()
    {
        try {
            $return_text = '';

            // 檢查資料表是否存在
            if (!Schema::hasTable('access_log')) {
                // 創建資料表
                Schema::create('access_log', function (Blueprint $table) {
                    $table->string('SID', 30); // varchar(30)
                    $table->char('log_type', 1); // char(1)
                    $table->integer('company_sid')->nullable(); // int(11) NULL
                    $table->string('access_sid', 100)->nullable(); // varchar(100) NULL
                    $table->string('access_ip', 100)->nullable(); // varchar(100) NULL
                    $table->string('func_name', 100)->nullable(); // varchar(100) NULL
                    $table->char('state_flag', 1)->default('N'); // char(1) with default 'N'
                    $table->longText('state_text')->nullable(); // longtext
                    $table->timestamp('created_time')->useCurrent(); // timestamp with default CURRENT_TIMESTAMP

                    // 設定主鍵
                    $table->primary('SID'); // SID 為主鍵
                });
    
                $return_text = 'Table "access_log" created successfully.';
            } else {
                $return_text = 'Table "access_log" already exists.';
            }

            return $return_text;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function WriteAccessLog($log)
    {
        $return_text = '';
        try {
            $return_text = self::checkAndCreateTable();

            // 先處理可能不存在的資料 ===================================================
            $log_type = $log->log_type ;
            $company_sid = $log->company_sid ;
            $access_sid = isset($data->access_sid) ? $data->access_sid : 0 ;
            // $access_ip = $log->access_ip ;
            $func_name = isset($data->func_name) ? $data->func_name : "" ;
            $state_flag = isset($data->state_flag) ? $data->state_flag : "N" ;
            $state_text = isset($data->state_text) ? $data->state_text : "" ;
            // ========================================================================

            $try_count = 0 ;
            $try_max_count = 3 ;    // 最大嘗試次數
            $append_success = false ;
            do {
                $try_count += 1 ;
                try{
                    $log_sid = uniqid(date('Ymd-')) ;
                    $result = MDL_Access_Log::insert([
                        'SID'           => $log_sid ,
                        'log_type'      => $log_type,
                        'company_sid'   => $company_sid,
                        'access_sid'    => $access_sid,
                        // 'access_ip'     => $access_ip,
                        'func_name'     => $func_name,
                        'state_flag'    => $state_flag,
                        'state_text'    => $state_text,
                        'created_time'  => date('Y-m-d H:i:s')
                    ]);
                    // 若成功，直接離開
                    $append_success = true ;
                    break ;
                }catch(\Throwable $e)   {
                    if ( $try_count >= $try_max_count ){
                        throw new \Exception("Too Many try write to access_log fail => \n" . $e->getMessage());
                    }
                }
            } while ( $try_count < $try_max_count && !$append_success );
    
            return $return_text;
        } catch (\Exception $e) {
            $return_text = $e->getMessage();
        } finally {
            return $return_text;
        }
    }

    /**
     * 初始化要記錄的 Log 內容並寫入資料庫
     * @param string  $log_type    // Log 類型
     * @param string  $func_name   // Log 功能名稱
     * @param boolean $state_flag  // Log 狀態
     * @param string  $state_text  // Log 內容
     * @param int     $company_sid // Log 的組織 SID
     * @param int     $user_sid    // Log 的使用者 SID
     */
    public static function LogHandle($log_type, $func_name, $state_flag, $state_text, $company_sid = null, $user_sid = null)
    {
        $func_name = __FUNCTION__;
        try {
            // 取得記錄者資料
            $company_sid = isset($company_sid) ? $company_sid : 0;
            $user_sid = isset($user_sid) ? $user_sid : 0;

            // 將要存到 access_log 的資料寫到一包 Object 內
            $data = new \stdClass();
            $data->log_type    = $log_type;
            $data->company_sid = $company_sid;
            $data->access_sid  = $user_sid;
            $data->func_name   = $func_name;
            $data->state_flag  = $state_flag ? 'S' : 'F';
            $data->state_text  = "#$user_sid# $state_text";

            // 寫入 Log
            self::WriteAccessLog($data);
        } catch (\Throwable $e) {
            // 拋出例外
            throw new \Exception("[$func_name] Fail => " . $e->getMessage());
        }
    }

}
