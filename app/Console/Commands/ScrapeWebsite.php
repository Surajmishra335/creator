<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScrapedContent;
use simplehtmldom\HtmlWeb;

class ScrapeWebsite extends Command
{
    protected $signature = 'scrape:website';
    protected $description = 'Scrape headlines and images from a website';

    public function handle()
    {
        $url = 'https://www.thehindu.com/latest-news/'; // Replace with your target URL
        $html = new HtmlWeb();

        try {
            $dom = $html->load($url);

            // Clear the table before inserting new data
            ScrapedContent::truncate();

            // Find headlines and images
            $items = $dom->find('h3.title a'); // Adjust selector based on the target website
            // $images = $dom->find('img');  // Adjust selector based on the target website

            foreach ($items as $item) {
                $headlineText = trim($item->plaintext); // Get the text inside <a>
                $imageSrc = ''; // Replace with logic to find the associated image if applicable

                // Save to database
                ScrapedContent::create([
                    'headline' => $headlineText,
                    'image_url' => $imageSrc,
                ]);
            }

            $this->info('Scraping completed successfully!');
        } catch (\Exception $e) {
            $this->error('Error during scraping: ' . $e->getMessage());
        }
    }
}

