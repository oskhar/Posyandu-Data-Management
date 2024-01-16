<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\AdminModel;
use App\Models\JabatanModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function get(AdminRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan kesesuaian data
         * apakah data yang dikirim sesuai
         * dengan ketentuan yang berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query dasar untuk dijadikan
         * tumpuan dalam pengambilan data
         * 
         */
        $query = AdminModel::select(
            'id as id_admin',
            'nama_lengkap',
            'email_admin',
            'id_jabatan',
            'foto_profile',
            'jenis_kelamin',
            'alamat',
            'tanggal_lahir',
            'no_telp',
            'email_verified_at'
        );

        if (!empty($data['id_admin'])) {

            /**
             * Mengambil data dari query
             * 
             */
            $admin = $query
                ->where('id', $data['id_admin'])
                ->first();

            /**
             * Mengembalikan nilai yang diminta
             * sesuai request yang diberikan
             * 
             */
            return response()->json(
                $admin
            )->setStatusCode(200);

        }

        /**
         * Melakukan filtering atau penyaringan
         * data pada kondisi tertentu
         * 
         */
        if (!empty($data['search'])) {

            /**
             * Memfilter data sesuai request search
             * 
             */
            $query = $query->where('nama_lengkap', 'LIKE', '%' . $data['search'] . '%');

        }

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();

        /**
         * Memeriksa apakah data ingin difilter
         * 
         */
        if (isset($data['start']) && isset($data['length'])) {
            $query = $query->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);
        }

        /**
         * Mengambil data dari query
         * 
         */
        $admin = $query->get();

        /**
         * Menyesuaikan data
         * 
         */
        $admin = $admin->map(function ($result) {

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $result->tanggal = explode(' ', $result->tanggal)[0];
            return $result;

        });

        /**
         * Mengembalikan nilai yang diminta
         * sesuai request yang diberikan
         * 
         */
        return response()->json([
            "jumlah_data" => $count,
            "admin" => $admin
        ])->setStatusCode(200);
    }

    public function post(AdminRequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * apakah data sesuai ketentuan
         * 
         */
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        /**
         * Melakukan penambahan data
         * 
         */
        AdminModel::create($data);

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data admin berhasil ditambahkan'
            ]
        ])->setStatusCode(201);
    }

    public function put(AdminRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah data request
         * sesuai dengan ketentuan
         * 
         */
        $data = $request->validated();

        /**
         * Mengambil data yang ingin diubah
         * sesuai dengan id yang diberikan
         * 
         */
        $admin = AdminModel::where('id', $data['id_admin'])->first();
        unset($data['id_admin']);

        /**
         * Memeriksa apakah data password ada
         * 
         */
        if (!empty($data['password'])) {

            /**
             * Memeriksa apakah password lama sesuai
             * dengan password yang ada di database
             * 
             */
            if (!Hash::check($data['password']['lama'], $admin->password)) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Anda memasukan password yang salah'
                    ]
                ])->setStatusCode(400));
            }

            /**
             * Memeriksa apakah kedua password
             * baru adalah password yang sama
             * 
             */
            if ($data['password']['baru_a'] != $data['password']['baru_b']) {
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
            if (strlen($data['password']['baru_a']) < 6) {
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
            $data['password'] = Hash::make($data['password']['baru_a']);

        }

        /**
         * Memeriksa apakah data foto_profile ada
         * 
         */
        if (!empty($data['foto_profile'])) {

            /**
             * 'upload' adalah subfolder tempat foto_profile akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['foto_profile']);
            $base64Image = end($base64Parts);

            $decodedImage = base64_decode($base64Image);

            /**
             * Membuat instance Intervention Image
             * 
             */
            $img = Image::make($decodedImage);

            /**
             * Tentukan ekstensi yang diinginkan
             * (jpg, jpeg, atau png)
             * 
             */
            $extension = 'jpg';

            /**
             * Mengidentifikasi tipe MIME foto_profile
             * 
             */
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            /**
             * Jika tipe MIME adalah foto_profile JPEG, 
             * maka set ekstensi menjadi 'jpg'
             * 
             */
            if ($mime === 'image/jpeg') {
                $extension = 'jpeg';
            }

            /**
             * Jika tipe MIME adalah foto_profile PNG,
             * maka set ekstensi menjadi 'png'
             * 
             */
            if ($mime === 'image/png') {
                $extension = 'png';
            }

            $namaFile = $admin->id_admin . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan foto_profile ke folder
             * 
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['foto_profile'] = '/' . $path;
        }

        /**
         * Memeriksa apakah jabatan ada
         * 
         */
        if (!empty($data['id_jabatan'])) {

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

        }

        /**
         * Melakukan update data
         * sesuai request
         * 
         */
        $admin->update($data);

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data admin berhasil diubah'
            ]
        ])->setStatusCode(201);
    }

    public function delete(AdminRequest $request): JsonResponse
    {
        /**
         * Melakukan validasi apakah data
         * request yang diberikan sesuai
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
         * Mengambil data admin sesuai id
         * 
         */
        $admin = AdminModel::where('id', $data['id_admin'])->first();

        /**
         * Melakukan delete data
         * 
         */
        $admin->delete();

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data admin berhasil dihapus'
            ]
        ])->setStatusCode(200);
    }
    public function jabatan(): JsonResponse
    {
        /**
         * Mendapatkan id jabatan dan nama jabatan
         * untuk dijadikan pilihan dalam VSelect
         * 
         */
        $jabatan = JabatanModel::select(
            'id as value',
            'nama as title',
        )->get();

        /**
         * Mengembalikan response yang sesuai
         * 
         */
        return response()->json(
            $jabatan
        )->setStatusCode(200);
    }
    public function strukturAdmin(): JsonResponse
    {
        /**
         * mendapatkan level jabatan yang tersedia
         * 
         */
        $listLevel = JabatanModel::select('level')
            ->orderBy('level')
            ->distinct()
            ->pluck('level')
            ->toArray();

        /**
         * Mendekalarsikan data struktur untuk
         * dijadikan wadah penyimpanan utama
         * 
         */
        $struktur = array();

        /**
         * Melakukan perulangan sebanyak
         * tingkat level yang tersedia
         * 
         */
        for ($i = 0; $i < count($listLevel); $i++) {

            /**
             * Mendapatkan data admin
             * 
             */
            $struktur[$i] = AdminModel::select(
                'admin.foto_profile',
                'admin.nama_lengkap',
                'admin.email_admin',
                'jabatan.nama as nama_jabatan',
            )
                ->join('jabatan', 'jabatan.id', 'admin.id_jabatan')
                ->where('jabatan.level', $listLevel[$i])
                ->get();

        }

        /**
         * Mengembalikan response yang sesuai
         * 
         */
        return response()->json(
            $struktur
        )->setStatusCode(200);
    }
}
