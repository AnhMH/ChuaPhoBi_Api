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
class Model_Setting extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'cate_id',
        'name',
        'description',
        'content',
        'image',
        'is_default',
        'is_home_slide',
        'is_hot',
        'type',
        'created',
        'updated',
        'disable'
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
    protected static $_table_name = 'settings';

    /**
     * Get general
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function get_general($param)
    {
        // Init
        $result = array();
        $languageType = !empty($param['language_type']) ? $param['language_type'] : 1;
        
        // Get cates
        $result['cates'] = Lib\Arr::key_values(Model_Cate::get_all(array(
            'get_sub_cates' => 1,
            'sort' => 'order-asc',
            'language_type' => $languageType
        )), 'id');
        
        // Get setting
        $result['settings'] = array(
            'web_title' => 'Con Là Tất Cả',
            'web_description' => 'Niềm vui của mẹ - Tự hào của cha - Con là tất cả. Cập nhật hàng ngày thông tin hữu ích liên quan đến cách chăm sóc, nuôi dạy con cái.',
            'web_keyword' => 'con la tat ca, nuoi day con thong minh, nuoi day con dung cach',
            'web_image' => 'https://img.conlatatca.info/conlatatca.png',
            'facebook' => 'https://www.facebook.com/pageconlatatca',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://www.instagram.com/conlatatcainfo/',
            'google_plus' => 'https://plus.google.com/u/0/113674456774184840341?hl=vi',
            'homepage_top_cate' => '3',
            'homepage_sub_cate' => array(1,2,4),
            'show_adv' => 1
        );
                
        // Return
        return $result;
    }
}
