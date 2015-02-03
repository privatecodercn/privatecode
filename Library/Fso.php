<?php
/**
 * 文件系统操作
 *
 * Created        : 2012-06-21
 * Modified        : 2014-05-23
 * @link        : http://www.59c.net
 * @copyright    : (C) 2012 - 2014 59C.NET
 * @version        : 0.1.0
 * @author        : Joseph Chen (chenliq@gmail.com)
 */
class Fso
{

    /**
     * 获取文件名对应的后缀
     * @param string $file
     */
    public static function getExt($file)
    {
        return strtolower(pathinfo($file,PATHINFO_EXTENSION));
    }

    /**
     * 判断文件名后缀和类型是否一致
     * @param string $ext
     * @param string $file
     */
    public static function isExtMatchMime($ext, $file)
    {
        if (isset(self::$extMimeMapping[$ext]))
        {
            return (self::$extMimeMapping[$ext] == self::getMimeType($file));
        } else {
            return true;
        }
    }

    /**
     * 获取文件的mime-type
     * @param string $file
     */
    public static function getMimeType($file)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($finfo, $file);
        finfo_close($finfo);
        return $type;
    }

    /**
     * 写内容到文件中
     * @param string $file
     * @param string $content
     * @param string $type
     * @param boolean $return
     */
    public static function write($file, $content, $type='php', $return=true)
    {
        if ($type == 'php')
        {
            if ($return)
            {
                $return = ' return ';
            } else {
                $return = '';
            }
            $content = '<?php'.$return.$content.';';
        }
        $dir = dirname($file);
        self::mkdir($dir);
        if (!is_file($file) || is_writeable($file))
        {
            $fp = fopen($file, 'w+');
            fwrite($fp, $content);
            fclose($fp);
        }
        return true;
    }

    /**
     * 随机生成一个文件名
     * @param string $function
     * @param string $date
     * @return string
     */
    public static function randFileName($function='', $date='Ym/')
    {
        switch ($function)
        {
            case 'time':
                $name = time();
                break;
                    
            case 'microtime':
                $name = strtr(microtime(1),array('.'=>''));
                break;
                    
            case 'uniqid':
                $name = uniqid();
                break;
                    
            case 'microuniqid':
                $time = explode('.', microtime(1));
                $name = $time[1].uniqid();
                break;
                    
            case 'uniqidmicro':
                $time = explode('.', microtime(1));
                $name = uniqid().$time[1];
                break;
                    
            default:
                $time = explode('.', microtime(1));
                $name = $time[1].uniqid();
                break;
        }
        if ($date)
        {
            return date($date).$name.rand(1, 999);
        } else {
            return $name.rand(1, 999);
        }
    }

    /**
     * 创建一个目录
     * @param string $dir
     */
    public static function mkdir($dir, $mode=0755)
    {
        if (!is_dir($dir))
        {
            mkdir($dir, $mode, true);
        }
        return true;
    }
    
    public static function clearDir($dir)
    {
        $d = dir($dir);
        while($entry=$d->read())
        {
            if($entry != "." && $entry != "..")
            {
                if(is_file($dir.'/'.$entry))
                {
                    unlink($dir.'/'.$entry);
                } else {
                    
                }
            }
        }
        $d->close();
    }
    
    
    public static $extMimeMapping = [
        'gif'    => 'image/gif',
        'jpg'    => 'image/jpeg',
        'png'    => 'image/png',
        'rar'    => 'application/x-rar',
        'zip'    => 'application/zip',
        'tgz'    => 'application/x-compressed',
        'gz'     => 'application/x-gzip',
        'tar'    => 'application/x-tar',
        'doc'    => 'application/msword',
        'xls'    => 'application/vnd.ms-excel',
        'ppt'    => 'application/vnd.ms-powerpoint',
        'asf'    => 'video/x-ms-asf',
        'asx'    => 'video/x-ms-asf',
        'avi'    => 'video/x-msvideo',
        'mp4'    => 'video/mp4',
        'mpeg'   => 'video/mpeg',
        'mpg'    => 'video/mpeg',
        'mov'    => 'video/quicktime',
        'rmvb'   => 'audio/x-pn-realaudio',
        'rm'     => 'audio/x-pn-realaudio',
        'wmv'    => 'audio/x-ms-wmv',
    ];

    
    
}