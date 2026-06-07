<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalPosts'       => Post::count(),
            'publishedPosts'   => Post::where('status', 'published')->count(),
            'totalSubscribers' => Subscriber::where('status', 'confirmed')->count(),
            'totalCategories'  => Category::count(),
            'totalTags'        => Tag::count(),
            'latestPosts'      => Post::with('category')->latest()->limit(5)->get(),
        ]);
    }
}
