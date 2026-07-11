<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:posts,slug',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'category_id'  => 'nullable|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'is_featured'  => 'nullable|boolean',
            'reading_time' => 'nullable|integer|min:1|max:999',
            'published_at' => 'nullable|date',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['source']      = 'manual';

        $post = Post::create($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.posts.index')->with('success', 'Post criado com sucesso.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post'       => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
            'postTags'   => $post->tags->pluck('id')->toArray(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'category_id'  => 'nullable|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'is_featured'  => 'nullable|boolean',
            'reading_time' => 'nullable|integer|min:1|max:999',
            'published_at' => 'nullable|date',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');

        $post->update($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.posts.index')->with('success', 'Post atualizado.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post removido.');
    }
}
