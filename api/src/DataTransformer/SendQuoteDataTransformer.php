<?php


namespace App\DataTransformer;


use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\SendQuoteDto;

class SendQuoteDataTransformer implements DataTransformerInterface
{

    /**
     * Transforms the given object to something else, usually another object.
     * This must return the original object if no transformation has been done.
     *
     * @param object $object
     *
     * @return object
     */
    public function transform($object, string $to, array $context = [])
    {
        return $object;
    }

    /**
     * Checks whether the transformation is supported for a given object and context.
     *
     * @param object $object
     */
    public function supportsTransformation($object, string $to, array $context = []): bool
    {
        return $object instanceof SendQuoteDto;
    }
}