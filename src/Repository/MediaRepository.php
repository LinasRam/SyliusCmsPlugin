<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Repository;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class MediaRepository extends EntityRepository implements MediaRepositoryInterface
{
    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
        ;
    }

    public function findOneEnabledByCode(string $code): ?MediaInterface
    {
        return $this->createQueryBuilder('o')
            ->where('o.code = :code')
            ->andWhere('o.enabled = true')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findBySectionCode(string $sectionCode, string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.sections', 'section')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('section.code = :sectionCode')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('sectionCode', $sectionCode)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProductCode(string $productCode, string $localeCode): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.translations', 'translation')
            ->innerJoin('o.products', 'product')
            ->andWhere('translation.locale = :localeCode')
            ->andWhere('product.code = :productCode')
            ->andWhere('o.enabled = true')
            ->setParameter('localeCode', $localeCode)
            ->setParameter('productCode', $productCode)
            ->getQuery()
            ->getResult()
        ;
    }
}