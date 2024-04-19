<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PhpStan;

use Override;
use PHPStan\Analyser\MutatingScope;
use PHPStan\Type\Accessory\AccessoryNonEmptyStringType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use Symfony\Component\Clock\ClockInterface;
use Twint\Sdk\Certificate\CertificateContainer;

final class DocumentationScope extends MutatingScope
{
    #[Override]
    public function enterNamespace(string $namespaceName): MutatingScope
    {
        $scope = parent::enterNamespace($namespaceName);

        /** @var array<string, \PHPStan\Type\Type> $variables */
        static $variables = [
            'merchantId' => new StringType(),
            'orderReference' => new IntersectionType([new StringType(), new AccessoryNonEmptyStringType()]),
            'certificateContainer' => new ObjectType(CertificateContainer::class),
            'certificatePath' => new IntersectionType([new StringType(), new AccessoryNonEmptyStringType()]),
            'certificatePassphrase' => new IntersectionType([new StringType(), new AccessoryNonEmptyStringType()]),
            'clock' => new ObjectType(ClockInterface::class),
        ];

        return array_reduce(
            array_keys($variables),
            // @phpstan-ignore-next-line
            static fn (MutatingScope $scope, string $name) => $scope->assignVariable(
                $name,
                $variables[$name],
                $variables[$name]
            ),
            $scope
        );
    }
}
