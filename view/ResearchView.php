<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/ResearchModel.php';

class ResearchView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }
        
    private function ShowContentJS()
    {
?>
        <script>
            function ShowContent(obj)
            {
                        var div = $(obj).parent();
                        if (div)
                        {
                            fileName = div.find("div[data-prop-name='Content']");
                            if (fileName)
                            {
                                fileName.toggle();
                            }
                        }             
            }
        </script>
<?php
    }
    
    protected function OnGenerateContent()
    {
        $this->ShowContentJS();
        $this->RenderContent();
?>
                <div class="research-collections">
<?php
        $this->RenderCollection($this->model->researchProjects);
?>
                </div>
<?php
    }
    
    protected function RenderCollectionItem($item)
    {
        foreach ($item as $name => $value)
        {
            if ($name == "Title" || $name == "ShortText")
            {
?>
                                <div data-prop-name="<?php echo $name ?>" onclick="return ShowContent(this);"><?php echo $value ?></div>
<?php
            }
            else
            {
?>
                                <div data-prop-name="<?php echo $name ?>"><?php echo $value ?></div>
<?php
            }
        }
    }

}

$model = new \gratz\ResearchModel("Research");
$controller = new \gratz\BaseController($model);
$view = new \gratz\ResearchView($model, $controller);
$view->Generate();
