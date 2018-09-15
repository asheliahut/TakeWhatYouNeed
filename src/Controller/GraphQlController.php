<?php

namespace Take\Controller;

use Seld\JsonLint\JsonParser;
use Slim\Http\Request;
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
        $payload       = $request->getBody()->getContents();
        $operationName = null;
        $query         = null;

        // Returns a tuple
        [$query, $variables, $operationName] = $this->parsePayload($request, $payload);

        $result = $this->graphqlService->executeQuery($query, $variables, $operationName);

        return $response->withJson($result);
    }

    private function parsePayload(Request $request, string $payload): array
    {
        // http://graphql.org/learn/serving-over-http/#post-request
        if ('application/json' === $request->getMediaType()) {
            $requestData = \json_decode($payload, true);


            if (null !== $requestData) {
                $query     = $requestData['query']     ?? null;
                $variables = $requestData['variables'] ?? [];
                $operationName = $requestData['operationName'];
            } else {
                // They sent us JSON, and we know it's unparseable. As such, bail out with some education.
                try {
                    $parser = new JsonParser();
                    $parser->parse($payload);
                } catch (Throwable $e) {
                    throw new Exception($e->getMessage(), HttpStatus::BAD_REQUEST);
                }
            }
        } elseif ('application/graphql' === $request->getMediaType()) {
            // Let the GraphQL engine perform the validation.
            $query = $payload;
        } else {
            // Unsupported Media Type
            throw new Exception(\sprintf(
                'The allowed media types are `%s` and `%s`. See %s for more information about the differences.',
                'application/json',
                'application/graphql',
                'http://graphql.org/learn/serving-over-http/#post-request'
            ), HttpStatus::UNSUPPORTED_MEDIA_TYPE);
        }

        return [
            $query ?? null,
            $variables ?? [],
            $operationName ?? 'Query'
        ];
    }
}
