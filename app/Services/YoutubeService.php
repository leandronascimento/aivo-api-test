<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class YoutubeService
{
    const API_URL = 'https://www.googleapis.com/youtube/v3/search';
    const MAX_RESULTS_PER_REQUEST = 10;

    /**
     * Method to search videos from Youtube
     *
     * @param string $query
     * @return array|mixed
     * @throws \Exception
     */
    public function searchVideos(string $query)
    {
        if (empty($query)) {
            throw new \InvalidArgumentException('the search query must not be empty');
        }

        try {
            $response = Http::get(self::API_URL, [
                'q' => $query,
                'part'=> 'snippet',
                'chart'=> 'mostPopular',
                'type' => 'video',
                'key' => env('GOOGLE_KEY'),
                'maxResults' => self::MAX_RESULTS_PER_REQUEST
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $this->transformList($response->object());
    }

    /**
     * Transform the youtube response, extract the list of resource objects
     *
     * @param $data
     * @return Collection Array of StdClass objects
     * @throws \Exception
     */
    public function transformList($data)
    {
        if (isset($data->error)) {
            $msg = 'Error ' . $data->error->code . ' ' . $data->error->message;
            if (isset($data->error->errors[0])) {
                $msg .= ' : ' . $data->error->errors[0]->reason;
            }
            throw new BadRequestException($msg, $data->error->code);
        } else {
            $result = collect();
            foreach ($data->items as $item) {
                $result->push([
                    'published_at' => $item->snippet->publishedAt,
                    'id' => $item->id->videoId,
                    'title' => $item->snippet->title,
                    'description' => $item->snippet->description,
                    'thumbnail' => $item->snippet->thumbnails->default->url,
                    'extra' => [
                        'channelTitle' => $item->snippet->channelTitle,
                        'liveBroadcastContent' => $item->snippet->liveBroadcastContent,
                        'publishTime' => $item->snippet->publishTime
                    ]
                ]);
            }

            return $result;
        }
    }


}
