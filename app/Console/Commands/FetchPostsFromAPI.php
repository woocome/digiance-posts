<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class FetchPostsFromAPI extends Command
{
    protected $signature = 'app:fetch-posts';
    protected $description = 'Fetch posts from JSONPlaceholder API and store them in the database';

    public function handle()
    {
        // Fetch posts from the external API
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        // Check if the response is successful
        if ($response->successful()) {
            $posts = $response->json();

            foreach ($posts as $postData) {
                $request = new PostRequest();
                $validator = Validator::make($postData, $request->rules());

                if ($validator->fails()) {
                    $this->error($validator->errors());
                    continue;
                }

                // Create or update the post in the database
                Post::updateOrCreate(
                    ['external_post_id' => $postData['id']],
                    [
                        'title' => $postData['title'],
                        'body' => $postData['body'],
                        'user_id' => (int) $postData['userId'],
                    ]
                );
            }

            // Cache the posts for 60 minutes
            Cache::put('posts', PostResource::collection(Post::all()), 60);

            $this->info('Posts fetched and stored successfully.');
        } else {
            $this->error('Failed to fetch posts from the API.');
        }
    }
}