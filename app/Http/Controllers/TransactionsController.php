<?php

namespace App\Http\Controllers;

use App\Models\Merchants;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\AMLISAI;

class TransactionsController extends Controller
{

    use AMLISAI;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            $transactions = Transactions::all();

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to retrieve transactions',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully retrieved transactions!',
                'status' => true,
                'transactions' => $transactions
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
        try {            

            $transaction = Transactions::create($request->all());

            //perform check with AMLIS AI
            $isFlaggedFraud = $this->performFraudCheck($request->type, $request->amount, $request->origin_name, $request->dest_name);
        
            $transaction->is_flagged_fraud = $isFlaggedFraud;
            $transaction->save();
//

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to initiate transaction',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully initiated transaction!',
                'status' => true,
                'transaction' => $transaction
            ],
            200);
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


    public function statsByHour() {


        //
        try {



            $transactions = Transactions::selectRaw('COUNT(*) as count, HOUR(created_at) hour')
                ->groupBy('hour')
                ->get();

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to retrieve transactions stats',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully retrieved transactions!',
                'status' => true,
                'transactions' => $transactions
            ],
            200);
    }



    public function statsByDevice() {


        //
        try {



            $transactions = Transactions::selectRaw('COUNT(*) as count, device_name')
                ->groupBy('device_name')
                ->get();

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to retrieve transactions stats',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully retrieved transactions!',
                'status' => true,
                'transactions' => $transactions
            ],
            200);
    }


    public function merchantTransactions($id) {
        try {

            $transactions = Transactions::where('merchant_id', $id)->get();

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to retrieve transactions',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                404);

        }

        return response()->json(
            [
                'message' => 'Successfully retrieved transactions!',
                'status' => true,
                'transactions' => $transactions
            ],
            200);
    }


    public function newTransaction(Request $request) {

        $transaction = new Transactions();

        try {

            $this->validate($request, [
                'user_id' => 'required',
                'merchant_id' => 'required',
                'device_imei' => 'required',
                'device_name' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'amount' => 'required',
                'device_os' => 'required'
            ]);

            //get the user account id

            $merchant = User::find($request->merchant_id)->merchant()->first();
            if($merchant) {

                $userAccount = User::find($request->user_id)->userAccount()->first();

                $time = Carbon::now();

                $transaction->user_account_id = $userAccount->id;
                $transaction->merchant_id = $merchant->id;
                $transaction->device_imei = $request->device_imei;
                $transaction->device_name = $request->device_name;
                $transaction->device_os = $request->device_os;
                $transaction->lat = $request->lat;
                $transaction->long = $request->long;
                $transaction->amount = $request->amount;
                $transaction->start_time = $time;
                $transaction->status = 0;
                $transaction->response_message = '';
                $transaction->response_status = '';
                $transaction->transaction_identifier = '';


                if ($transaction->save()) {
                    $themessage = "You M-Ponte account has been used to authorize payment of" . " TZS " . $request->amount . " to " . $merchant->name . " at " . $time;

                    // app('App\Http\Controllers\TemporaryNotifyController')->sendNotification($userAccount->phone, $themessage);
                }
            } else {
                return response()->json(
                    [
                        'message' => 'Failed to initiate transaction',
                        'status' => false,
                        'error' => 'Merchant Unauthorized'
                    ],
                    401);
            }
//

        } catch (\Exception $exception) {

            return response()->json(
                [
                    'message' => 'Failed to initiate transaction',
                    'status' => false,
                    'error' => $exception->getMessage()
                ],
                500);

        }

        return response()->json(
            [
                'message' => 'Successfully initiated transaction!',
                'status' => true,
                'transaction' => $transaction
            ],
            200);
    }
}
