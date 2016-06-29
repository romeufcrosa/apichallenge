<?php
namespace Credits\Application;

use Credits\Service\WriteAllowedRequestMethods;
use Pimf\EntityManager;
use Pimf\Route;
use Pimf\Util\Character;
use \Pimf\Uri;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

use Credits\Service\FindExistingCredit;
use Credits\Service\CreateNewCredit;
use Credits\Service\DeleteExistingCredit;
use Credits\Service\ListApiUsageOptions;
use Credits\Service\UpdateExistingCredit;

final class Listener
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

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->request = $request;
        $this->response = $response;

        Uri::setup($this->request->getPath(), $this->request->getPath());

        $route = new Route('/credits(/:id)');

        // handle main route
        if($route->init()->matches() === false){
            $this->response->writeHead(500);
            return $this->response->end();
        }

        $routeTo = function($service){
          return $service();
        };

        // handle API requested resources
        switch ($this->request->getMethod()) {

            case 'GET':
                return $routeTo(new FindExistingCredit($this->em, $this->request, $this->response));

            case 'POST':
                return $routeTo(new CreateNewCredit($this->em, $this->request, $this->response));

            case 'PUT':
                return $routeTo(new UpdateExistingCredit($this->em, $this->request, $this->response));

            case 'DELETE':
                return $routeTo(new DeleteExistingCredit($this->em, $this->request, $this->response));

            case 'OPTIONS':
                return $routeTo(new ListApiUsageOptions($this->response));

            default:
                return $routeTo(new WriteAllowedRequestMethods($this->response));
        }

    }

}
