<?php
namespace App\Services\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{  
    public function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        return $file->store($folder, 'public');
    }

    public function uploadMany(array $files, string $folder = 'uploads'): array
    {
        return collect($files)->map(function ($file) use ($folder) {
            return $file->store($folder, 'public');
        })->toArray();
    }


    //Upload in media tables
    public function storeMedia(
        Model $model,
        UploadedFile $file,
        string $folder,
        string $collection = 'default',
        int $sortOrder = 0
    ) {
        $path = $this->upload($file, $folder);

        return $model->media()->create([
            'file' => $path,

            'disk' => 'public',

            'collection' => $collection,

            'type' => $this->type($file),

            'mime_type' => $file->getMimeType(),

            'sort_order' => $sortOrder,
        ]);
    }

     /**
     * Get public URL for showing file
     */
    public function url(?string $path): ?string
    {
        if (!$path) return null;

        return Storage::disk('public')->url($path);
        // OR: return asset('storage/' . $path);
    }

    /**
     * Get multiple file URLs
     */
    public function urls(?array $paths): array
    {
        if (!$paths) return [];

        return collect($paths)->map(function ($path) {
            return $this->url($path);
        })->toArray();
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function deleteMany(?array $paths): void
    {
        if (!$paths) return;

        Storage::disk('public')->delete($paths);
    }

    public function type(UploadedFile $file): string
    {
        $mimeType = $file->getMimeType();

        return match (true) {

            str_starts_with($mimeType, 'image/') => 'image',

            str_starts_with($mimeType, 'video/') => 'video',

            str_starts_with($mimeType, 'audio/') => 'audio',

            $mimeType === 'application/pdf' => 'pdf',

            default => 'file',
        };
    }
}


//------------------------------------
// How to use example
//------------------------------------
// use App\Services\FileUploadService;
// use Illuminate\Http\Request;

// class ProductController extends Controller
// {
//     public function __construct(
//         protected FileUploadService $fileService
//     ) {}

//     public function store(Request $request)
//     {
//         $request->validate([
//             'name' => 'required',

//             // single file
//             'thumbnail' => 'nullable|image|max:2048',

//             // multiple files
//             'galleries' => 'nullable|array',
//             'galleries.*' => 'image|max:2048',
//         ]);

//         // SINGLE FILE
//         $thumbnail = null;
//         if ($request->hasFile('thumbnail')) {
//             $thumbnail = $this->fileService->upload(
//                 $request->file('thumbnail'),
//                 'products/thumbnails'
//             );
//         }

//         // MULTIPLE FILES
//         $galleries = [];
//         if ($request->hasFile('galleries')) {
//             $galleries = $this->fileService->uploadMany(
//                 $request->file('galleries'),
//                 'products/galleries'
//             );
//         }

//         $product = Product::create([
//             'name' => $request->name,
//             'thumbnail' => $thumbnail,
//             'galleries' => $galleries,
//         ]);

//         return response()->json($product);
//     }
// }