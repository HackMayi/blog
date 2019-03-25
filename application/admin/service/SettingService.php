<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/28
 * Time: 15:23
 */
namespace app\admin\service;

use think\Exception;

class SettingService
{
    public static $path      = APP_PATH.'extra/web_setting.php';
    public static $blog_path = APP_PATH.'extra/blog_setting.php';

    public static function checkFile($param = array(),$path = '')
    {
        if (empty($path))throw new Exception('Path File Error');
        $filename = fopen($path,'w');
        if (!$filename) throw new Exception('open File Error');
        fwrite($filename,self::defaultData($param,$param['genre']));
        fclose($filename);
    }

    protected static function defaultData($param,$genre)
    {
        switch ($genre) {
            case 'admin':
                $array = "
<?php

// +----------------------------------------------------------------------
// | WEB Setting 
// +----------------------------------------------------------------------


return [
        'title'      =>  '{$param['title']}'
        ,'icp'       =>  '{$param['icp']}'
        ,'footer'    =>  '{$param['footer']}'
        ,'describe'  =>  '{$param['describe']}'
        ,'keywords'  =>  '{$param['keywords']}'
];
";
                break;
            case 'blog':
                $array = "
<?php

// +----------------------------------------------------------------------
// | Blog Setting 
// +----------------------------------------------------------------------

return [
        'home_title'      =>  '{$param['home_title']}'
        ,'web_type'       =>  '{$param['web_type']}'
        ,'is_qrcode'       =>  '{$param['is_qrcode']}'
        ,'home_qrcode'    =>  '{$param['home_qrcode']}'
        ,'path'           =>  '{$param['path']}'
        ,'home_notice'    =>  '{$param['home_notice']}'
        ,'home_footer'    =>  '{$param['home_footer']}'
        ,'home_describe'  =>  '{$param['home_describe']}'
        ,'home_keywords'  =>  '{$param['home_keywords']}'
];
";
                break;
            default:
                $array = array();
        }
        return $array;
    }
}