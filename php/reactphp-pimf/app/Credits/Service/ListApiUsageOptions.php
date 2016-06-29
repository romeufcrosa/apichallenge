<?php
namespace Credits\Service;

use Pimf\Util\Json;
use React\Http\Response as ReactiveResponse;

final class ListApiUsageOptions
{
    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(ReactiveResponse $response)
    {
        $this->response = $response;
    }

    public function __invoke()
    {
        $this->response->writeHead(200, ['Content-Type' => 'application/json; charset=utf-8']);

        return $this->response->end(Json::encode([
            'credits' => [
                'create new credit' => [
                    'url'           => '/credits',
                    'method'        => 'POST',
                    'body params'        => [
                        'title'   => 'string',
                        'content' => 'string',
                    ],
                    'response body' => [
                        '{newId": integer}',
                    ],
                ],

                'retrieve specific credit' => [
                    'url'           => '/credits/{id}',
                    'method'        => 'GET',
                    'url params'        => [
                        'id' => 'integer',
                    ],
                    'response body' => [
                        '{"balanceId": "integer", "customerId": "integer", "websiteId": "integer", "amount": "string"}',
                    ],
                ],

                'update specific credit' => [
                    'url'    => '/credits/{id}',
                    'method' => 'PUT',
                    'url params' => [
                        'id'      => 'integer',
                    ],
                    'body params' => [
                        'balanceId'     => 'integer',
                        'websiteId'     => 'integer',
                        'amount'        => 'string',
                    ],
                ],

                'delete specific credit' => [
                    'url'    => '/credits/{id}',
                    'method' => 'DELETE',
                    'url params' => [
                        'id' => 'integer',
                    ],
                ],
            ],
        ]));
    }
}
