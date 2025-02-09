<?php

namespace App\Http\Controllers\Creator\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CreatorPlatform;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\YouTubeChannel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Show the profile page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $platforms = CreatorPlatform::where('creator_id', Auth::user()->id)->first();

        $yt_subscriber = YouTubeChannel::where('creator_id', Auth::user()->id)
        ->select('creator_id', 'subscribers')
        ->first();
    
        $yt_subscriber = $yt_subscriber ? [$yt_subscriber->creator_id => $yt_subscriber->subscribers] : [];
    
        if($platforms){
            $existingPlatforms = explode(',', $platforms->platforms_ids);
            $social_platforms = DB::table('social_platforms_master')
            ->whereIn('id', $existingPlatforms)
            ->get();
        }

        return view('creators.profile', compact('social_platforms', 'yt_subscriber'));
    }


    public function update(Request $request)
    {
        
        $userId = Auth::id();
        $user = User::find($userId);

        $request->validate([
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('profile_pic')) {
            // Define the directory
            $directory = 'profile_pics';
    
            // Ensure the directory exists
            Storage::disk('public')->makeDirectory($directory);
    
            // Delete old image (if any)
            if ($user->profile_picture) {
                Storage::disk('public')->delete($directory . '/' . $user->profile_picture);
            }
    
            // Generate a unique filename
            $filename = time() . '.' . $request->profile_pic->getClientOriginalExtension();
    
            // Store the file explicitly in the "public" disk
            $request->profile_pic->storeAs(
                $directory, 
                $filename, 
                'public' // ← Specify the disk here
            );
    
            // Update the user's profile picture
            $user->profile_picture = $filename;
            $user->save();
        }
    
        return redirect()->back()->with('success', 'Profile updated!');
    
    }
}