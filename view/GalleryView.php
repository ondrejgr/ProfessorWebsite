<?php
namespace gratz;

include 'view/BaseView.php';
include 'model/GalleryModel.php';

class GalleryView extends BaseView 
{
    public function __construct($model, $controller) 
    {
        parent::__construct($model, $controller);
    }

    private function IncludeLightBox()
    {
?>
        <link rel="stylesheet" href="style/lightbox.min.css">

<?php
    }
    
    protected function OnGenerateHead() {
        $this->IncludeLightBox();
    }
    
    protected function OnGenerateContent()
    {
        $this->RenderContent();
?>
        <div class="image-collections">
<?php
        $this->RenderCollection($this->model->gallery);
?>
        </div>
        <script src="js/lightbox-plus-jquery.min.js"></script>
<?php        
    }
    
    protected function RenderCollection($collection)
    {
        if (!is_a($collection, '\Gratz\ItemsCollection'))
        {
            throw new \GratzException("Unable to render collection - invalid object type");
        }
?>
                    <section class="<?php echo (new \ReflectionClass($collection))->getShortName() ?>">
                        <div>
<?php
        foreach ($collection->data as $item)
        {
?>
                            
<?php
            $this->RenderCollectionItem($item);
?>

                            
<?php
        }
?>
                        </div>
                    </section>
<?php
    }
    
    protected function RenderCollectionItem($item)
    {
?>
        <a class="gallery-link" href="<?php echo "gallery/" . $item->FileName ?>" data-lightbox="example-set" 
           data-title="<?php echo $item->Date . " " . $item->Title ?>">
            <img class="gallery-item" src="<?php echo "gallery/thumbs/tb_" . $item->FileName ?>" alt="<?php echo $item->Title ?>"/>
        </a>
<?php
    }
}

$model = new \gratz\GalleryModel("Gallery");
$controller = new \gratz\BaseController($model);
$view = new \gratz\GalleryView($model, $controller);
$view->Generate();
