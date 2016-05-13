<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/ResearchModel.php';
include 'controller/ResearchEditController.php';

class ResearchEditView extends BaseView 
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
                        <h3><?php echo $this->model->researchProjects->title ?></h3>
                        <div>
                            <div>
                                <table id="researchProjects">
                                </table>
                            </div>
                        </div>
                        <div>
                            <div><input id="cmdAddResearchProject" type="button" value="Add project"/></div>
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
        include "view/editors/ResearchProjectsEditor.php";
?>        
        function LoadData()
        {
            $("#deletedItems").empty();
            LoadResearchProjects();
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

$model = new \gratz\ResearchModel("Research", TRUE);
$controller = new \gratz\ResearchEditController($model);
$view = new \gratz\ResearchEditView($model, $controller);
$view->Generate(); 