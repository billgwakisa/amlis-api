<?php

namespace App\Http\Controllers;

// use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Http\Request;

class TemporaryNotifyController extends Controller
{
    //
    public function sendNotification($recipient, $message) {


        try {
//             $username = "mponte";

// //        $username = 'YOUR_USERNAME'; // use 'sandbox' for development in the test environment
//             $apiKey = '195444114066733b67808c56a59560d9aa5c10732637e70edcf5db609964cd1b'; // use your sandbox app API key for development in the test environment
// //            $apiKey = '03c5155ee9830d164126944bd8ecd59a57bc803eff0df0f24127a5f56908faaf'; // use your sandbox app API key for development in the test environment
//             $AT = new AfricasTalking($username, $apiKey);

// // Get one of the services
//             $sms = $AT->sms();

// // Use the service
//             $result = $sms->send([
//                 'to' => $recipient,
//                 'message' => $message
//             ]);

// //            print_r($result);
//             return $result;
        } catch (\Exception $exception) {
            return $exception;
        }


    }
}
