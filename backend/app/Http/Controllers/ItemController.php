<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'       =>  'required|max:100',
            'price'      =>  'required|integer',
            'image_file' =>  'nullable|mimes:jpg,png',
        ]);

        if ($request->file('image_file')) {

            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newFileName = Carbon::now()->timestamp . "_" . $fileName;

            Storage::disk('public')->putFileAs('items', $file, $newFileName);
            $request['image'] = $newFileName;
        }


        $item = Item::create(
            $request->all()
        );
        return response(['data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       =>  'required|max:100',
            'price'      =>  'required|integer',
            'image_file' =>  'nullable|mimes:jpg,png',
        ]);

        if ($request->file('image_file')) {

            $file = $request->file('image_file');
            $fileName = $file->getClientOriginalName();
            $newFileName = Carbon::now()->timestamp . "_" . $fileName;

            Storage::disk('public')->putFileAs('items', $file, $newFileName);
            $request['image'] = $newFileName;
        }

        $item = Item::findOrFail($id);
        $item->update($request->all());

        return response(['data' => $item]);
    }
}
