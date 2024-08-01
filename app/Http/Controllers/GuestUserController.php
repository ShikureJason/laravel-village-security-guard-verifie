<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\GuestUser;
use App\Models\VehicleLog;

class GuestUserController extends Controller
{
    public function Create(Request $request)
    {
        try{
            $credentials = $request->validate([
                'vehicle_brands_id' => ['required', 'string'],
                'place_number' => ['required', 'string'],
                'user_id' => ['required', 'string'],
            ]);

            $home_user_id = $credentials['user_id'];
            //unset($credentials['user_id']);

            //check

            $data = GuestUser::updateOrCreate($credentials);

            if($data){
                GuestUserController::Checkin($data->id, $home_user_id);
            }
            return response()->json(['message' => 'Create Fail'], 200);
        }catch (Exception $e){
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    public function Checkin($id, $home_user_id)
    {
        $data = VehicleLog::create([
            'guest_id' => $id,
            'check_in' => Carbon::now(),
            'user_id' => $home_user_id,
        ]);

        if($data){
            return response()->json(['message' => 'Create Sucess'], 201);
        }
        return response()->json(['message' => 'Create Fail'], 200);
    }

    public static function CheckOut($id)
    {
        $data = VehicleLog::find($id);

        if ($data) {
            $data->update(['check_out' => Carbon::now()]);
        }

    }
}
