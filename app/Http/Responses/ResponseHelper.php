<?php

namespace App\Http\Responses;

class ResponseHelper
{
    public static function Ok($data, $status = 200)
    {
        return response()->json(
            [
                "data" => $data,
                "status" => $status
            ],
            $status
        );
    }
}
