<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function index() {
        return view('posts');
    }

    /**
     * Get a listing of the resource.
     */
    public function browse(Request $request)
    {
        // Get pagination parameters
        $perPage = $request->input('size', 12);
        $currentPage = $request->input('page', 1);
        $searchTerm = $request->input('search'); // Search term if provided
        $cacheKey = 'posts_page_' . $currentPage . '_size_' . $perPage;
        $hourInSeconds = 60 * 60;

        $getPosts = function ($searchTerm = null) use ($perPage, $currentPage) {
            $query = Post::query();

            if ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            }

            return $query->paginate(perPage: $perPage, page: $currentPage);
        };

        $paginatedPosts = $searchTerm ? $getPosts($searchTerm) : Cache::remember($cacheKey, $hourInSeconds, $getPosts);

        return PostResource::collection($paginatedPosts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $posts)
    {
        //
    }
}
