<?php

namespace Common\Package;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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

    public static function WriteAccessLog()
    {
        $return_text = '';
        try {
            $return_text = self::checkAndCreateTable();
    
            return $return_text;
        } catch (\Exception $e) {
            $return_text = $e->getMessage();
        } finally {
            return $return_text;
        }
    }
}
