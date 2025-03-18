<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('index', compact('posts'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'max:2025', 'image'],
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'category_id' => ['required', 'integer']
        ]);



        $fileName = time() . '_' . $request->image->getClientOriginalName();
        $filePath = $request->image->storeAs('uploads', $fileName, 'public');   //I have to use [ php artisan storage:link ] command

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->image = $filePath;   //Adding filepath in database insted of file
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post =  Post::findOrFail($id);
        return view('show', compact('post'));
    }






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post =  Post::findOrFail($id);
        $categories = Category::all();
        return view('edit', compact('post', 'categories'));
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
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'category_id' => ['required', 'integer']
        ]);

        $post = Post::findOrFail($id);

        if ($request->hasFile('image')) {

            $request->validate([
                'image' => ['required', 'max:2025', 'image']
            ]);


            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $filePath = $request->image->storeAs('uploads', $fileName, 'public');


            if ($post->image) {   //Deleting Old Image
                Storage::disk('public')->delete($post->image);
            }

            $post->image = $filePath;
        }



        $post->title = $request->title;
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        $post->save();

        return redirect()->route('posts.index');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index');
    }



    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return view('trashed', compact('posts'));
    }


    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();  //restore Method
        return redirect()->back();
    }



    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        Storage::disk('public')->delete($post->image);
        $post->forceDelete(); //Force Delete Method
        return redirect()->back();
    }
}
