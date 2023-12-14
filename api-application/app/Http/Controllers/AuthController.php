<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\AdminModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan data apakah
         * data merupakan data yang valid
         * 
         */
        $data = $request->validated();

        /**
         * Mengambil data programmer dari tabel
         * berdasarkan email yang diberikan
         * 
         */
        $admin = AdminModel::where('email_admin', $data['email_admin'])
            ->first();

        /**
         * Memeriksa apakah data admin ditemukan
         * 
         */
        if (empty($admin)) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Email atau password salah'
                ]
            ])->setStatusCode(401));
        }

        /**
         * Memeriksa apakah password yang
         * diberikan benar dan sesuai
         * 
         */
        $passwordIsCorrect = Hash::check($data['password'], $admin->password);

        /**
         * Kembalikan unauthorize response jika
         * ada kesalahan pada email dan
         * password yang diberikan maka
         * 
         */
        if (!$passwordIsCorrect) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Email atau password salah'
                ]
            ])->setStatusCode(401));
        }

        /**
         * Membuat token dan mendapatkan
         * token berupa string
         * 
         */
        $token = $admin->createToken('personal_access_tokens', ['server:update'], null)->plainTextToken;

        /**
         * Kembalikan response yang sesuai
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Berhasil login'
            ],
            'id_admin' => $admin->id,
            'foto_profile' => $admin->foto_profile,
            'token' => $token
        ])->setStatusCode(200);
    }

    public function logout(Request $request): JsonResponse
    {
        /**
         * Hapus token dari database
         * 
         */
        Auth::user()->currentAccessToken()->delete();

        /**
         * Kembalikan response yang sesuai
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Berhasil logout'
            ]
        ])->setStatusCode(200);
    }

    public function authData(Request $request)
    {
        /**
         * Hapus token dari database
         * 
         */
        $id_admin = Auth::user()->id;

        /**
         * Kembalikan response yang sesuai
         * 
         */
        return response()->json([
            'id_admin' => $id_admin
        ])->setStatusCode(200);
    }
}
