<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/PortraitModel.php';
include 'controller/PortraitEditController.php';

class PortraitEditView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        $this->is_admin_required = \TRUE;
        $this->do_not_cache = \TRUE;
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
        $this->GenerateMessages();
?>
                <form method="POST" autocomplete="OFF" action="<?php echo $this->url ?>" enctype="multipart/form-data">
                    <div class="form">
                        <div>
                            <div><label for="portraitSmall">Small portrait</label></div>
                            <div class="portraitSmall"><img src="img/portrait_small.png" alt="Small portrait" /></div>
                        </div>
                        <div>
                            <input type="file" id="portraitSmall" name="portraitSmall" accept="image/png" style="width: 25em" />
                        </div>
                    </div>
                    <div class="form">
                        <div>
                            <div><label for="portrait">Large portrait</label></div>
                            <div class="portrait"><img src="img/portrait.png" alt="Large portrait" /></div>
                        </div>
                        <div>
                            <input type="file" id="portrait" name="portrait" accept="image/png" style="width: 25em" />
                        </div>
                    </div>
                    <div class="form">
                        <div class="form_buttons">
                            <div>
                                <div><input type="submit" value="Save"/></div>
                                <div><input id="cmdReset" type="button" value="Undo all"/></div>
                            </div>
                        </div>
                    </div>
                </form>
<?php
    }
}

$model = new \gratz\PortraitModel("Portrait", TRUE);
$controller = new \gratz\PortraitEditController($model);
$view = new \gratz\PortraitEditView($model, $controller);
$view->Generate(); 