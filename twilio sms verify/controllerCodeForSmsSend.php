<?php
/**
 * Created by PhpStorm.
 * User: bytelab
 * Date: 11/21/18
 * Time: 12:53 PM
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use App\Model\SmsVerification;

class SmsController extends Controller
{
    protected $code, $smsVerification;

    function __construct()
    {
        $this->smsVerification = new SmsVerification();
    }

    public function store(Request $request)
    {
        $response = [];
        $status = 200;
        try {
            $code = rand(1000, 9999); //generate random code
            $request['code'] = $code;
            $sendSms = $this->sendSms($request);
            if ($sendSms) {
                $request['api_token'] = $sendSms;
                if (SmsVerification::where([["contact_number", $request->contact_number], ['role', 5]])->count()) {
                    SmsVerification::where('contact_number', $request->contact_number)->update([
                        'code' => $code,
                        'api_token' => $request['api_token']
                    ]);
                } else {
                    $this->smsVerification->store($request);
                }
                $response["success"] = "true";
                $status = 201;
            } else {
                $response["success"] = "false";
                $status = 400;
            }

        } catch (\Exception $e) {
            $response["success"] = "false";
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function verifyUser(Request $request)
    {
        $response = [];
        $status = 200;
        try {
            $verify = SmsVerification::where('contact_number', '=', $request->contact_number)
                ->latest()
                ->first();

            if ($request->code == $verify->code) {
                SmsVerification::where('contact_number', $request->contact_number)->update([
                    'status' => "verified"
                ]);
                $response["success"] = "true";
                $response["api_token"] = $verify->api_token;
                $status = 200;
            } else {
                $response["success"] = "false";
                $status = 400;
            }
        } catch (\Exception $e) {
            $response["success"] = "false";
            $status = 500;
        }
        return response()->json($response, $status);
    }

    public function sendSms($request)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $number = config('app.twilio')['TWILIO_NUMBER'];
        $client = new Client($accountSid, $authToken);
        $capability = new ClientToken($accountSid, $authToken);
        $token = $capability->generateToken();
        try {
            $result = $client->account->messages->create($request->contact_number,
                array(
                    'From' => $number,
                    'Body' => 'CODE: ' . $request->code
                )
            );
            if ($result) {
                return $token;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
