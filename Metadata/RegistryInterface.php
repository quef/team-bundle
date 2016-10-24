<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 17/06/16
 * Time: 12:04
 */

namespace Quef\TeamBundle\Metadata;


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
     * @param string $className
     * @return MetadataInterface
     */
    public function getByClass($className);


    public function add(MetadataInterface $metadata);

}