<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verified;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
            $codeVerification = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            Mail::to($user->email)->send(new UserRegistered($user, $codeVerification));
            $user = Verified::create([
                'user_id' => $user->id,
                'status' => 0,
                'code_verif' => $codeVerification,
            ]);
        
            return response()->json(['message' => 'User registered successfully', 'user' => $user], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error registering user', 'error' => $e->getMessage()], 500);
        }
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $verified = Verified::where('user_id', $user->id)
                            ->where('code_verif', $code)
                            ->first();

        if ($verified) {
            $verified->status = 1;
            $verified->save();
            return response()->json(['message' => 'Code verified successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userVerif = User::where('email', $credentials['email'])->first();
        $verifiedUser = Verified::where('user_id', $userVerif->id)
        ->where('status', 1)
        ->first();

        if ($verifiedUser) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                return response()->json(['user' => $user], 200);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } else {
            return response()->json(['message' => 'User is not verified'], 401);
        }
    }

    public function profile(Request $request)
    {
        $request->validate([
            'email' =>'required',
            'titre' => 'required',
            'competance' => 'required',
            'experience' => 'required',
            'cvPdf' => 'required|file|mimes:pdf|max:2048', 
        ]);


        $cvPdfPath = $request->file('cvPdf')->store('cv_pdfs');
        $user = User::where('email', $request->email)->first();
        $profile = Profile::create([
            'user_id'=>$user->id,
            'titre' => $request->titre,
            'competance' => $request->competance,
            'experience' => $request->experience,
            'cvPdf' => $cvPdfPath,
        ]);

        return response()->json(['message' => 'Profil créé avec succès', 'profile' => $profile], 200);
    }
}
