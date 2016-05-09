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

    private function GeneratePortrait()
    {
?>
                <div class="portrait"><img src="img/portrait.png" alt="<?php echo $this->model->dbInfo->getFullName() ?>" /></div>
<?php
    }
    
    protected function OnGenerateContent()
    {
        if (is_string($this->model->content) && strlen($this->model->content) > 0)
        {
            $this->GeneratePortrait();

            $array = explode("\n", str_replace("\r", '', $this->model->content));
            if (!$array)
            {
                return FALSE;
            }
            
            foreach ($array as $item)
            {
                echo "                <p>$item</p>\n";
            }
        }
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeView($model, $controller);
$view->Generate();
