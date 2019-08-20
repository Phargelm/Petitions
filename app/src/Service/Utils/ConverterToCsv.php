<?php declare(strict_types=1);

namespace App\Service\Utils;

class ConverterToCsv
{
    public function convert(array $data, array $keysFilter = [], array $header = [])
    {
        $resource = fopen('php://memory', 'w');
        fputcsv($resource, $header);

        array_walk($data, function(array $item) use ($keysFilter, $resource) {
            $filteredItem = array_intersect_key($item, $keysFilter);
            fputcsv($resource, $filteredItem);
        });
        
        rewind($resource);
        return $resource;
    }
}