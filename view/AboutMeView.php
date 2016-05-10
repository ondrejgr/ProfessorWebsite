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

    protected function OnGenerateHead() {
?>
        <style>
            @media only screen and (min-width: 768px) 
            {
                .AcademicPositionsCollection
                {
                    float: left;
                }
                .EducationTrainingCollection
                {
                    float: left;
                }
                .HonorsCollection
                {
                    float: left;
                }
            }
        </style>
<?php
    }
    
    private function RenderPortrait()
    {
?>
                    <div class="portrait"><img src="img/portrait.png" alt="<?php echo $this->model->dbInfo->getFullName() ?>" /></div>
<?php
    }
        
    protected function OnRenderBeforeContent()
    {
        $this->RenderPortrait();        
    }
    
    
    protected function OnGenerateContent()
    {
        $this->RenderContent();
?>
                <div class="collections">
<?php
        $this->RenderCollection($this->model->academicPositions);
        $this->RenderCollection($this->model->educationTraining);
?>
                </div>
<?php
?>
                <div class="collections">
<?php
        $this->RenderCollection($this->model->honors);
?>
                </div>
<?php
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeView($model, $controller);
$view->Generate();
