<?php

namespace Take\Controller;

use Slim\Http\Response;
use Take\GraphQl\GraphQLService;

class GraphQLController
{
    private $graphqlService;

    public function __construct(GraphQLService $graphqlService)
    {
        $this->graphqlService = $graphqlService;
    }

    public function handle(Request $request, Response $response): Response
    {
        $query         = $request->get('query');
        $variables     = $request->get('variables') ?? [];
        $operationName = $request->get('operationName');

        $result = $this->graphqlService->executeQuery($query, $variables, $operationName);

        return $response->withJson($result);
    }
}
