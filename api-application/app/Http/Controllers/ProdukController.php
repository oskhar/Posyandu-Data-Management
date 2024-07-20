<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\ProdukModel;
use App\Models\TagModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function get(ProdukRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = ProdukModel::select(
            "id",
            "nomor_telepon",
            "nama",
            "deskripsi",
            "overview",
            "harga",
            "gambar",
        );

        if (!empty($data["tag"])) {
            $tags = $data["tag"];
            foreach ($tags as $tag) {
                $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('tag', $tag);
                });
            }
        }

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("deskripsi", "like", "%{$data["search"]}%")
                    ->orWhere("nama", "like", "%{$data["search"]}%")
                    ->orWhere("overview", "like", "%{$data["search"]}%");
            });
        }

        if (!empty($data["sort"])) {
            switch ($data["sort"]) {
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'a-z':
                    $query->orderBy('nama', 'asc');
                    break;
                case 'z-a':
                    $query->orderBy('nama', 'desc');
                    break;
                case 'termahal':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'termurah':
                    $query->orderBy('harga', 'asc');
                    break;
            }
        }

        $produk = $query->paginate($data["length"]);

        $tmp_data = $produk->getCollection()->map(function ($item) {

            $item["tag"] = TagModel::select("tag")->join("produk_tag", "produk_tag.tag_id", "tag.id")
                ->where('produk_tag.produk_id', $item->id)
                ->pluck('tag')
                ->toArray();

            return $item;

        });

        $produk = $produk->setCollection($tmp_data);

        return response()->json($produk)->setStatusCode(200);
    }
    public function post(ProdukRequest $request): JsonResponse
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

        if (isset($data['pin']) && $data['pin']) {
            $pinCount = ProdukModel::where('pin', true)->count();
            if ($pinCount > 4) {
                return response()->json([
                    "errors" => [
                        "message" => "Jumlah produk yang dipin tidak boleh lebih dari 5"
                    ]
                ])->setStatusCode(422);
            }
        }

        ProdukModel::create($data);

        return response()->json()->setStatusCode(200);
    }
    public function put(ProdukRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $produk = ProdukModel::findOrFail($id);

        if (!empty($data['gambar']) && $data['gambar'] != $produk->gambar) {
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

        if (isset($data['pin']) && $data['pin'] && !$produk->pin) {
            $pinCount = ProdukModel::where('pin', true)->count();
            if ($pinCount > 4) {
                return response()->json([
                    "errors" => [
                        "message" => "Jumlah produk yang dipin tidak boleh lebih dari 5"
                    ]
                ])->setStatusCode(422);
            }
        }

        $produk->update($data);

        return response()->json()->setStatusCode(200);
    }
    public function delete($id): JsonResponse
    {
        return response()->json()->setStatusCode(200);
    }
    public function pin(): JsonResponse
    {
        ProdukModel::select(
            "id",
            "nomor_telepon",
            "nama",
            "deskripsi",
            "overview",
            "harga",
            "gambar",
        );

        return response()->json()->setStatusCode(200);
    }
}
