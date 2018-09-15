<?php

namespace Take\Controller;

use Take\GraphQl\GraphQLService;

class GraphQLController
{
    private $graphqlService;

    public function __construct(GraphQLService $graphqlService)
    {
        $this->graphqlService = $graphqlService;
    }

    public function handle(Request $request): JsonResponse
    {
        $query         = $request->get('query');
        $variables     = $request->get('variables') ?? [];
        $operationName = $request->get('operationName');

        $result = $this->graphqlService->executeQuery($query, $variables, $operationName);

        return response()->json($result);
    }
}
