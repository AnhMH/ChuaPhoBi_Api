<?php

use Fuel\Core\DB;

/**
 * Any query in Model Version
 *
 * @package Model
 * @created 2017-10-29
 * @version 1.0
 * @author AnhMH
 */
class Model_Page_View extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'total_views',
        'total_visit'
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );

    /** @var array $_table_name name of table */
    protected static $_table_name = 'page_views';

    /**
     * Add update info
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function add_update($param)
    {
        $self = self::find('first');
        if (empty($self)) {
            $self = new self;
        }
        $totalVisit = !empty($self['total_visit']) ? $self['total_visit'] : 0;
        $totalView = !empty($self['total_views']) ? $self['total_views'] + 1 : 1;
        if (!empty($param['is_visit'])) {
            $totalVisit += 1;
        }
        
        // Set data
        $self->set('total_views', $totalView);
        $self->set('total_visit', $totalVisit);
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return $self->id;
        }
        
        return false;
    }
}
