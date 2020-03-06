<?php

namespace NbbDetailPage\Storefront\Struct;

use Shopware\Core\Framework\Struct\Struct;

class GroupedPropertiesStruct extends Struct
{
    /** @var array */
    private $groups;


    public function __construct(array $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        return $this->groups;
    }
}
