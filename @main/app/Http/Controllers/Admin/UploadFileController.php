<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blog-list', ['only' => ['index','show']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Upload multiple files
     *
     * @param string $type One of the following - `image` | `file` | `video`
     * @param string|array $paths
     * @return array An array of uploaded file paths
     */
    public function uploadMultiple($type, $request, $field_name)
    {
        $folder = "";
        $validation = "";

        // set folder and validation rule
        switch ($type) {
            case 'image':
                $folder = "upload.directories.course_image";
                $validation = "upload.restrictions.image";
                break;

            case 'file':
                $folder = "upload.directories.course_file";
                $validation = "upload.restrictions.file";
                break;

            case 'video':
                $folder = "upload.directories.course_video";
                $validation = "upload.restrictions.video";
                break;

            default:
                # if file type is none of these, consider as file
                $folder = "upload.directories.course_file";
                $validation = "upload.restrictions.file";
                break;
        }

        $folder = config($folder) . $request->user()->id;
        $request->validate([
            "$field_name.*" => config($validation),
        ]);

        $all_file_path = [];
        $files = $request->$field_name;

        if ($files) {
            foreach ($files as $file) {
                $all_file_path[] = $file instanceof UploadedFile ? $this->upload($file, $folder) : "";
            }
        }

        return $all_file_path;
    }

    /**
     * Upload and update file
     *
     * @param Request $request
     * @return file url
     */
    public function uploadImage($request, $field_name, $directory_name = 'course_image')
    {
        $folder = config('upload.directories.course_image') . $request->user()->id;
        $request->validate([
            $field_name => config('upload.restrictions.image'),
        ]);

        return $this->upload($request->file($field_name), $folder);
    }

    /**
     * Upload and update file
     *
     * @param Request $request
     * @return file url
     */
    public function uploadFile(Request $request, $field_name, $directory_name = 'course_image')
    {
        $folder = config('upload.directories.course_file') . $request->user()->id;
        $request->validate([
            $field_name => config('upload.restrictions.file'),
        ]);

        return $this->upload($request->file($field_name), $folder);
    }

    /**
     * Upload and update file
     *
     * @param Request $request
     * @return file url
     */
    public function uploadVideo(Request $request, $field_name, $directory_name = 'course_image')
    {
        $folder = config('upload.directories.course_video') . $request->user()->id;
        $request->validate([
            $field_name => config('upload.restrictions.video'),
        ]);

        return $this->upload($request->file($field_name), $folder);
    }

    /**
     * Uploads a file to the s3 bucket
     *
     * @param UploadedFile $uploadedFile
     * @param String $directory
     * @return string
     */
    private function upload(UploadedFile $uploadedFile, String $directory)
    {
        $filePath = $uploadedFile->storePublicly($directory, 'public');
        $fileUrl = Storage::disk('public')->url($filePath);
        return $filePath;
    }

    /**
     * Delete the file at a given path.
     *
     * @param string|array $paths
     * @return string
     */
    public function delete(array | string $paths)
    {
        return Storage::disk('public')->delete($paths);
    }
}
