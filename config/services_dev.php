<?php

use DM\DtoRequestBundle\Interfaces\Entity\ProviderServiceInterface;
use DM\DtoRequestBundle\Interfaces\Resolver\DtoResolverInterface;
use DM\DtoRequestBundle\Interfaces\Resolver\DtoTypeExtractorInterface;
use DM\DtoRequestBundle\Interfaces\Validation\TypeValidationInterface;
use DM\DtoRequestBundle\Profiler\Service\Entity\ProfilingEntityProviderService;
use DM\DtoRequestBundle\Profiler\Service\Resolver\ProfilingDtoResolverService;
use DM\DtoRequestBundle\Profiler\Service\Resolver\ProfilingDtoTypeExtractorService;
use DM\DtoRequestBundle\Profiler\Service\Validation\ProfilingTypeValidationService;
use DM\DtoRequestBundle\Service\Entity\EntityProviderService;
use DM\DtoRequestBundle\Service\Resolver\DtoResolverService;
use DM\DtoRequestBundle\Service\Resolver\DtoTypeExtractorHelper;
use DM\DtoRequestBundle\Service\Validation\TypeValidationHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $configurator) {
    $fn = include __DIR__ . '/services.php';

    $fn($configurator);

    $services = $configurator->services()
        ->defaults()
        ->private();

    // resolver timer
    $services->set(ProfilingDtoResolverService::class)
        ->arg(0, new Reference(DtoResolverService::class))
        ->arg(1, new Reference('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    $services->alias(DtoResolverInterface::class, ProfilingDtoResolverService::class);

    // extractor timer
    $services->set(ProfilingDtoTypeExtractorService::class)
        ->arg(0, new Reference(DtoTypeExtractorHelper::class))
        ->arg(1, new Reference('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    $services->alias(DtoTypeExtractorInterface::class, ProfilingDtoTypeExtractorService::class);

    // entity provider
    $services->set(ProfilingEntityProviderService::class)
        ->arg(0, new Reference(EntityProviderService::class))
        ->arg(1, new Reference('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    $services->alias(ProviderServiceInterface::class, ProfilingEntityProviderService::class);

    // type validator
    $services->set(ProfilingTypeValidationService::class)
        ->arg(0, new Reference(TypeValidationHelper::class))
        ->arg(1, new Reference('debug.stopwatch', ContainerInterface::NULL_ON_INVALID_REFERENCE));
    $services->alias(TypeValidationInterface::class, ProfilingTypeValidationService::class);
};
