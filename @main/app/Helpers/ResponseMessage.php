<?php

namespace App\Helpers;

class ResponseMessage
{
    /** =======================================================================
    *      Create messages
    * ======================================================================= */
    public static function createSucceed($item)
    {
        $message = $item . " " . __("created successfully");
        return ["status" => "success", "message" => $message];
    }

    public static function createFailed($item)
    {
        $message = $item . " " . __("create failed");
        return ["status" => "error", "message" => $message];
    }

    /** =======================================================================
    *      Update messages
    * ======================================================================= */
    public static function updateSucceed($item)
    {
        $message = $item . " " . __("updated successfully");
        return ["status" => "success", "message" => $message];
    }

    public static function updateFailed($item)
    {
        $message = $item . " " . __("update failed");
        return ["status" => "error", "message" => $message];
    }

    /** =======================================================================
    *      Delete messages
    * ======================================================================= */
    public static function deleteSucceed($item)
    {
        $message = $item . " " . __("deleted successfully");
        return ["status" => "success", "message" => $message];
    }

    public static function deleteFailed($item)
    {
        $message = $item . " " . __("delete failed");
        return ["status" => "error", "message" => $message];
    }

    /** =======================================================================
    *      Custom messages
    * ======================================================================= */
    public static function customSuccess($message)
    {
        return ["status" => "success", "message" => $message];
    }

    public static function customFail($message)
    {
        return ["status" => "error", "message" => $message];
    }
}
