<?php

use Fuel\Core\DB;
use Lib\Util;

/**
 * Any query in Model Admin.
 *
 * @package Model
 * @version 1.0
 * @author AnhMH
 * @copyright Oceanize INC
 */
class Model_Admin extends Model_Abstract {

    protected static $_properties = array(
        'id',
        'name',
        'email',
        'password',
        'admin_type',
        'disable',
        'created',
        'updated',
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    
    protected static $_table_name = 'admins';
    
    /**
     * Login for admin.
     *
     * @author AnhMH
     * @param array $param Input data.
     * @return array|bool Returns the array or the boolean.
     */
    public static function login($param) {
        $param['password'] = Util::encodePassword($param['password'], $param['email']);
        $query = DB::select(
                self::$_table_name . '.*'
            )
            ->from(self::$_table_name)
            ->where(self::$_table_name . '.disable', 0)
            ->where(self::$_table_name . '.email', '=', $param['email'])
            ->where(self::$_table_name . '.password', '=', $param['password']);
        $data = $query->execute(self::$slave_db)->offsetGet(0);
        
        return $data;
    }
}
