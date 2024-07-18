<?php

namespace App\ArgumentResolver;

use App\Attribute\RequestBody;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyArgumentResolver implements ValueResolverInterface
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    )
    {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $needAttributes = $argument->getAttributes(
            RequestBody::class,
            ArgumentMetadata::IS_INSTANCEOF
        );

        if (count($needAttributes) < 1) {
            yield null;
        }

        try {
            $model = $this->serializer->deserialize(
                $request->getContent(), $argument->getType(), JsonEncoder::FORMAT
            );
        } catch (NotEncodableValueException $throwable) {
            throw new RequestBodyConvertException($throwable->getMessage());
        }

        $errors = $this->validator->validate($model);
        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }

        yield $model;
    }
}
