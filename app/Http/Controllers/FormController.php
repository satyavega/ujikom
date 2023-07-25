<?php

namespace App\Http\Controllers;

use App\Models\Form;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    // ...

    /**
     * store
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validasi form
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
            'title' => 'required|min:5',
            'desc'  => 'required|min:10',
            'time'  => 'required|min:1',
            'genre' => 'required|min:1'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/upload', $image->hashName());

        //create form
        Form::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'desc'  => $request->desc,
            'time'  => $request->time,
            'genre' => $request->genre
        ]);

        //redirect to index
        return redirect()->route('admin.dashboard')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function dashboard(): View
{
    //get forms
    $forms = Form::latest()->paginate(5);

    //render view with forms
    return view('admin.index', compact('forms'));
}
/**

* edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get post by ID
        $form = Form::findOrFail($id);

        //render view with post
        return view('admin.edit', compact('form'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'title'     => 'required|min:5',
            'desc'  => 'required|min:10',
            'time'  => 'required|min:1',
            'genre' => 'required|min:1'

        ]);

        //get post by ID
        $forms = Form::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$post->image);

            //update post with new image
            $forms->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'desc'  => $request->desc,
                'time'  => $request->time,
                'genre' => $request->genre
            ]);

        } else {

            //update post without image
            $forms->update([
                'title'     => $request->title,
                'desc'  => $request->desc,
                'time'  => $request->time,
                'genre' => $request->genre
            ]);
        }

        //redirect to index
        return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $forms = Form::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $forms->image);

        //delete post
        $forms->delete();

        //redirect to index
        return redirect()->route('admin.dashboard')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}

