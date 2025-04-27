<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function store(RegisterRequest $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email, 
                'contact_number' => $request->contact_number,
                'postcode' => $request->postcode,
                'password' => Hash::make($request->password),
                'gender_id' => $request->gender_id,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
            ]);

            $user->roles()->attach($request->roles);

            if ($request->has('hobbies')) {
                $user->hobbies()->attach($request->hobbies);
            }

            if ($request->hasFile('file_path')) {
                foreach ($request->file('file_path') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('uploads/user_profiles');
                    $file->move($destinationPath, $filename);
                    UserFile::create([
                        'user_id' => $user->id,
                        'file_path' => $filename,   
                    ]);
                }
            }

            event(new UserRegistered($user));
            
            DB::commit();
            $message = 'User created successfully';
            return response()->json($this->json_response(true, $message), 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
        public function json_response(
            $flag = false,
            $message = 'Someting went wrong',
            $data = []
        ) {
            $response['FLAG'] = $flag;
            $response['MESSAGE'] = $message;
            $response['DATA'] = $data;
    
            return $response;
        }
    
    
}
