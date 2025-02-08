<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SocialPlatformsMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_platforms_master')->insert([
            [
                'platform_name' => 'Facebook',
                'url' => 'https://www.facebook.com',
                'logo' => 'facebook.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'WhatsApp',
                'url' => 'https://www.whatsApp.com',
                'logo' => 'whatsApp.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'YouTube',
                'url' => 'https://www.youtube.com',
                'logo' => 'youtube.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Instagram',
                'url' => 'https://www.instagram.com',
                'logo' => 'instagram.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Twitter',
                'url' => 'https://www.twitter.com',
                'logo' => 'twitter.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'TikTok',
                'url' => 'https://www.tiktok.com',
                'logo' => 'tiktok.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'WeChat',
                'url' => 'https://www.wechat.com',
                'logo' => 'wechat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Telegram',
                'url' => 'https://www.telegram.com',
                'logo' => 'telegram.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Snapchat',
                'url' => 'https://www.snapchat.com',
                'logo' => 'snapchat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'LinkedIn',
                'url' => 'https://www.linkedin.com',
                'logo' => 'linkedin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Kuaishou',
                'url' => 'https://www.kuaishou.com',
                'logo' => 'kuaishou.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Sina Weibo',
                'url' => 'https://www.sinaweibo.com',
                'logo' => 'sinaweibo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'QQ',
                'url' => 'https://www.qq.com',
                'logo' => 'qq.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Pinterest',
                'url' => 'https://www.pinterest.com',
                'logo' => 'pinterest.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Reddit',
                'url' => 'https://www.reddit.com',
                'logo' => 'reddit.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Quora',
                'url' => 'https://www.quora.com',
                'logo' => 'quora.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Discord',
                'url' => 'https://www.discord.com',
                'logo' => 'discord.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Twitch',
                'url' => 'https://www.twitch.com',
                'logo' => 'twitch.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Tumblr',
                'url' => 'https://www.tumblr.com',
                'logo' => 'tumblr.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Threads',
                'url' => 'https://www.threads.com',
                'logo' => 'threads.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'bluesky',
                'url' => 'https://www.bluesky.com',
                'logo' => 'bluesky.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'platform_name' => 'Mastodon',
                'url' => 'https://www.mastodon.com',
                'logo' => 'mastodon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}