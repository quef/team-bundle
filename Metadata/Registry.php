<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 16/06/16
 * Time: 23:17
 */

namespace Quef\TeamBundle\Metadata;


use Quef\TeamBundle\Model\TeamInterface;

class Registry implements RegistryInterface
{
    /** @var MetadataInterface[] */
    private $metadata = [];

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        if (!array_key_exists($alias, $this->metadata)) {
            throw new \InvalidArgumentException(sprintf('Team "%s" does not exist.', $alias));
        }

        return $this->metadata[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function getByObject(TeamInterface $object)
    {
        $className = get_class($object);
        foreach ($this->metadata as $metadata) {
            if ($className === $metadata->getTeam()) {
                return $metadata;
            }
        }

        throw new \InvalidArgumentException(sprintf('Resource with model class "%s" does not exist.', $className));
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return array_keys($this->metadata);
    }


    /**
     * {@inheritdoc}
     */
    public function add(MetadataInterface $metadata)
    {
        $this->metadata[$metadata->getAlias()] = $metadata;
    }

}