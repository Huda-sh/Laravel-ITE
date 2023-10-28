<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserNames(): JsonResponse
    {
        $file_contents = file_get_contents('user_names.json');
        $json_content = json_decode($file_contents);
        $names = [];
        foreach ($json_content as $item) {
            $names[] = ucfirst($item);
//            $names[] = strtoupper($item);
        }
        return response()->json($names);
    }

    public function checkUser(Request $request)
    {
        $email = $request->query('email');
        $phone_number = $request->query('phone_number');
        if (!$email && !$phone_number ){
            return response()->json("Enter either email or phone number");
        }
        $file_contents = file_get_contents('user_info.json');
        $json_content = json_decode($file_contents);
        foreach ($json_content as $item) {
            if (($email && $item->email == $email) || ($phone_number && $item->phone_number == $phone_number)){
                return response()->json("welcome, $item->name");
            }

        }
        return response()->json('the user does not exist');
    }
}
