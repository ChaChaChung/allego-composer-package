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
        $return_text = '';

        // 檢查資料表是否存在
        if (!Schema::hasTable('access_log')) {
            // 創建資料表
            Schema::create('access_log', function (Blueprint $table) {
                $table->id();
                $table->string('user'); // 範例欄位
                $table->string('action'); // 範例欄位
                $table->timestamps(); // created_at 和 updated_at
            });

            $return_text = 'Table "access_log" created successfully.';
        }

        $return_text = 'Table "access_log" already exists.';

        return $return_text;
    }

    public static function WriteAccessLog()
    {
        $return_text = self::checkAndCreateTable();

        return $return_text;
    }
}
