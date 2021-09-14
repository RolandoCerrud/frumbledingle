<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\Category;
use App\Models\Location;
use App\Models\Item;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $price = $request->input('price');

        $data = DB::table('items AS i')
            ->join('locations AS l', 'l.id', 'i.location_id')
            ->join('categories AS c', 'c.id', 'i.category_id')
            ->leftJoin('categories AS cp', 'c.parent_id', 'cp.id')
            ->selectRaw('l.name as location, c.name as category, cp.name as parent, count(i.id) as count')
            ->groupBy('l.name', 'c.name', 'cp.name', 'i.category_id');
        
        if (!empty($price)) {
            $data = $data->where('i.price', '=', $price);
        }
        return response()->json($data->get());
    }
}