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
        <div>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-3.jpg" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-3.jpg" alt=""/></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-4.jpg" data-lightbox="example-set" data-title="Or press the right arrow on your keyboard."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-4.jpg" alt="" /></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-5.jpg" data-lightbox="example-set" data-title="The next image in the set is preloaded as you're viewing."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-5.jpg" alt="" /></a>
      <a class="example-image-link" href="http://lokeshdhakar.com/projects/lightbox2/images/image-6.jpg" data-lightbox="example-set" data-title="Click anywhere outside the image or the X to the right to close."><img class="example-image" src="http://lokeshdhakar.com/projects/lightbox2/images/thumb-6.jpg" alt="" /></a>         
        </div>
        <script src="js/lightbox-plus-jquery.min.js"></script>
<?php        
    }
}

$model = new \gratz\GalleryModel("Gallery");
$controller = new \gratz\BaseController($model);
$view = new \gratz\GalleryView($model, $controller);
$view->Generate();
