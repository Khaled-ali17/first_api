<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api_Models\Category;
use App\Traits\GeneralTraits;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    use GeneralTraits;

    public function index()
    {
        $categories = Category::get();
        return $this->returnData('all_categories', $categories, 'success');
    }

    public function getCategoryById(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return $this->returnError('', 'This Category Not Found');
        }
        return $this->returnData('Category', $category, 'Success');
    }

    public function changeStatus(Request $request)
    {
        Category::where('id', $request->id)->update(['status_active' => $request->status_active]);
        //Category::where('id', $request->id)->update(['active' => $request->active]);


        return $this->returnSuccessMessage('Active Status Changed');
    }
}