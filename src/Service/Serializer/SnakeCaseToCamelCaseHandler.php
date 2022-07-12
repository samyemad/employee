<?php
namespace App\Service\Serializer;

use App\Service\Interfaces\SnakeCaseToCamelCaseHandlerInterface;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class SnakeCaseToCamelCaseHandler implements SnakeCaseToCamelCaseHandlerInterface
{
    /**
     * @var CamelCaseToSnakeCaseNameConverter
     */
    private CamelCaseToSnakeCaseNameConverter $camelCaseToSnakeCaseName;

    public function __construct(CamelCaseToSnakeCaseNameConverter $camelCaseToSnakeCaseName)
    {
        $this->camelCaseToSnakeCaseName = $camelCaseToSnakeCaseName;
    }
    /**
     * Passing json request and then decode it to array and convert it to camelCase
     * @param json $content
     * @return array
     */
    public function process(string $content):array
    {
        $newContent = [];
        $rows=json_decode($content,true);
        if(is_array($rows))
        {
            foreach ($rows as $key => $row)
            {
                $newKey = $this->camelCaseToSnakeCaseName->denormalize($key);
                $newContent[$newKey] = $row;
            }
        }
        return $newContent;
    }
}