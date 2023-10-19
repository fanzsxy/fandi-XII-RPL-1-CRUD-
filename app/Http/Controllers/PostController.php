<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Contracts\view\view;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\support\facades\Storage;

class PostController extends Controller
{
    public function index()
    {
    //get posts
    $posts = Post::latest()->paginate(5);

    //render view whith posts
    return view('posts.index', compact('posts'));
    }

      public function create()
    {
    return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,giv,svg|max:2048',
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());
        //create post
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content
        ]);
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Post $post):view
    {
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, Post $post): RedirectResponse
    {
         $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,giv,svg|max:2048',
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());
            Storage::delete('public/posts/'. $post->image);
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            $post->update([
                'title'  => $request->title,
                'content'=> $request->content
            ]);
        }
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Post $post):RedirectResponse
    {
        Storage::delete('public/posts/'. $post->image);
        $post->delete();
        return redirect()->route('posts.index')->with(['succes' => 'data berhasil di hapus']);
    }
    public function show(string $id):view
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
