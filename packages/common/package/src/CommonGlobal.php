<?php

namespace Common\Package;

use App\Http\Controllers\Controller;

class CommonGlobal extends Controller
{
    public static $Company_SID = 0; // 儲存組織 SID
    public static $Terminal_SID = ''; // 儲存終端 SID
}
