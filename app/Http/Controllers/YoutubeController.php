<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\YoutubeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class YoutubeController extends Controller
{
    /**
     *  Call the search list method to retrieve results matching the specified query term
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function search(Request $request): JsonResponse
    {
        $youtubeService = new YoutubeService();

        try {
            $data = $youtubeService->searchVideos($request->get('query'));
        } catch (\Exception $e) {
            return $this->createApiResponseError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($data->isEmpty()) {
            return $this->notFound('the search query not returned any results');
        }

        return $this->createApiResponse($data);
    }
}
