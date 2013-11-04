<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ragnar
 * Date: 19.06.12
 * Time: 22:28
 * To change this template use File | Settings | File Templates.
 */
class TeamMapper extends DataMapper
{
    protected $entityTable = 'teams';
    protected $primaryKey = 'team_id';



    protected function createEntity(array $row)
    {
        // TODO: Implement createEntity() method.
    }

}
