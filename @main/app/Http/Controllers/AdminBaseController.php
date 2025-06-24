<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Helpers\ResponseMessage;

class AdminBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return ResponseMessage
     */
    public function saveItems($field_rules = [], $image_fields = [], $format = [])
    {
        try {
            DB::beginTransaction();
            if (is_array($image_fields) || is_iterable($image_fields)) 
            {
                foreach ($image_fields as $key) 
                {
                    $upload_location = uploadMedia($key);
                    // remove uploaded image from the normal input array
                    unset($field_rules[$key]);
                    if ($upload_location) {
                        setKeyValue($key, $upload_location);
                    }
                }
            }

            // save input
            $saved = setKeyValueArray($field_rules, false, $format);
            DB::commit();
            return back()->with(ResponseMessage::customSuccess(__("Settings save success")));
        } 
        catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(ResponseMessage::customFail(__("Attempt to save settings is failed")));
        }
    }
}
