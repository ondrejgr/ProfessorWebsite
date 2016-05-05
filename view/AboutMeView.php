<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/AboutMeModel.php';

class AboutMeView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
        if (is_string($this->model->content) && strlen($this->model->content) > 0)
        {
            $array = explode("\n", str_replace("\r", '', $this->model->content));
            if ($array)
            {
                foreach ($array as $item)
                {
                    echo "                <p>$item</p>\n";
                }
            }
        }
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeView($model, $controller);
$view->Generate();
