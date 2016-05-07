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
                            id = div.find("input[name*='[ID][]']").val();
                            if (id && id > 0)
                            {
                                $('<input/>').attr('type','hidden').attr('name',name).val(id).appendTo($("#deletedItems"));
                            }
                            div.remove();
                        }
                    }
                </script>
<?php
                $this->GenerateMessages();
?>
                <form method="POST">
                    <div id="deletedItems" style="display: none;">
                    </div>
                    <div>
                        <div><label accesskey="C" for="Content">Content:</label></div>
                    </div>
                    <div>
                        <div><textarea id="Content" name="Content" cols="80" rows="10" autofocus><?php echo $content ?></textarea></div>
                    </div>
                    <div>
                        <div>
                            <input id="cmdAddAcademicPositions" type="button" value="Add academic position"/>
                        </div>
                    </div>
                    <div id="academicPositions">
                    </div>
                    <div>
                        <div><input type="submit" value="Save"/><input type="button" id="cmdView" value="View"/></div>
                        <div><input id="cmdReset" type="reset" value="Reset"/></div>
                    </div>
                </form>
<?php
    }
    
    private function GenerateAcademicPositionEditor()
    {
?>
        function CreateAcademicPosition(obj)
        {
            var div = $('<div></div');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                $('<div></div').append($('<input/>').attr('type','text').attr('name','dp[Period][]').attr('maxlength', '30').attr('required', 'true').attr('style', 'width: 6em').val(obj.Period)).appendTo(div);
                $('<div></div').append($('<input/>').attr('type','text').attr('name','dp[Position][]').attr('maxlength', '50').attr('style', 'width: 15em').val(obj.Position)).appendTo(div);
                $('<div></div').append($('<input/>').attr('type','text').attr('name','dp[Place][]').attr('maxlength', '100').attr('style', 'width: 25em').val(obj.Place)).appendTo(div);
                div.append('<div><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></div>');
            div.appendTo($("#academicPositions"));
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
<?php
            foreach ($this->model->academicPositions->data as $item)
            {
                echo "            CreateAcademicPosition(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddAcademicPositions").click(function(){
            CreateAcademicPosition({"ID":"","Period":"","Position":"","Place":""});
        });
<?php        
    }
    
    protected function OnGenerateScript()
    {
        $this->GenerateAcademicPositionEditor();
?>        
        function LoadData()
        {
            $("#deletedItems").empty();
            LoadAcademicPositions();
        }

        $("#cmdView").click(function(){
            window.open('?view=<?php echo $this->model->pageName ?>');
        });
        $("#cmdReset").click(function(){
            LoadData();
        });
        LoadData();
<?php
    }
}

$model = new \gratz\AboutMeModel("AboutMe");
$controller = new \gratz\AboutMeEditController($model);
$view = new \gratz\AboutMeEditView($model, $controller);
$view->Generate();
