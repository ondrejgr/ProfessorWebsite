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

    protected function OnGenerateHead()
    {
?>
    <style>
        #academicPositions
        {
            display: table;
        }
        #academicPositions div
        {
            display: table-row;
        }
        #academicPositions div div
        {
            display: table-cell;
        }
    </style>
<?php
    }
    
    protected function OnGenerateContent()
    {
        $content = '';
        if (is_string($this->model->content) && strlen($this->model->content) > 0)
        {
            $content = $this->model->content;
        }
?>
                <script>
                    function item_Delete(name, obj)
                    {
                        var div = $(obj).parent().parent();
                        if (div)
                        {
                            div.find("input[name='" + name + "[][Delete]']").val(1);
                            div.hide();
                        }
                    }
                </script>
                <form method="POST">
                    <div>
                        <div><label accesskey="C" for="Content">Content:</label></div>
                    </div>
                    <div>
                        <div><textarea id="Content" name="Content" cols="80" rows="10" autofocus><?php echo $content ?></textarea></div>
                    </div>
                    <div>
                        <div><input id="addAcademicPositions" name="addAcademicPositions" type="button" value="Add academic position"/></div>
                    </div>
                    <div id="academicPositions">
                    </div>
                    <div>
                        <div><input type="submit" value="Save"/></div>
                        <div><input id="cmdReset" type="reset" value="Reset"/></div>
                    </div>
                </form>
<?php
    }
    
    protected function OnGenerateScript()
    {
?>
        function CreateAcademicPosition(id, period, position, place)
        {
            $("#academicPositions").append('<div>' +
                '<input type="hidden" name="dp[][Delete]" value="0" />' +
                '<input type="hidden" name="dp[][ID]" value="' + id.toString() + '" />' +
                '<div><input type="text" name="dp[][Period]" required maxlength="30" style="width: 6em" value="' + period + '" /></div>' +
                '<div><input type="text" name="dp[][Position]" maxlength="50" style="width: 15em" value="' + position + '" /></div>' +
                '<div><input type="text" name="dp[][Place]" maxlength="100" style="width: 25em" value="' + place + '" /></div>' +
                '<div><input type="button" value="Delete" onclick="return item_Delete(\'dp\', this);" /></div>' +
                '</div>');
        }

        function LoadAcademicPositions()
        {
            $("#academicPositions").empty();
            $("#academicPositions").append('<div>' +
                '<div><label>Period</label></div>' +
                '<div><label>Position</label></div>' +
                '<div><label>Place</label></div>' +
                '<div></div>' +
                '</div>');
            CreateAcademicPosition(-1, '', '', '');            
        }

        $("#addAcademicPositions").click(function(){
            CreateAcademicPosition(-1, '2015-2055', '', '');
        });

  
        


        $("#cmdReset").click(function(){
            LoadAcademicPositions();
        });
        LoadAcademicPositions();
<?php
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\AboutMeEditController($model);
$view = new \gratz\AboutMeEditView($model, $controller);
$view->Generate();
