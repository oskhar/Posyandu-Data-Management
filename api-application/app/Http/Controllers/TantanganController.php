<?php

namespace App\Http\Controllers;

use App\Http\Requests\TantanganRequest;
use App\Models\TantanganModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class TantanganController extends Controller
{
    public function get(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = TantanganModel::select(
            "id",
            "judul",
            "gambar",
            "deskripsi",
            "overview",
            "tanggal_mulai",
            "tanggal_selesai",
            "created_at"
        );

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("judul", "like", "%{$data["search"]}%")
                    ->orWhere("deskripsi", "like", "%{$data["search"]}%");
            });
        }

        $tantangan = $query->paginate($data["length"]);

        return response()->json($tantangan)->setStatusCode(200);
    }

    public function post(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['gambar'])) {
            /**
             * 'upload' adalah subfolder tempat gambar akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['gambar']);
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
             * Mengidentifikasi tipe MIME gambar
             *
             */
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            /**
             * Jika tipe MIME adalah gambar JPEG,
             * maka set ekstensi menjadi 'jpg'
             *
             */
            if ($mime === 'image/jpeg') {
                $extension = 'jpeg';
            }

            /**
             * Jika tipe MIME adalah gambar PNG,
             * maka set ekstensi menjadi 'png'
             *
             */
            if ($mime === 'image/png') {
                $extension = 'png';
            }

            $namaFile = Auth::user()->id . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             *
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar'] = '/' . $path;
        }

        TantanganModel::create($data);

        return response()->json([
            "success" => [
                "message" => "Tantangan berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }

    public function put(TantanganRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $tantangan = TantanganModel::findOrFail($id);

        if (!empty($data['gambar']) && $data['gambar'] != $tantangan->gambar) {
            /**
             * 'upload' adalah subfolder tempat gambar akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['gambar']);
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
             * Mengidentifikasi tipe MIME gambar
             *
             */
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            /**
             * Jika tipe MIME adalah gambar JPEG,
             * maka set ekstensi menjadi 'jpg'
             *
             */
            if ($mime === 'image/jpeg') {
                $extension = 'jpeg';
            }

            /**
             * Jika tipe MIME adalah gambar PNG,
             * maka set ekstensi menjadi 'png'
             *
             */
            if ($mime === 'image/png') {
                $extension = 'png';
            }

            $namaFile = Auth::user()->id . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             *
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar'] = '/' . $path;
        }

        $tantangan->update($data);

        return response()->json([
            "success" => [
                "message" => "Tantangan berhasil diperbarui"
            ]
        ])->setStatusCode(200);
    }

    public function delete($id): JsonResponse
    {
        TantanganModel::findOrFail($id)
            ->delete();
        return response()->json([
            "success" => [
                "message" => "Tantangan telah dihapus!"
            ]
        ])->setStatusCode(200);
    }

    public function user(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = TantanganModel::select(
            "tantangan.id",
            "tantangan.judul",
            "tantangan.gambar",
            "tantangan.deskripsi",
            "tantangan.overview",
            "tantangan.tanggal_mulai",
            "tantangan.tanggal_selesai",
            "tantangan.created_at"
        )->join("submission", "tantangan.id", "submission.tantangan_id")
            ->where("submission.user_id", Auth::user()->id);

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("judul", "like", "%{$data["search"]}%")
                    ->orWhere("deskripsi", "like", "%{$data["search"]}%");
            });
        }

        $tantangan = $query->paginate($data["length"]);

        return response()->json($tantangan)->setStatusCode(200);
    }

    public function getSpesific(Request $request, $id): JsonResponse
    {
        // Query dasar tanpa join
        $query = TantanganModel::select(
            "tantangan.judul",
            "tantangan.gambar",
            "tantangan.deskripsi",
            "tantangan.overview",
            "tantangan.tanggal_mulai",
            "tantangan.tanggal_selesai",
            "tantangan.created_at"
        )->where("tantangan.id", $id);

        // Periksa apakah ada token
        $token = $request->bearerToken();

        if ($token) {
            // Autentikasi pengguna berdasarkan token
            $user = Auth::guard('sanctum')->user();

            if ($user instanceof \App\Models\UserModel) {
                // Tambahkan join dan select tambahan
                $query->leftJoin('submission', function ($join) use ($user) {
                    $join->on('submission.tantangan_id', '=', 'tantangan.id')
                        ->where('submission.user_id', '=', $user->id);
                })->addSelect([
                            'user_submitted' => \DB::raw('(SELECT COUNT(*) FROM submission WHERE submission.tantangan_id = tantangan.id AND submission.user_id = ' . $user->id . ') as user_submitted')
                        ]);
            }
        }

        return response()->json(
            $query->first()
        )->setStatusCode(200);
    }


}
