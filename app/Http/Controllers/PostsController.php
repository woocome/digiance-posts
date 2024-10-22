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

        if ($searchTerm = $request->input('search')) {
            $query = Post::query();
            $query->where('title', 'like', '%' . $searchTerm . '%'); // Search by title

            // Paginate the results (# posts per page)
            $paginatedPosts = $query->paginate(perPage: $perPage, page: $currentPage);
        } else {
            // Check if the posts are cached
            $posts = Cache::get('posts');

             if (!$posts) {
                // If not cached, retrieve from database
                $posts = PostResource::collection(Post::all());
             }

            // Paginate the filtered results
            $currentPageItems = $posts->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $paginatedPosts = new LengthAwarePaginator(
                $currentPageItems,
                $posts->count(),
                $perPage,
                $currentPage
            );
        }

        // Return the paginated posts as a resource collection
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
