<?php

namespace App\Http\Controllers\Api\PageSetting;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\MenusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class MenusController extends Controller
{
    /**
     * @OA\Get(
     *    path="/setting/menu/by-category",
     *    operationId="getMenusByCategory",
     *    tags={"Menu"},
     *    summary="Get list of Menus",
     *    description="Get list of Menus",
     *    @OA\Parameter(name="type", in="query", description="type", example="Header_Home_1", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *       response=200, description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="200"),
     *         @OA\Property(property="data",type="object")
     *       )
     *    )
     *  )
     */
    public function getMenusByCategory(Request $request)
    {
        if( $request->type != null )
        {
            $menusList = array();

            $parentMenus = Menu::where("category", $request->type)
                ->where("parent_id", 0)
                ->orderBy('id', 'ASC')
                ->select("id", "parent_id", "title", "url")
                ->get();

            $childMenus = Menu::where("category", $request->type)
                ->where("parent_id", '!=', 0)
                ->orderBy('id', 'ASC')
                ->select("id", "parent_id", "title", "url")
                ->get();

            foreach($childMenus as $cMenu) 
            {
                $menusList[$cMenu->parent_id][] = $cMenu;
            }

            return response()->json([
                "items" => [
                    "parentMenus" => $parentMenus,
                    "childMenus" => $menusList,
                ],
            ]);
        }
        else 
        {
            return response()->json([
                "success" => false,
            ]);
        }
    }
}
