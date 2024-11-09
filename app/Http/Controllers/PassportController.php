<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Merchants;
use App\Notifications\UserCreated;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PassportController extends Controller
{
    //
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'account_type' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token], 200);
    }


    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerCustomer(Request $request)
    {

        try {

        $this->validate($request, [
            'first_name' => 'required|min:3',
            'middle_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'imei' => 'required|min:10',
            'phone' => 'required|min:12',
            'password' => 'required|min:6',
            'fingerprint' => 'required'
        ]);

        //temporarily using this as a password
            $randomid = mt_rand(100000,999999);

        $request->email = $request->phone . "@mpontetech.co.tz";

        $user = User::create([
            'name' => $request->first_name . " " . $request->middle_name . " " . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($randomid)
        ]);



        if($user) {
            //assign the merchant role and create the merchant object
            $user->assignRole('customer');

            //
            $userAccount = UserAccount::create([
                'user_id' => $user->id,
                'otp' => bcrypt($randomid),
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'status' => 0, //we'll add these on first login
                'imei' => $request->imei, //we add these on first login
                'm_n_o_id' => 1, //we add these on first login
                'fingerprint' => $request->fingerprint,
            ]);

//                $merchant->notify(new UserCreated("Testing notifications"));


            $themessage = "You M-Ponte Customer account has successfully been created.". PHP_EOL . "Your One Time Pin is " . $randomid;

            // app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($request->phone, $themessage);
        }



        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token], 200);
        } catch (\Exception $exception) {
            return response()->json(
                [
                    'message' => 'Registration failed',
                    'status' => false,
                    'error_message' => $exception->getMessage()
                ],
                500);
        }
    }


    /**
     * Handles Registration Request for Merchants
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerMerchant(Request $request)
    {
//        echo "Register Merchant";
//        die;
        try {
            $this->validate($request, [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required',
                'description' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            if($user) {
                //assign the merchant role and create the merchant object
                $user->assignRole('merchant');

                //
                $merchant = Merchants::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'lat' => '0.0', //we'll add these on first login
                    'long' => '0.0', //we add these on first login
                    'description' => $request->description
                ]);

//                $merchant->notify(new UserCreated("Testing notifications"));

                $randomid = mt_rand(100000,999999);

                $themessage = "You merchant account has successfully been created on M-Ponte". PHP_EOL . "Your One Time Pin is " . $randomid;

                // app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($request->phone, $themessage);
            }

            $token = $user->createToken($request->get('name'))->accessToken;

            return response()->json(['token' => $token], 200);
        } catch (\Exception $exception) {
            Log::error($exception->getTraceAsString());
            return response()->json(
                [
                    'message' => 'Registration failed',
                    'status' => false,
                    'error_message' => $exception->getMessage()
                ],
                500);
        }
    }



    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('M-Ponte' . $request->email)->accessToken;
            return response()->json(['token' => $token, 'user' => auth()->user()], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
