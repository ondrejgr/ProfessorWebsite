<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/TeachingModel.php';

class TeachingView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }

  
    
    protected function OnGenerateContent()
    {
        $this->RenderContent();
?>
                <div class="collections">
<?php
        $this->RenderCollection($this->model->teaching);
?>
                </div>
<?php
    }
}

$model = new \gratz\TeachingModel("Teaching");
$controller = new \gratz\BaseController($model);
$view = new \gratz\TeachingView($model, $controller);
$view->Generate();
