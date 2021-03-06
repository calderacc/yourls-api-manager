<?php declare(strict_types=1);

namespace Caldera\YourlsApiManager\Request;

interface RequestInterface
{
    public function __toString(): string;
    public function __toArray(): array;
}