<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\WorkSample;
use App\Models\WorkSampleCategory;
use Illuminate\Http\Request;

class AdminWorkSample extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $samples = WorkSample::all();
        return view("admin.work_samples.index", compact("samples"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category = WorkSampleCategory::find($id);
        return view("admin.work_samples.create", compact("category"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sample = new WorkSample();
        if ($request->link !== null) {
            $sample->link = $request->link;
        }
        if ($request->text !== null) {
            $sample->text = $request->text;
        }
        $sample->title = $request->title;
        $sample->category_id = $request->category_id;
        $sample->save();

        // making image in image table
        $image = new Image();
        $image->name = $request->img_name;
        $image->alt = $request->alt;
        $image->uploader_id = auth()->user()->id;
        $imagename = time() . "." . $request->path->extension();
        $request->path->move(public_path("images/work_samples/"), $imagename);
        $image->path = "images/work_samples/" . $imagename;
        $sample->image()->save($image);
        return redirect()->route("admin.work_samples.category.show", $request->category_id)->with("success", "نمونه کار جدید با موفقیت اضافه شد");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("admin.work_samples.edit");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
