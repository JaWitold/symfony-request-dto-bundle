<?php

namespace DM\DtoRequestBundle\Annotations\Entity;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use DM\DtoRequestBundle\Interfaces\Entity\ProviderInterface;

/**
 * Allows setting which entity is provided by the provider
 *
 * Use together with implementing {@link ProviderInterface}
 *
 * @Annotation
 * @NamedArgumentConstructor()
 */
class EntityProvider
{
    public string $fqcn;
    public bool $default;

    public function __construct(
        string $fqcn,
        bool $default = false
    ) {
        $this->fqcn = $fqcn;
        $this->default = $default;
    }
}
