<?php

use App\Http\Controllers\Admin\UploadFileController;
use App\Models\KeyValue;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Get value for the given key. If no value found for the key
 *  `$default` value will be returned.
 * @param string $key
 * @param string $default
 * @return string value of the given `$key`
 */
function getKeyValue($key, $default = "")
{
    $value = cache()->remember($key, 3600, function () use ($key) {
        return KeyValue::where("key", $key)
            ->first()?->value ?? "";
    });

    return !empty($value) ? $value : $default;
}

/**
 * Set value for the given key in the database and in the cache.
 * @param string $key
 * @param string $value
 * @return bool
 */
function setKeyValue($key, $value) : bool
{
    $key_val = KeyValue::where("key", $key)
        ->first();

    try {
        if ($key_val) {
            $key_val->update(["value" => $value]);
        } else {
            $key_val = KeyValue::create([
                "key" => $key,
                "value" => $value,
            ]);
        }
        return Illuminate\Support\Facades\Cache::put($key, $value, 3600);
    } catch (\Throwable $th) {
        return false;
    }
}

/**
 * Get value for the given array of keys.
 * @param array $keys
 * @return array value of the given `$keys` array
 */
function getKeyValueArray(array $keys)
{
    return KeyValue::select("key", "value")
        ->whereIn("key", $keys)
        ->get()
        ->mapWithKeys(function ($item, $key) {
            return [$item['key'] => $item['value']];
        });
}

/**
 * Store key-value set
 * @param array $keys
 * @param bool $isKeyVal
 * @param array $format Patterns that will be replaced with tags. Tags -
 *      $format = [
 *          "[br]" => "<br/>"
 *      ]
 * @return bool
 */
function setKeyValueArray($keys, $isKeyVal = false, $format = [])
{
    $format_string = array_keys($format);
    $format_with = array_values($format);

    try {
        DB::beginTransaction();

        /**
         * @note Since `$field_rules` might be passed in this array,
         *      `request()->get()` will be a better option here.
         * */
        foreach ($keys as $key => $value) {
            $value = $isKeyVal ? $keys[$key] : request()->get($key, "");
            $value = count($format) ? str_replace($format_string, $format_with, $value) : $value;
            setKeyValue($key, $value);
        }

        DB::commit();

        return true;

    } catch (\Throwable $th) {
        DB::rollBack();
        return false;
    }
}

/**
 * Upload images by the provided `$keys` array and return the uploaded image location
 * @param array $keys
 * @return array list of location where the image is uploaded
 */
function uploadMedia($field_name)
{
    $upload = new UploadFileController();
    $uploaded_location = "";

    if (!empty(request()->file($field_name))) {
        $uploaded_location = $upload->uploadImage(request(), $field_name);
    }

    return $uploaded_location;
}

/**
 * Upload image and returns uploaded file location in the given array in the given key
 * @param string $request_name Name of the field in the request
 * @param string $save_name Name of the array key in which to save the uploaded location
 * @param array $save_arr Array in which to save the data
 * @return array Returns the `$save_arr` with filled data
 */
function uploadMediaInArray($request_name, $save_name, $save_arr)
{
    $upload = new UploadFileController();
    $uploaded_location = "";

    if (!empty(request()->file($request_name))) {
        $uploaded_location = $upload->uploadImage(request(), $request_name);
    }

    if (!$uploaded_location) return $save_arr;

    $save_arr[$save_name] = $uploaded_location;

    return $save_arr;
}

function uploadFileInDirectory(UploadedFile $uploadedFile, String $directory)
{
    return $uploadedFile->storePublicly($directory, 'public');
}

function uploaded_asset($location)
{
    return asset("@main/storage/app/public/{$location}");
}