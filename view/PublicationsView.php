<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/PublicationsModel.php';

class PublicationsView extends BaseView 
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
                            fileName = div.find("div[data-prop-name='Detail']");
                            if (fileName)
                            {
                                fileName.toggle();
                            }
                        }             
            }
        </script>
<?php
    }
    
    private function RenderFilterForm()
    {
?>
                    <div class="form">
                        <div>
                            <div>
                                <label>Types:</label>
                            </div>
                            <div>
                                <select id="PubTypeFilter" value="0">
                                    <option value="0">All Types</option>
                                    <option value="1">Journal paper</option>
                                    <option value="2">Conference paper</option>
                                    <option value="3">Book chapter</option>
                                    <option value="4">Book</option>
                                </select>
                            </div>
                        </div>
                    </div>
<?php        
    }
    
    protected function OnGenerateContent()
    {
        $this->ShowContentJS();
        $this->RenderContent();
        $this->RenderFilterForm();
?>
                <div class="publications-collections" id="publications">
<?php
        $this->RenderCollection($this->model->publications);
?>
                </div>
<?php
    }
    
    protected function RenderCollectionItem($item)
    {
        foreach ($item as $name => $value)
        {
            if ($name == "Title" || $name == "Author")
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
    
    protected function OnGenerateScript()
    {
?>
        $("#PubTypeFilter").change(function(){
        
            var pubs = $('#publications');
            var allItems = pubs.find("div[data-prop-name='PubType']");
            if ($("#PubTypeFilter").val() == 0)
            {
                allItems.parent().show();
            }
            else
            {
                allItems.parent().hide();
                filteredItems = pubs.find("div[data-prop-name='PubType']:contains('" + $("#PubTypeFilter").val() + "')");
                filteredItems.parent().show();
            }
        });
<?php
    }

}

$model = new \gratz\PublicationsModel("Publications");
$controller = new \gratz\BaseController($model);
$view = new \gratz\PublicationsView($model, $controller);
$view->Generate();
