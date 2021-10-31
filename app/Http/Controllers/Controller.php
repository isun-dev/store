<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $token = "6BYNQsD4WZExgjooY4jCzV4AQA4gFIaTm3K5Sxqr5_aG166Y4zXREV_vxg9fwPjA";

    public function token(Request $request)
    {
        return $this->token;
    }

    public function check_token($check_header): bool
    {
        if ($check_header == $this->token) {
            return true;
        } else {
            return false;
        }
    }

    public function product(Request $request)
    {
        $check_header = $request->header('Authorization');
        $check_token = $this->check_token($check_header);

        if ($check_token) {
            $name = $request->input('name');
            $fruits = array("배" => 3000, "토마토" => 2000, "사과" => 4000, "바나나" => 5000);
            $fruit = array("배", "토마토", "사과", "바나나");
            if ($name) {
                if (!in_array($name, $fruit)) {
                    abort(400);
                } else {
                    return $fruits[$name];
                }

            } else {
                // 과일 목록 조회
                return $fruit;
            }
        } else {
            abort(400);
        }
    }

    public function item(Request $request)
    {
        $check_header = $request->header('Authorization');
        $check_token = $this->check_token($check_header);

        if ($check_token) {
            $name = $request->input('name');
            $vegetables = array("치커리" => 3000, "토마토" => 2000, "깻잎" => 1500, "상추" => 5000);
            $vege = array("치커리", "토마토", "깻잎", "상추");
            if ($name) {
                if (!in_array($name, $vege)) {
                    abort(400);
                } else {
                    return $vegetables[$name];
                }
            } else {
                return $vege;
            }
        } else {
            abort(400);
        }
    }
}
