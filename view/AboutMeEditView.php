<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/AboutMeModel.php';
include 'controller/AboutMeEditController.php';

class AboutMeEditView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        $this->is_admin_required = \TRUE;
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
        $content = '';
        if (is_string($this->model->content) && strlen($this->model->content) > 0)
        {
            $content = $this->model->content;
        }
?>
                <form method="POST">
                    <div>
                        <div><label accesskey="C" for="Content">Content:</label></div>
                        <div><textarea id="Content" name="Content" cols="80" rows="10" autofocus><?php echo $content ?></textarea></div>
                    </div>
                    <div>
                        <div><input type="submit" value="Save"/></div>
                        <div><input type="reset" value="Reset"/></div>
                    </div>
                </form>
<?php
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\AboutMeEditController($model);
$view = new \gratz\AboutMeEditView($model, $controller);
$view->Generate();
