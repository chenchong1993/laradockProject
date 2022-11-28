<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 腾讯云推送
     */
    public function tpns_push($user_id_list,$title,$content){

        // $user_id_list = json_decode(rq('user_id_list'),TRUE);

        $token_list = [];
        foreach ($user_id_list as $user_id) {
            $user = User::find($user_id);
            if (!$user) {
                return err(2,[$user_id=>['该用户不存在']]);               
            }else{
                $token = $user->tpns_token;
                if($token){
                   $token_list[]= $token;
                }
            }
        }

        $base64_auth_string = base64_encode(TPNS_ACCESS_ID.':'.TPNS_SECRET_KEY);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json","Authorization: Basic " . $base64_auth_string);

        $data = [
                    'audience_type' => 'token_list',
                    "token_list"=> $token_list,
                    "message_type"=> "message",
                    "message"=> [
                        "title"=> $title,
                        "content"=> $content
                    ]
                ];

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, TPNS_URL);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output,true);

        if (!json_decode($output,true)['ret_code']) 
            return suc();

        return err(1,$output);

    }
    
}
