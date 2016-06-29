<?php
namespace Credits\Service;

use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Json;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class FindExistingCredit
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

    /**
     * @SWG\Get(
     *     path="/credits/{id}",
     *     summary="Finds Credit by Customer ID",
     *     tags={"credit"},
     *     description="Retrieves credit information for a specific customer",
     *     operationId="FindExistingCredit",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Customer id to filter by",
     *         required=true,
     *         type="integer",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Customer Credit Found",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Credit")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid Customer ID",
     *     ),
     *     security={
     *         {
     *             "credits_auth": {"write:credits", "read:credits"}
     *         }
     *     }
     * )
     */
    public function __invoke()
    {
        $route = new Route('/credits/:id');

        if($route->init()->matches() === false){
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $query = new Param($route->getParams());
        $id = $query->get('id');

        if (!$id) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $valid = new Validator($query);

        if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $credit = $this->em->credit->find($id);

        if (!$credit) {
            //not found
            $this->response->writeHead(404);
            return $this->response->end();
        }

        //yes we got the credit finally!
        $this->response->writeHead(200, ['Content-Type' => 'application/json; charset=utf-8']);

        return $this->response->end(Json::encode($credit->toArray()));
    }
}
