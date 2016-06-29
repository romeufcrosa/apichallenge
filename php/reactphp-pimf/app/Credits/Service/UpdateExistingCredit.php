<?php
namespace Credits\Service;

use Credits\Model\Credit;
use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class UpdateExistingCredit
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ReactiveRequest
     */
    protected $request;

    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(EntityManager $em, ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->em = $em;
        $this->request = $request;
        $this->response = $response;
    }

    public function __invoke()
    {
        $this->request->on('data', function ($requestBody) {

            $route = new Route('/credits/:id');

            if($route->init()->matches() === false){
                //method not allowed
                $this->response->writeHead(405);
                return $this->response->end();
            }

            $requestData = [];
            parse_str($requestBody, $requestData);
            $requestData = new Param($requestData + $route->getParams());

            $balanceId = $requestData->get('balance_id');
            $customerId = $requestData->get('id');
            $websiteId = $requestData->get('website_id');
            $amount = $requestData->get('amount');
            $baseCurrencyCode = $requestData->get('base_currency_code');

            $valid = new Validator($requestData);

            if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            if (!$title || !$content) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            $credit = new Credit($customerId, $websiteId, $amount, $baseCurrencyCode);
            $credit = $this->em->credit->reflect($credit, (int)$customerId);
            $updated = $this->em->credit->update($credit);

            if ($updated === true) {
                $this->response->writeHead(200);

                return $this->response->end();
            }

            //not found
            $this->response->writeHead(404);
            return $this->response->end();

        });
    }
}
