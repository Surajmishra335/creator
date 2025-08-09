<?php

namespace App\Http\Controllers\Creator\Profile;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\YouTubeChannel;
use App\Models\CreatorPlatform;
use App\Models\TwitterChannels;
use App\Models\InstagramChannel;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

use GuzzleHttp\Exception\ClientException;
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
            if ($subscriberCount !== null) {
                YouTubeChannel::updateOrCreate(
                    ['creator_id' => $creator_id],
                    [
                        'profile_url' => $request->profile_url,
                        'subscribers' => $subscriberCount['subscriberCount']
                    ],
                );
            }else{
                return response()->json(['error' => 'somethig went wrong'], 422);
            }
        }

        if ($request->platforms_id == 4) {
            $followerCount = $this->getInstagramFollowers($request->profile_url);
            if ($followerCount !== null) {
                InstagramChannel::updateOrCreate(
                    ['creator_id' => $creator_id],
                    [
                        'profile_url' => $request->profile_url,
                        'followers' => $followerCount
                    ],
                );
            }
        }

        if ($request->platforms_id == 5) {
            $followerCount = $this->getTwitterFollowers($request->profile_url);
            if ($followerCount !== null) {
                TwitterChannels::updateOrCreate(
                    ['creator_id' => $creator_id],
                    [
                        'profile_url' => $request->profile_url,
                        'followers' => $followerCount
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

    public function getTwitterFollowers($profileUrl)
    {

        $pattern = '/twitter\.com\/([a-zA-Z0-9_]+)|x\.com\/([a-zA-Z0-9_]+)/';
        preg_match($pattern, $profileUrl, $matches);

        // Handle both twitter.com and x.com URLs
        $username = $matches[1] ?? $matches[2] ?? null;

        if (!$username) {
            return "0";
        }

        $bearerToken = env('TWITTER_BEARER_TOKEN');

        $client = new Client();

        try {
            $response = $client->get("https://api.twitter.com/2/users/by/username/{$username}", [
                'headers' => [
                    'Authorization' => "Bearer {$bearerToken}",
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'user.fields' => 'public_metrics'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            if (isset($data['data']['public_metrics'])) {

                return  $data['data']['public_metrics']['followers_count'];
            }

            return "0";

        } catch (\Exception $e) {
            Log::error($e);
            return "0";
        }
    }


    public function getFacebookFollowers()
    {
        // Set your App ID and App Secret
        $appId = '987146019975920';
        $appSecret = '64db0d476117522d19a2b0e9c5ccfb77';

        // Set the page ID or username
        $pageId = 'thatsMC';

        // Set the API endpoint and parameters
        $endpoint = "https://graph.facebook.com/v13.0/$pageId?fields=followers&access_token=$appId|$appSecret";

        // Create a new Guzzle client
        $client = new Client();

        try {
            // Make a GET request to the API endpoint
            $response = $client->get($endpoint);

            // Get the response data
            $data = json_decode($response->getBody()->getContents(), true);

            // Get the follower count
            $followerCount = $data['followers']['summary']['total_count'];

            // Return the follower count
            return response()->json(['follower_count' => $followerCount]);
        } catch (ClientException $e) {
            // Catch the exception and return a meaningful error message
            $errorMessage = $e->getResponse()->getBody()->getContents();
            return response()->json(['error' => $errorMessage], 400);
        }
    }

    public function getFollowers(Request $request)
    {
        $url = "https://www.facebook.com/Surajkrmishra/";

       // Validate the URL
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return response()->json(['error' => 'Invalid URL'], 422);
            }

            // Use curl to fetch the page content
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3');
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                return response()->json(['error' => 'cURL error: ' . curl_error($ch)], 500);
            }

            curl_close($ch);

            // Check if the request was successful
            if ($httpCode !== 200) {
                return response()->json(['error' => 'Failed to fetch page content', 'http_code' => $httpCode], 500);
            }

            // Parse the HTML content using DOMDocument
            $dom = new DOMDocument();
            @$dom->loadHTML($response);
            $xpath = new DOMXPath($dom);

            // Assuming the followers count is in an element with the class 'followers-count'
            $followersCount = $xpath->query('.//div[@class="followers-count"]')->item(0)->nodeValue;

            // Return the followers count as JSON
            return response()->json(['followers' => $followersCount]);
    }

    private function extractFacebookIdentifier($url)
    {
        $patterns = [
            '/facebook\.com\/(?:profile\.php\?id=)?(\d+)/', // Profile ID
            '/facebook\.com\/(?:pages\/[^\/]+\/)?(\d+)/', // Page ID
            '/facebook\.com\/([a-zA-Z0-9\.]+)/', // Username
            '/fb\.com\/([a-zA-Z0-9\.]+)/' // Short URL
        ];

        foreach ($patterns as $pattern) {
            preg_match($pattern, $url, $matches);
            if (!empty($matches[1])) {
                return $matches[1];
            }
        }
        return null;
    }


}
