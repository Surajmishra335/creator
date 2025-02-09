<?php

namespace App\Http\Controllers\Creator\Profile;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\YouTubeChannel;
use App\Models\CreatorPlatform;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;




class CreatorPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CreatorPlatform::all();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource (for web apps).
     */
    public function create()
    {
        $creator_id = Auth::user()->id;
        $creator_platforms = CreatorPlatform::where('creator_id', $creator_id)->first();
        $existingPlatforms = [];
        if ($creator_platforms) {
            $existingPlatforms = explode(',', $creator_platforms->platforms_ids);
        }

        $social_platforms = DB::table('social_platforms_master')
            ->whereNotIn('id', $existingPlatforms)
            ->get();


        return view('creators.platforms.create', compact('social_platforms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile_url' => 'required|string',
            'platforms_id' => 'required|integer',
        ]);
        
        $creator_id = Auth::user()->id;
        $newPlatformId = $request->platforms_id;
        $data = [
            'creator_id' => Auth::user()->id,
            'platforms_ids' => $request->platforms_id
            // 'profile_url' => $request->profile_url,
            // 'is_active' => True,
        ];

        $creator_platforms = CreatorPlatform::where('creator_id', $creator_id)->first();

        if($creator_platforms != null){
            $existingPlatforms = explode(',', $creator_platforms->platforms_ids);

            // Check if the new platform ID is already stored, if not, add it
            if (!in_array($newPlatformId, $existingPlatforms)) {
                $existingPlatforms[] = $newPlatformId; // Add new ID
                $creator_platforms->platforms_ids = implode(',', $existingPlatforms);
                $creator_platforms->save();
            }

        }else{
            
            CreatorPlatform::create($data);
        }

        if ($request->platforms_id == 3) {
            $subscriberCount = $this->getYouTubeChannelStatistics($request->profile_url);
            log::info($subscriberCount['subscriberCount']);
            if ($subscriberCount !== null) {
                YouTubeChannel::updateOrCreate(
                    ['creator_id' => $creator_id],
                    [
                        'profile_url' => $request->profile_url,
                        'subscribers' => $subscriberCount['subscriberCount']
                    ],
                );
            }
        }

        if ($request->platforms_id == 4) {
            $followe = $this->getYouTubeChannelStatistics($request->profile_url);
            if ($subscriberCount !== null) {
                YouTubeChannel::updateOrCreate(
                    ['creator_id' => $creator_id],
                    [
                        'profile_url' => $request->profile_url,
                        'subscribers' => $subscriberCount['subscriberCount']
                    ],
                );
            }
        }

        return response()->json(['message' => 'Record created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = CreatorPlatform::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource (for web apps).
     */
    public function edit($id)
    {
        $data = CreatorPlatform::findOrFail($id);
        return view('creator_platform.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'creator_id' => 'integer',
            'platforms_id' => 'string',
            'is_active' => 'boolean',
        ]);

        $data = CreatorPlatform::findOrFail($id);
        $data->update($request->all());
        return response()->json(['message' => 'Record updated successfully', 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = CreatorPlatform::findOrFail($id);
        $data->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }

    function getYouTubeChannelStatistics($channelUrl)
    {
        $channelName = $this->extractChannelName($channelUrl);

        if (!$channelName) {
            Log::error("Invalid YouTube URL: " . $channelUrl);
            return null;
        }

        $apiKey = Config::get('services.youtube.api_key');
        $client = new Client();

        try {
            // Fetch Channel ID
            $searchResponse = $client->request('GET', 'https://www.googleapis.com/youtube/v3/search', [
                'query' => [
                    'part'  => 'snippet',
                    'type'  => 'channel',
                    'q'     => $channelName,
                    'key'   => $apiKey,
                ],
            ]);

            $searchData = json_decode($searchResponse->getBody(), true);

            if (!isset($searchData['items'][0]['id']['channelId'])) {
                Log::error("Channel ID not found for: " . $channelName);
                return null;
            }

            $channelId = $searchData['items'][0]['id']['channelId'];

            // Fetch Channel Statistics
            $channelResponse = $client->request('GET', 'https://www.googleapis.com/youtube/v3/channels', [
                'query' => [
                    'part' => 'statistics',
                    'id'   => $channelId,
                    'key'  => $apiKey,
                ],
            ]);

            $channelData = json_decode($channelResponse->getBody(), true);

            if (!isset($channelData['items'][0]['statistics'])) {
                Log::error("Channel statistics not found for: " . $channelId);
                return null;
            }

            return [
                'subscriberCount' => $channelData['items'][0]['statistics']['subscriberCount'],
                'viewCount'       => $channelData['items'][0]['statistics']['viewCount'],
                'videoCount'      => $channelData['items'][0]['statistics']['videoCount'],
            ];
        } catch (\Exception $e) {
            Log::error("YouTube API Error: " . $e->getMessage());
            return null;
        }
    }

    // Helper function to extract channel name from URL
    function extractChannelName($url)
    {
        $parsedUrl = parse_url($url);
        
        if (isset($parsedUrl['path']) && str_starts_with($parsedUrl['path'], '/@')) {
            return ltrim($parsedUrl['path'], '/@');
        }

        return null;
    }

    function test() {
        $username = "surajmishra335";
        $url = "https://www.instagram.com/{$username}/?__a=1&__d=dis";

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
        ])->get($url);

        if ($response->successful()) {
            $data = $response->json();
            return $data['graphql']['user']['edge_followed_by']['count'] ?? 'Not Found';
        }

        return 'Error fetching data';
    }


    public function getInstagramFollowers($url)
    {

        $client = new Client();
        try {
            $response = $client->get($url);
            $html = $response->getBody();

            // Use DomCrawler for more reliable parsing (install: composer require symfony/dom-crawler)
            $crawler = new Crawler($html);

            // Example using a CSS selector (you'll need to inspect the actual Instagram page)
            // This is VERY likely to change!
            $followerCountElement = $crawler->filter('meta[property="og:description"]')->attr('content');
            //Example content: "1,234 Followers, 456 Following, 789 Posts - Username"
            preg_match('/([\d,]+) Followers/', $followerCountElement, $matches);



            if (isset($matches[1])) {
                $followerCount = str_replace(',', '', $matches[1]); // Remove commas
            } else {
                Log::error("Follower count not found.  Inspect Instagram's HTML.");
                $followerCount = "000"; // Handle cases where the pattern isn't found
            }

            
            return $followerCount;

        } catch (\Exception $e) {
            Log::error($e);
            return "000";
        }
    }


}
