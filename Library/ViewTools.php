<?php
/**
 * 视图工具
 * Created        : 2014-06-30
 * Modified        : 2014-07-09
 * @link        : http://www.kuiwa.cn
 * @copyright    : (C) 2014 KUIWA.CN
 */
class ViewTools
{
    // 页面中传递的静态代码(html,js,css)
    public $_code = '';
    public $jsFiles = [];
    public $cssFiles = [];
    public $incJsFiles = [];
    public $incCssFiles = [];
    /**
     * 当前控制器调用的模板主题路径
     * @var string
     */
    public $viewPath = '';
    /**
     * 当前控制器
     * @var object
     */
    public $controller = null;
    
    public static $instance = null;
    
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new ViewTools();
        }
        return self::$instance;
    }
    
    /**
     * 构造函数
     */
    public function __construct()
    {
        
    }

    /**
     * 压缩CSS
     * @param string $css
     * @return string
     */
    public function compressCss($css)
    {
        /* remove comments */
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        /* remove tabs, spaces, newlines, etc. */
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
        return $css;
    }
    
    /**
     * 压缩CSS
     * @param string $js
     * @return string
     */
    public function compressJs($js)
    {
        /* remove comments */
        $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js);
        $js = preg_replace("!//.*!", '', $js);
        /* remove tabs, spaces, newlines, etc. */
        $js = str_replace(array("\r\n", "\r", "\n", "\t"), '', $js);
        return $js;
    }

    /**
     * 预加载CSS/JS文件内容
     * @param string $name
     * @param string $type
     */
    public function preload($name, $type='css', $insertToTop=false)
    {
        if ($type=='css')
        {
            if (false === strpos($name, ','))
            {
                if ($insertToTop)
                {
                    array_unshift($this->cssFiles, $name);
                } else {
                    $this->cssFiles[] = $name;
                }
            } else {
                if ($insertToTop)
                {
                    $this->cssFiles = array_merge(explode(',', $name), $this->cssFiles);
                } else {
                    $this->cssFiles = array_merge($this->cssFiles, explode(',', $name));
                }
            }
        } else {
            if (false === strpos($name, ','))
            {
                if ($insertToTop)
                {
                    array_unshift($this->jsFiles, $name);
                } else {
                    $this->jsFiles[] = $name;
                }
            } else {
                if ($insertToTop)
                {
                    $this->jsFiles = array_merge(explode(',', $name), $this->jsFiles);
                } else {
                    $this->jsFiles = array_merge($this->jsFiles, explode(',', $name));
                }
            }
        }
        return true;
    }
    
    /**
     * 加载JS或CSS内容
     * @param string $type
     * @return string
     */
    public function load($type)
    {
        $tmp = APP_PATH.'data/'.$type.'/'.base64_encode(join(',', $this->jsFiles)).'.'.$type;
        if (!isset($_GET['recache']) && YAF_ENVIRON=='product' && is_file($tmp))
        {
            $content = file_get_contents($tmp);
        } else {
            $content = '';
            $files = ($type=='js') ? $this->jsFiles : $this->cssFiles;
            foreach ($files as $file)
            {
                if (0 === strpos($file, '//'))
                {
                    $file = Yaf_Registry::get('config')->application->viewPath.'/'.$type.'/'.substr($file, 2).'.'.$type;
                } elseif (0 === strpos($file, '../')) {
                    $file = dirname($this->viewPath).substr($file, 2).'.'.$type;
                } else {
                    $file = $this->viewPath.'/'.$type.'/'.$file.'.'.$type;
                }
                if (!is_file($file))
                {
                    continue;
                }
                $content .= file_get_contents($file);
            }
            $dir = dirname($tmp);
            if (!is_dir($dir))
            {
                mkdir($dir, 0775, true);
            }
            if ($content)
            {
                $content = ($type=='js') ? self::compressJs($content) : self::compressCss($content);
            }
            file_put_contents($tmp, $content);
        }
        if ($type=='js')
        {
            $content = <<<JS
<script type="text/javascript">
$content
</script>
JS;
        } else {
            $content = <<<CSS
<style type="text/css">
$content
</style>
CSS;
        }
        return $content;
    }

    /**
     * 预包含一个文件
     */
    public function preInc($file)
    {
        $ext = Fso::getExt($file);
        if ($ext == 'js')
        {
            $this->incJsFiles[] = $file;
        } else {
            $this->incCssFiles[] = $file;
        }
    }
    
    /**
     * 包含一个文件
     */
    public function inc($type)
    {
        $string = '';
        if ($type == 'css')
        {
            foreach ($this->incCssFiles as $file)
            {
                $string .= '<link href="'.$file.'" rel="stylesheet" type="text/css" />'."\n";
            }
        } else {
            foreach ($this->incJsFiles as $file)
            {
                $string .= '<script src="'.$file.'" type="text/javascript"></script>'."\n";
            }
        }
        return $string;
    }
    
    public function __get($name)
    {
        return null;
    }
}