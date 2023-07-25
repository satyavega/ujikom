<?php

namespace App\Http\Controllers;

//import Model "Post
use App\Models\Post;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function dashboard(): View
    {
        //get posts
        $posts = Post::latest()->paginate(5);

        //render view with posts
        return view('admin.index', compact('posts'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
            'title' => 'required|min:5',
            'desc'  => 'required|min:10',
            'time'  => 'required|min:1',
            'genre' => 'required|min:1'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts/', $image->hashName());

        //create post
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'desc'  => $request->desc,
            'time'  => $request->time,
            'genre' => $request->genre
        ]);

        //redirect to index
        return redirect()->route('admin.dashboard')->with(['success' => 'Data Berhasil Disimpan!']);
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
        $post = Post::findOrFail($id);
        //render view with post
        return view('admin.body.edit', compact('post'));
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
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:5',
            'desc'  => 'required|min:10',
            'time'  => 'required|min:1',
            'genre' => 'required|min:1'
        ]);

        //get post by ID
        $post = Post::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            //delete old image
            Storage::delete('public/posts/'.$post->image);

            //update post with new image
            $post->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'desc'  => $request->desc,
                'time'  => $request->time,
                'genre' => $request->genre
            ]);

        } else {

            //update post without image
            $post->update([
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
        $post = Post::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $post->image);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('admin.dashboard')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
