<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\AdminModel;
use App\Models\ResetPasswordModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
        $passwordIsCorrect = Hash::check($request->password, $admin->password);

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
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan data apakah
         * data merupakan data yang valid
         * 
         */
        $data = $request->validated();

        /**
         * Mendapatkan data admin
         * 
         */
        $admin = AdminModel::where('email_admin', $data['email_admin'])->first();

        /**
         * Memeriksa apakah data admin ditemukan
         * 
         */
        if ($admin) {

            /**
             * Melakukan generate token dan link ubah password
             * 
             */
            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain . '/reset-password?token=' . $token;

            /**
             * Mengatur data untuk dikirim melalui pesan email
             * 
             */
            $pesan['url'] = $url;
            $pesan['email'] = $data['email_admin'];
            $pesan['title'] = "Lupa Password Posyandu Melati";
            $pesan['body'] = "Click link di bawah untuk reset password";

            /**
             * Mempersiapkan pesan email yang akan dikirim
             * 
             */
            Mail::send('forget-password', ['data' => $pesan], function ($message) use ($pesan) {
                $message->to($pesan['email'])->subject($pesan['title']);
            });

            /**
             * Mendapatkan tanggal dan waktu sekarang
             * 
             */
            $currentDatetime = Carbon::now()->format("Y-m-d H:i:s");

            /**
             * Melakukan update jika data tersedia
             * dan melakukan create jika tidak
             * 
             */
            ResetPasswordModel::updateOrCreate(
                ['email_admin' => $data['email_admin']],
                [
                    'email_admin' => $data['email_admin'],
                    'token' => $token,
                    'created_at' => $currentDatetime,
                ]
            );

        }

        /**
         * Mengembalikan response yang sesuai
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Telah terkirim, silahkan check email anda!'
            ]
        ])->setStatusCode(200);
    }
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan data apakah
         * data merupakan data yang valid
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah token sudah sesuai
         * 
         */
        $resetData = ResetPasswordModel::where('token', $data['token'])->first();

        if (!$resetData) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Token tidak sah!'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Memeriksa apakah kedua password
         * baru adalah password yang sama
         * 
         */
        if ($data['password_a'] != $data['password_b']) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Password baru harus sama!'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Memeriksa apakah kedua password
         * baru adalah password yang sama
         * 
         */
        if (strlen($data['password_a']) < 6) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Password minimal harus 6 karakter!'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Enkripsi data password
         * 
         */
        AdminModel::where('email_admin', $resetData->email)
            ->update([
                'password' => Hash::make($data['password_a'])
            ]);

        /**
         * Mengembalikan response yang sesuai
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Password berhasil diubah'
            ]
        ])->setStatusCode(200);
    }
}
