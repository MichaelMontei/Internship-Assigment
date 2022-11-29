<?php namespace App\Acl;

use App\Shared\DataObject\MapperWithTimestamps;

/**
 * RoleMapper
 */
class RoleMapper extends MapperWithTimestamps
{
    /**
     * Add filter: default sorting
     *
     * @return \App\Acl\RoleMapper
     */
    public function addFilterDefaultSorting()
    {
        $this->addFilter(new \M\DataObject\FilterOrder('id', 'ASC'));
        return $this;
    }

    /**
     * Get by realm
     *
     * @param string $realm
     * @return Role
     */
    public function getByRealm($realm)
    {
        return $this->getByColumn(
            'realm',
            $realm
        )->current();
    }
}