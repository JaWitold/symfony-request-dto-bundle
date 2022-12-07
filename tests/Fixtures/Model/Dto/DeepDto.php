<?php

namespace DM\DtoRequestBundle\Tests\Fixtures\Model\Dto;

use DM\DtoRequestBundle\Annotations\Dto\Path;
use DM\DtoRequestBundle\Model\AbstractDto;

class DeepDto extends AbstractDto
{
    /**
     * @Path("something.deep")
     */
    public ?string $pathed = null;
}