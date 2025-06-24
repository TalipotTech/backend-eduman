<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Enums\AuthorCategoryEnum;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route("login");
    }
}
