<?php

namespace NbbDetailPage\Storefront\Subscribers;

use NbbDetailPage\Storefront\Struct\GroupedPropertiesStruct;
use Shopware\Core\Content\Property\Aggregate\PropertyGroupOption\PropertyGroupOptionEntity;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PropertyGroupSetSubscriber implements EventSubscriberInterface
{
    const CUSTOM_FIELD_PROPERTY_SET = 'nbb_property_group_set';

    const CUSTOM_FIELD_PROPERTY_SET_NAME = 'name';
    const CUSTOM_FIELD_PROPERTY_SET_PROPERTIES = 'properties';

    public static function getSubscribedEvents()
    {
        return [

            ProductPageLoadedEvent::class => ['productPageLoaded']
        ];
    }

    public function productPageLoaded(ProductPageLoadedEvent $event)
    {
        $productPage = $event->getPage();

        $properties = $productPage->getProduct()->getProperties();

        $groupedProperties = [];

        /** @var PropertyGroupOptionEntity $property */
        foreach($properties as $property)
        {
            $groupSet = $property->getGroup()->getTranslated()['customFields'][self::CUSTOM_FIELD_PROPERTY_SET];

            $groupedProperties[$groupSet['id']][self::CUSTOM_FIELD_PROPERTY_SET_NAME] = $groupSet[self::CUSTOM_FIELD_PROPERTY_SET_NAME];
            $groupedProperties[$groupSet['id']][self::CUSTOM_FIELD_PROPERTY_SET_PROPERTIES][] = $property;

        }

        $productPage->addExtension('groupedProperties', new GroupedPropertiesStruct($groupedProperties));
    }
}
