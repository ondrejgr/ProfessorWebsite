<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/TeachingModel.php';
include 'controller/TeachingEditController.php';

class TeachingEditView extends BaseView 
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
        include "view/editors/DeleteItemJS.php";
        $this->GenerateMessages();
?>
                <form method="POST" autocomplete="OFF" action="<?php echo $this->url ?>">
                    <div id="deletedItems">
                    </div>
                    <div class="form">
                        <h3>Content</h3>
                        <div>
                            <div><textarea id="Content" name="Content" cols="80" rows="10" autofocus><?php echo $content ?></textarea></div>
                        </div>
                    </div>
                    <div class="form">
                        <h3><?php echo $this->model->teaching->title ?></h3>
                        <div>
                            <div>
                                <table id="teaching">
                                </table>
                            </div>
                        </div>
                        <div>
                            <div><input id="cmdAddTeaching" type="button" value="Add lecture"/></div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="form_buttons">
                            <div>
                                <div><input type="submit" value="Save"/></div>
                                <div><input type="button" id="cmdView" value="View page"/></div>
                                <div><input id="cmdReset" type="button" value="Undo all"/></div>
                            </div>
                        </div>
                    </div>
                </form>
<?php
    }
 
    protected function OnGenerateScript()
    {
        include "view/editors/Common.php";
        include "view/editors/TeachingEditor.php";
?>        
        function LoadData()
        {
            $("#deletedItems").empty();
            LoadTeaching();
        }

        $("#cmdView").click(function(){
            window.open('?view=<?php echo $this->model->pageName ?>');
        });
        $("#cmdReset").click(function(){
            $(this).closest('form').trigger("reset");
            LoadData();
        });
        LoadData();
<?php
    }
}

$model = new \gratz\TeachingModel("Teaching", TRUE);
$controller = new \gratz\TeachingEditController($model);
$view = new \gratz\TeachingEditView($model, $controller);
$view->Generate(); 