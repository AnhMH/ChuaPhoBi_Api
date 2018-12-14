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
        'logo',
        'welcome_text',
        'name',
        'address',
        'phone',
        'email',
        'facebook',
        'twitter',
        'instagram',
        'google_plus',
        'footer_text',
        'language_type',
        'youtube',
        'bg_header',
        'bg_body',
        'bg_notice'
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
        $result['settings'] = self::get_detail(array(
            'language_type' => $languageType
        ));
        
        // Get notices
        $result['notices'] = Model_Notice::get_all(array(
            'language_type' => $languageType,
            'page' => 1,
            'limit' => 5
        ));
                
        // Return
        return $result;
    }
    
    /**
     * Get general
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function get_admin_general($param)
    {
        // Init
        $result = array();
        
        $posts = DB::select('*')->from('posts')->where('disable', 0)->execute();
        $result['post_count'] = count($posts);
        
        $notices = DB::select('*')->from('notices')->where('disable', 0)->execute();
        $result['notice_count'] = count($notices);
        
        $cates = DB::select('*')->from('cates')->where('disable', 0)->execute();
        $result['cate_count'] = count($cates);
        
        $contacts = DB::select('*')->from('contacts')->execute();
        $result['contact_count'] = count($contacts);
                
        // Return
        return $result;
    }
    
    /**
     * Add update info
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function add_update($param)
    {
        // Init
        $self = array();
        $languageType = !empty($param['language_type']) ? $param['language_type'] : 1;
        
        // Get data
        $self = self::find('first', array(
            'where' => array(
                'language_type' => $languageType
            )
        ));
        if (empty($self)) {
            $self = new self;
        }
        
        // Upload image
        if (!empty($_FILES)) {
            $uploadResult = \Lib\Util::uploadImage(); 
            if ($uploadResult['status'] != 200) {
                self::setError($uploadResult['error']);
                return false;
            }
            $param['logo'] = !empty($uploadResult['body']['logo']) ? $uploadResult['body']['logo'] : '';
            $param['bg_body'] = !empty($uploadResult['body']['bg_body']) ? $uploadResult['body']['bg_body'] : '';
            $param['bg_header'] = !empty($uploadResult['body']['bg_header']) ? $uploadResult['body']['bg_header'] : '';
            $param['bg_notice'] = !empty($uploadResult['body']['bg_notice']) ? $uploadResult['body']['bg_notice'] : '';
        }
        
        // Set data
        if (!empty($param['name'])) {
            $self->set('name', $param['name']);
        }
        if (!empty($param['logo'])) {
            $self->set('logo', $param['logo']);
        }
        if (!empty($param['welcome_text'])) {
            $self->set('welcome_text', $param['welcome_text']);
        }
        if (!empty($param['address'])) {
            $self->set('address', $param['address']);
        }
        if (!empty($param['phone'])) {
            $self->set('phone', $param['phone']);
        }
        if (!empty($param['email'])) {
            $self->set('email', $param['email']);
        }
        if (!empty($param['facebook'])) {
            $self->set('facebook', $param['facebook']);
        }
        if (!empty($param['twitter'])) {
            $self->set('twitter', $param['twitter']);
        }
        if (!empty($param['instagram'])) {
            $self->set('instagram', $param['instagram']);
        }
        if (!empty($param['google_plus'])) {
            $self->set('google_plus', $param['google_plus']);
        }
        if (!empty($param['youtube'])) {
            $self->set('youtube', $param['youtube']);
        }
        if (!empty($param['bg_body'])) {
            $self->set('bg_body', $param['bg_body']);
        }
        if (!empty($param['bg_header'])) {
            $self->set('bg_header', $param['bg_header']);
        }
        if (!empty($param['bg_notice'])) {
            $self->set('bg_notice', $param['bg_notice']);
        }
        if (!empty($param['footer_text'])) {
            $self->set('footer_text', $param['footer_text']);
        }
        $self->set('language_type', $languageType);
        
        // Save data
        if ($self->save()) {
            if (empty($self->id)) {
                $self->id = self::cached_object($self)->_original['id'];
            }
            return $self->id;
        }
        
        return false;
    }
    
    /**
     * Get detail
     *
     * @author AnhMH
     * @param array $param Input data
     * @return int|bool User ID or false if error
     */
    public static function get_detail($param)
    {
        $languageType = !empty($param['language_type']) ? $param['language_type'] : 1;
        $data = self::find('first', array(
            'where' => array(
                'language_type' => $languageType
            )
        ));
        
        return !empty($data) ? $data : array();
    }
}
