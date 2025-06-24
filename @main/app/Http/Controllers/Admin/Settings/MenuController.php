<?php

namespace App\Http\Controllers\Admin\Settings;
use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:menu-list', ['only' => ['index','show']]);
        $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = array();
        $menusList = array();
        $menusraw = Menu::orderBy('category', 'ASC')
            ->get();

        $parentMenus = Menu::orderBy('category', 'ASC')
            ->where("parent_id", 0)
            ->get();

        foreach($menusraw as $key => $menu) 
        {   
            if( !in_array($menu->category, $menusList) )
            {
                array_push($menusList, $menu->category);
            }
            $menus[$menu->category][] = $menu;
        }
        return view("dashboard.settings.menu.all", compact("menus", "menusList", "parentMenus"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "category" => "required|string",
            "icon" => "nullable|string",
            "title" => "required|string",
            "url" => "required|string",
        ]);

        $menu = Menu::create([
            "parent_id" => !empty($request->parent_id) ?  $request->parent_id : 0,
            "category" => $request->category,
            "icon" => $request->icon,
            "title" => $request->title,
            "url" => $request->url,
        ]);

        if ($menu) {
            return redirect()->back()->with(ResponseMessage::createSucceed(__("Menu")));
        }
        return redirect()->back()->with(ResponseMessage::createFailed(__("Menu")));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            "category" => "required|string",
            "icon" => "nullable|string",
            "title" => "required|string",
            "url" => "required|string",
        ]);

        $updateData = [
            "parent_id" => !empty($request->parent_id) ?  $request->parent_id : 0,
            "category" => $request->category,
            "icon" => $request->icon,
            "title" => $request->title,
            "url" => $request->url,
        ];

        $updated = $menu->update($updateData);

        if ($updated) {
            return redirect()->back()->with(ResponseMessage::updateSucceed(__("Menu")));
        }
        return redirect()->back()->with(ResponseMessage::updateFailed(__("Menu")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if ($menu->delete()) {
            return response()->json(ResponseMessage::deleteSucceed(__("Menu")));
        }
        return response()->json(ResponseMessage::deleteFailed(__("Menu")));
    }
}
