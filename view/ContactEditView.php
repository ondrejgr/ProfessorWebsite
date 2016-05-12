<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/ContactModel.php';
include 'controller/ContactEditController.php';

class ContactEditView extends BaseView 
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
                        <div class="form_buttons">
                            <div>
                                <div><input type="submit" value="Save"/></div>
                                <div><input type="button" id="cmdView" value="View page"/></div>
                                <div><input id="cmdReset" type="button" value="Undo all"/></div>
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div>
                            <div>
                                <div><a href="index.php?view=PersonEdit" title="Edit personal information">Edit personal information</a></div>
                                <div><a href="index.php?view=PortraitEdit" title="Change profile pictures">Change profile pictures</a></div>
                            </div>
                        </div>
                    </div>
                </form>
<?php
    }
 
    protected function OnGenerateScript()
    {  
?>        
        function LoadData()
        {
 
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

$model = new \gratz\ContactModel("Contact", TRUE);
$controller = new \gratz\ContactEditController($model);
$view = new \gratz\ContactEditView($model, $controller);
$view->Generate(); 