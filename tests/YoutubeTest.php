<?php

use Illuminate\Http\Response;

class YoutubeTest extends TestCase
{
    /**
     * Test a Json structure from response
     *
     * @return void
     */
    public function testEndpointStructure()
    {
        $this->get('/api/youtube?query=test');

        $this->assertResponseOk();
        $this->seeJsonStructure([
            '*' => [ 'published_at',
                'id',
                'title',
                'description',
                'thumbnail',
                'extra' => [
                    'channelTitle',
                    'liveBroadcastContent',
                    'publishTime'
                ]
            ]
        ]);
    }

    /**
     * Test empty query
     *
     * @return void
     */
    public function testEmptyQuery()
    {
        $this->get('/api/youtube?query=');

        $this->assertResponseStatus(Response::HTTP_BAD_REQUEST);
        $this->seeJson([
            'message' => 'the search query must not be empty'
        ]);
    }

    /**
     * Test not found results
     *
     * @return void
     */
    public function testNotFoundResults()
    {
        $this->get('/api/youtube?query=asdasdasdasadasdasdasdasdasd');

        $this->assertResponseStatus(Response::HTTP_NOT_FOUND);
        $this->seeJson([
                'message' => 'the search query not returned any results'
        ]);
    }
}
