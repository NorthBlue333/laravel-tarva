<?php

namespace LaravelTarva\Http\Requests\Resource;

use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceRequest;

class ResourceIndexRequest extends ResourceRequest
{
    public function getPerPageResource(): int {
        return $this->has('perPage') && in_array($this->get('perPage'), [10, 25, 50])
            ? $this->get('perPage')
            : 10;
    }

    public function getFilters(): array {
        return [
            'perPage' => $this->getPerPageResource()
        ];
    }

    public function getFilterOptions(): array {
        return [
            'perPage' => [
                'type' => 'select',
                'values' => [
                    10,
                    25,
                    50
                ]
            ]
        ];
    }

    public function getFilterDefaults(): array {
        return [
            'perPage' => 10
        ];
    }
}
