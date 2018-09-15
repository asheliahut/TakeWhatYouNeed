<?php

namespace Take\GraphQl;

use function Digia\GraphQL\graphql;
use Digia\GraphQL\Schema\Schema;

class GraphQLService
{
    private $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function executeQuery(string $query, array $variables, ?string $operationName): array
    {
        return graphql($this->schema, $query, null, null, $variables, $operationName);
    }
}
