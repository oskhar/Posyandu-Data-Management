<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
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

        $admin = AdminModel::select(
            'admin.id',
            'jabatan.nama as nama_jabatan',
            'admin.foto_profile',
            'admin.nama_lengkap',
            'admin.id_jabatan'
        )
            ->join('jabatan', 'jabatan.id', 'admin.id_jabatan')
            ->where('email_admin', $data['email_admin'])
            ->first();

        /**
         * Kembalikan response yang sesuai
         *
         */
        return response()->json([
            'success' => [
                'message' => 'Berhasil login'
            ],
            'id_admin' => $admin->id,
            'id_jabatan' => $admin->id_jabatan,
            'foto_profile' => $admin->foto_profile,
            'nama_lengkap' => $admin->nama_lengkap,
            'jabatan' => $admin->nama_jabatan,
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
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan data apakah
         * data merupakan data yang valid
         *
         */
        $data = $request->validated();

        /**
         * Mengambil level dari user saat ini
         * user yang telah terauthentikasi
         *
         */
        $level_jabatan = AdminModel::select('jabatan.level')
            ->where('admin.id', Auth::user()->id)
            ->join('jabatan', 'admin.id_jabatan', 'jabatan.id')
            ->value('level');

        /**
         * Memeriksa apakah dia diijikan dengan jabatannya
         *
         */
        if ($level_jabatan > 3) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Anda tidak memiliki wewenang yang sah!'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Memeriksa apakah kedua password
         * baru adalah password yang sama
         *
         */
        if ($data['new_password'] != $data['confirm_password']) {
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
        if (strlen($data['new_password']) < 6) {
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
        AdminModel::where('id', $data['id_admin'])
            ->update([
                'password' => Hash::make($data['new_password'])
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
