<?php
class RentController extends Controller
{
    public function indexAction()
    {
        file_put_contents(__DIR__.'/t.txt', var_export($_POST,true)."\n".var_export($_SERVER,true));
    }
    
    public function getAction()
    {
        echo 33;
    }
}