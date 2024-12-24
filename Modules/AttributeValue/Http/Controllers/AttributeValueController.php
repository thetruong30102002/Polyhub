<?php

namespace Modules\AttributeValue\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\AttributeValue\Entities\AttributeValue;
use Modules\Attribute\Entities\Attribute;
use Modules\Movie\Entities\Movie;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // return view('attributevalue::index');
        $listvalue = AttributeValue::query()->orderByDesc('created_at');
        $page = $listvalue->paginate(4);
        $listattr = Attribute::all();
        $title = ' Attribute';
        $title2 = 'List Attribute';
        $movie = Movie::all();
        return view('attributevalue::index', compact('listvalue', 'listattr', 'title', 'title2', 'movie', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // return view('attributevalue::create');
        $listattr = Attribute::all();
        $title = ' Attribute';
        $title2 = 'Add new Attribute';
        $movie = Movie::all();
        return view('attributevalue::create', compact('listattr', 'title', 'title2', 'movie'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'attribute_id' => 'required',
            'value' => 'required'
        ]);



        if ($request->hasFile('value')) {
            $request->validate([
                'value' => 'mimes:jpg,png,jpeg,gif,mp4'
            ]);


            $valueData = $request->except('value');
            $pathFile = Storage::putFile('attributevalue', $request->file('value'));
            $valueData['value'] = 'storage/' . $pathFile;
            AttributeValue::query()->create($valueData);

            return redirect('/admin/attributevalue')->with('success', 'Add Attribute Successfully!');
        } else {
            $request->validate([
                'value' => 'required'
            ]);
            $valueData = $request->all();
            AttributeValue::query()->create($valueData);

            return redirect('/admin/attributevalue')->with('success', 'Add Attribute Successfully!');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('attributevalue::show');
        $value = AttributeValue::find($id);
        // $value = AttributeValue::;

        $title = ' Attribute';
        $title2 = 'Edit Attribute';
        $movie = Movie::all();
        $listattr = Attribute::all();
        return view('attributevalue::show', compact('value', 'listattr', 'title', 'title2', 'movie'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // return view('attributevalue::edit');
        $attrV = AttributeValue::find($id);
        $title = ' Attribute';
        $title2 = 'Edit Attribute';
        $movie = Movie::all();
        $listattr = Attribute::all();
        return view('attributevalue::edit', compact('attrV', 'listattr', 'title', 'title2', 'movie'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
        $attrV = AttributeValue::find($id);
        $currentImage = $attrV->value;
        $request->validate([
            'attribute_id' => 'required',

        ]);
        $valueData = $request->except('value');

        if ($request->hasFile('value')) {
            $request->validate([
                'value' => 'mimes:jpg,png,jpeg,gif,mp4'
            ]);
            $pathFile = Storage::putFile('attributevalue', $request->file('value'));
            $valueData['value'] = 'storage/' . $pathFile;

            $attrV->update($valueData);

            if (
                $request->hasFile('value')
                && $currentImage
                && file_exists(public_path($currentImage))
            ) {
                unlink(public_path($currentImage));
            }
        } else {
            // No new file uploaded, check if it's text or keep the old image
            if ($request->input('value')) {
                $request->validate([
                    'value' => 'required'
                ]);
                // If the value is provided as text, update it
                $valueData['value'] = $request->input('value');
                $attrV->update($valueData);
            } else {
                // No new image or text provided, retain the current image or text
                $valueData['value'] = $currentImage;
                $attrV->update($valueData);
            }

            // Update the record with the data

        }

        return redirect('/admin/attributevalue')->with('success', 'Actor Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        $AttributeValue = AttributeValue::find($id);
        $AttributeValue->delete();
        return redirect(route('attributevalue.list'));
    }
    public function search(Request $request)
    {
        $text = $request->text;
        $attributevalue = AttributeValue::where('value', 'like', '%' . $text . '%');
        $listattr = Attribute::all();
        $title = 'Actor';
        $title2 = 'List Actor';
        $movie = Movie::all();
        $page = $attributevalue->paginate(4);
        return view('attributevalue::search', compact('title', 'title2', 'actor', 'movie', 'listattr'));
    }
    public function bin()
    {
        $listvalue = AttributeValue::onlyTrashed();
        $page = $listvalue->paginate(4);
        $listattr = Attribute::all();
        $title = ' Attribute';
        $title2 = 'List Attribute';
        $movie = Movie::all();
        return view('attributevalue::bin', compact('listvalue', 'listattr', 'title', 'title2', 'movie', 'page'));
    }
    public function restore($id)
    {
        Attribute::onlyTrashed()->where('id', '=', $id)->restore();
        return redirect(route('attribute.list'));
    }
}
