<?php

namespace App\Http\Controllers;

use App\Models\Merchants;
use App\Models\User;
use App\Models\UserAccount;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            $merchants = UserAccount::with('linkedAccounts', 'mno', 'transactions')->get();

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to retrieve customer accounts',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully retrieved customer accounts!',
                'status' => true,
                'customers' => $merchants
            ],
            200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Authenticate M-Ponte User Account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request) {

//        echo "We are here";
//        die;
        Log::info("Hitting authenticate");

        //CHECK IF WE HAVE EITHER A PASSWORD OR A FINGERPRINT

        $this->validate($request, [
            'phone' => 'required',
            'merchant_id' => 'required',
            'password' => 'required_without:fingerprint',
            'fingerprint' => 'required_without:password'
        ]);

        //IF WE HAVE A PASSWORD, PERFORM AUTHENTICATION NORMALLY
        if($request->filled('password') && $request->password!='') {
            //do password auth


            $credentials = [
                'email' => $request->phone . "@mpontetech.co.tz",
                'password' => $request->password
            ];

            $merchant = User::find($request->merchant_id)->merchant()->first();

            if($merchant) {
                if (auth()->attempt($credentials)) {

                    $userAccount = auth()->user()->userAccount()->first();

                    $themessage = "You M-Ponte account has been used to log in at " . $merchant->name . ". Time: " . Carbon::now();

                    // app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($userAccount->phone, $themessage);


                    return response()->json([
                        'status' => true,
                        'user' => auth()->user()
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'error' => 'UnAuthorised'
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Merchant UnAuthorised'
                ], 401);
            }



        } else if ($request->filled('fingerprint')) {
            //do fingerprint auth

            //IF NO PASSWORD
            Log::info("UserAccountsController: authenticate: AFIS Call request: fingerprint received " . $request->fingerprint);

            //CHECK THE USER PHONE NUMBER TO CHECK IF THEY HAVE A FINGERPRINT SAVED

            Log::info('User query :: ' . $request->phone . "@mpontetech.co.tz");
            $theuser = User::where('email', $request->phone . "@mpontetech.co.tz")->first();

            if(!$theuser) {
                return response()->json([
                    'status' => false,
                    'error' => 'Unauthorised'
                ], 401);
            }

            Log::info('User :: ' . json_encode($theuser));

            $userAccount = $theuser->userAccount()->first();

            $authfingerprint = $userAccount->fingerprint;

            Log::info("UserAccountsController: authenticate: " . $request);


            //IF THEY HAVE A FINGERPRINT DO BELOW, OTHERWISE RETURN FALSE RESPONSE

            //PERFORM AUTH WITH FINGERPRINT THROUGH MP-AFIS

            Log::info("UserAccountsController: authenticate: AFIS Call request: authFingerprint " . $authfingerprint);
            Log::info("UserAccountsController: authenticate: AFIS Call request: fingerprint received " . $request->fingerprint);

            $client = new Client();
            $res = $client->request('POST', 'http://afis.mpontetech.co.tz:8080/mponte-afis/fingerprint-auth',
                ['json'    => [
                    'userFingerprint' => $authfingerprint,
                    'authFingerprint' => $request->fingerprint
                ]
            ]);
            //echo $res->getStatusCode();
            // 200
//            echo $res->getHeader('content-type');
            // 'application/json; charset=utf8'
            $body = $res->getBody();
            $contents = $body->getContents();

            Log::info("UserAccountsController: authenticate: AFIS Call response: " . $contents);

            $contents = json_decode($contents, true);//->status;

//            var_dump($contents['status']);

            $fpAuthStatus = false;

            if($contents['status'])
            {
                $fpAuthStatus = true;// "true";
            }
            else {
//                echo "false";
                $fpAuthStatus = false;
            }

            $merchant = User::find($request->merchant_id)->merchant()->first();

            if($merchant) {

                if ($fpAuthStatus) {

//                    $userAccount = auth()->user()->userAccount()->first();

                    $themessage = "You M-Ponte account has been used to log in at " . $merchant->name . ". Time: " . Carbon::now();

                    // app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($userAccount->phone, $themessage);


                    return response()->json([
                        'status' => true,
                        'user' => $theuser
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'error' => 'UnAuthorised'
                    ], 401);
                }
            } else {
            return response()->json([
                'status' => false,
                'error' => 'Merchant UnAuthorised'
            ], 401);
        }

        }

//        $credentials = [
//            'email' => $request->phone . "@mpontetech.co.tz",
//            'password' => $request->password
//        ];
//
//        $merchant = User::find($request->merchant_id)->merchant()->first();
//
//        if($merchant) {
//            if (auth()->attempt($credentials)) {
//
//                $userAccount = auth()->user()->userAccount()->first();
//
//                $themessage = "You M-Ponte account has been used to log in at " . $merchant->name . ". Time: " . Carbon::now();
//
//                app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($userAccount->phone, $themessage);
//
//
//                return response()->json([
//                    'status' => true,
//                    'user' => auth()->user()
//                ], 200);
//            } else {
//                return response()->json([
//                    'status' => false,
//                    'error' => 'UnAuthorised'
//                ], 401);
//            }
//        } else {
//            return response()->json([
//                'status' => false,
//                'error' => 'Merchant UnAuthorised'
//            ], 401);
//        }
    }
}
