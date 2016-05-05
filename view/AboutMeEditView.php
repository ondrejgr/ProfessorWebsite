<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/AboutMeModel.php';

class AboutMeEditView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        $this->is_admin_required = \TRUE;
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
?>
                <form method="POST">
                    <div>
                        <div><label accesskey="C" for="Content">Content:</label></div>
                        <div><input type="text" id="Content" name="Content" value="" autofocus /></div>
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
$controller = new \gratz\BaseController($model);
$view = new \gratz\AboutMeEditView($model, $controller);
$view->Generate();
