<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data, $message, $result = 200){
        return response()->json([
            'result'  => $result,
            'message' => $message,
            'data'    => $data
        ]);
    }

    public function error(\Exception $e, $code = 500){
        return response()->json([
            'result'  => false,
            'message' => $e->getMessage(),
            'data'    => [],
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
        ], $code);
    }

    public function fail($data, $message, $result = false, $code = 500){
        return response()->json([
            'result'  => $result,
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}
