<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait AMLISAI
{
    //
    public function performFraudCheck($type, $amount, $nameOrig, $nameDest) {
       
        $response = Http::withHeaders([
            'Authorization' => 'Bearer hfZ3J2zem0PQD6XGWieXeZ4ACnzvIGZe'
        ])->post('https://reli-olduvai-amlis-2-smpln.eastus.inference.ml.azure.com/score', [
            "input_data" => [
                "columns" => [
                    "step",
                    "type",
                    "amount",
                    "nameOrig",
                    "nameDest",
                    "isFlaggedFraud"
                ],
                "index" => [
                    0
                ],
                "data" => [
                    [
                        1,
                        $type,
                        $amount,
                        $nameOrig,
                        $nameDest,
                        0
                    ]
                ]
            ]
        ]);

        Log::info("Fraud check response");
        Log::info($response->body());

        $isFraud = json_decode($response->body());

        return $isFraud[0];
    }
}