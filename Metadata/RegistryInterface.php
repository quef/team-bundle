<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 17/06/16
 * Time: 12:04
 */

namespace Quef\TeamBundle\Metadata;


use Quef\TeamBundle\Model\TeamInterface;

interface RegistryInterface
{

    /** @return MetadataInterface[] */
    public function getAll();

    /** @return array */
    public function getAliases();

    /**
     * @param string $alias
     * @return MetadataInterface
     */
    public function get($alias);

    /**
     * @param TeamInterface $className
     * @return MetadataInterface
     */
    public function getByObject(TeamInterface $className);


    public function add(MetadataInterface $metadata);

}