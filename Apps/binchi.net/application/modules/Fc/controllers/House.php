<?php
class HouseController extends Controller
{
    
    /**
     * 出售房列表
     */
    public function saleAction()
    {
        
        $vars = [
            'type'       => 'sale',
            'publishTab' => true,
            'publishUrl' => '/fc/house/newSale',
        ];
        $this->getView()->assign($vars);
    }
    
    /**
     * 发布出售房
     */
    public function newSaleAction()
    {
        $now = time();
        $nonceStr = String::rand(16);
        $weixin = new Weixin(Yaf_Registry::get('app_name'));
        $args = [
            'jsapi_ticket' => $weixin->getJsapiTicket(),
            'noncestr' => $nonceStr,
            'timestamp' => $now,
            'url' => 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']
        ];
        $args = urldecode(http_build_query($args));
//         echo $args;
        $signature = sha1($args);
        
        
        $vars = [
            'type' => 'sale',
            'timestamp'  => $now,
            'nonceStr'   => $nonceStr,
            'signature'  => $signature,
            'publishTab' => false,
        ];
        $this->getView()->assign($vars);
    }

    /**
     * 出租房列表
     */
    public function rentAction()
    {
        
        
        $vars = [
            'type' => 'rent',
            'publishTab' => false,
            'publishUrl' => '/fc/house/newRent',
        ];
        $this->getView()->assign($vars);
    }
    
    /**
     * 发布出租房
     */
    public function newRentAction()
    {
        
        
        $vars = [
            'type' => 'rent',
            'publishTab' => false,
        ];
        $this->getView()->assign($vars);
    }

    /**
     * 求购房列表
     */
    public function buyAction()
    {
        
        
        $vars = [
            'type' => 'buy',
            'publishTab' => true,
            'publishUrl' => '/fc/house/newBuy',
        ];
        $this->getView()->assign($vars);
    }
    
    /**
     * 发布求购房
     */
    public function newBuyAction()
    {
        
        
        $vars = [
            'type' => 'buy',
            'publishTab' => false,
        ];
        $this->getView()->assign($vars);
    }

    /**
     * 求租房列表
     */
    public function qzAction()
    {
        
        
        
        $vars = [
            'type' => 'qz',
            'publishTab' => true,
            'publishUrl' => '/fc/house/newQz',
        ];
        $this->getView()->assign($vars);
    }
    
    /**
     * 发布求租房
     */
    public function newQzAction()
    {
        
        
        $vars = [
            'type' => 'qz',
            'publishTab' => false,
        ];
        $this->getView()->assign($vars);
    }
    
    
    
}
