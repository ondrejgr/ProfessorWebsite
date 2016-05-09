<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/PersonModel.php';
include 'controller/PersonEditController.php';

class PersonEditView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        $this->is_admin_required = \TRUE;
        parent::__construct($model, $controller);
    }

    protected function OnGenerateContent()
    {
        $this->GenerateMessages();
?>
                <form method="POST" autocomplete="OFF" action="<?php echo $this->url ?>">
                    <div class="form">
                        <div>
                            <div><label for="FirstName">First Name</label></div>
                            <div><input type="text" id="FirstName" name="FirstName" maxlength="100" required value="<?php echo $this->model->FirstName ?>" style="width: 12em"/></div>
                        </div>
                        <div>
                            <div><label for="LastName">Last Name</label></div>
                            <div><input type="text" id="LastName" name="LastName" maxlength="100" value="<?php echo $this->model->LastName ?>" style="width: 12em"/></div>
                        </div>
                        <div>
                            <div><label for="Email">E-mail</label></div>
                            <div><input type="text" id="Email" name="Email" 
                                        pattern="<?php echo "^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" ?>" 
                                        maxlength="100" value="<?php echo $this->model->Email ?>" style="width: 20em"/></div>
                        </div>
                    </div>
                    <div class="form">
                        <div>
                            <div><label for="UniversityName">University</label></div>
                            <div><input type="text" id="UniversityName" name="UniversityName" maxlength="100" required value="<?php echo $this->model->UniversityName ?>" style="width: 25em"/></div>
                        </div>
                        <div>
                            <div><label for="FacultyName">Faculty</label></div>
                            <div><input type="text" id="FacultyName" name="FacultyName" maxlength="100" value="<?php echo $this->model->FacultyName ?>" style="width: 25em"/></div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="form_buttons">
                            <div>
                                <div><input type="submit" value="Save"/></div>
                                <div><input id="cmdReset" type="reset" value="Undo all"/></div>
                            </div>
                        </div>
                    </div>
                </form>
<?php
    }
}

$model = new \gratz\PersonModel("Person", TRUE);
$controller = new \gratz\PersonEditController($model);
$view = new \gratz\PersonEditView($model, $controller);
$view->Generate(); 