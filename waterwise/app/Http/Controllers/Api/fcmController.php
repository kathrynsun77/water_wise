<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class fcmController extends Controller
{
    public function sendMessage(Request $request)
    {
        $url="https://fcm.googleapis.com/fcm/send";
        $serverKey='AAAAm_dVqjY:APA91bFnHrboZik6rTMnUEisH7rtpoT5EZcEqMDsi6FXJ9w8cvSPPgXnDt5FAQOrzXRFS7Dc0vfhO4ic1i9VsGQ6PDcnEoxZpyaNXiRLCT2Ns5xUsKE4oUy3iFRB4tLqSvzdrtVvO_ml';
        $data=[
            'registration_ids'=>['dnglZVtbSryLd2tQ6eTBqm:APA91bGOwPHJx27d6Vw1bXO2UxGI9GkZNsjVDAa8BvBgGbLJ4oYyqiBiURHqNVfyZlNwQq4JHhpFM36uEAPTPlcYhJjrHUHZRMn1qSvnJNVCCwHeO7CHqaktptPVm1vum28-queiDwJJ'],
            'notification'=>[
                'title'=> $request->title,
                'body'=> $request->body,
            ]
        ];
        $encodedData=json_encode($data);
        $headers=[
            'Authorization:key='.$serverKey,
            'Content-Type:application/json'
        ];

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_PROXY_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$encodedData);
        $result=curl_exec($ch);

        if($result===false){
            die('CURL failed: '.curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
