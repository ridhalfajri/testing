<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::select('id', 'name')->get();
        echo "<option value=''>-- Select Category --</option>";
        foreach ($categories as $item) {
            if ($request->category_id != null && $request->category_id == $item->id) {
                echo "<option value='" . $item->id . "' selected>" . $item->name . "</option>";
            } else {
                echo "<option value='" . $item->id . "'>" . $item->name . "</option>";
            }
        }
    }
}
