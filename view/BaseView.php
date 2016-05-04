<?php
namespace gratz;

include 'include/Database.php';
include 'model/BaseModel.php';
include 'controller/BaseController.php';

abstract class BaseView {
    protected $model;
    protected $controller;
    
    public function __construct($model, $controller) 
    {
        if (is_null($model) || !($model instanceof \gratz\BaseModel))
        {
            throw new \Exception("No valid model instance has been passed to view");
        }
        if (is_null($controller) || !($controller instanceof \gratz\BaseController))
        {
            throw new \Exception("No valid controller instance has been passed to view");
        }

        $this->model = $model;
        $this->controller = $controller;
    }
    
    public function Generate()
    { 
?>
<!DOCTYPE html>

<html <?php echo "lang=\"" . $this->model->lang . "\"" ?>>
    <head>
        <meta charset="UTF-8"/>
        <!--<meta name="viewport" content="width=device-width, initial-scale=1"/>-->

        <title><?php echo $this->model->getTitle() ?></title>
        
        <link rel="stylesheet" href="style/main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<?php 
    $this->GenerateHead();             
?>
    </head>
    <body>
<?php 
    $this->GenerateBody();             
?>
    </body>
</html>
<?php
    }
    
    private function GenerateHead()
    {
        try
        {
            $this->OnGenerateExtraHead();             
        } 
        catch (\GratzException $ex) 
        {
            $message = $ex->getMessage();
            echo "\n</head><body>\n        <p class=\"error\">$message.</p>\n";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            echo "\n</head><body>\n        <p class=\"error\">Internal server error occurred: $message.</p>\n";
        }
    }
    
    private function GenerateBody()
    {
        try
        {
            $this->GenerateHeader();
            $this->GenerateNav();
            $this->GenerateContent();
            $this->GenerateScript();
        } 
        catch (\GratzException $ex) 
        {
            $message = $ex->getMessage();
            echo "        <p class=\"error\">$message.</p>\n";
        }
        catch (\Exception $ex) 
        {
            $message = $ex->getMessage();
            echo "        <p class=\"error\">Internal server error occurred: $message.</p>\n";
        }
    }
    
    private function GenerateHeader()
    {
?>
        <header>
<?php
            $this->OnGenerateHeader();
?>
        </header>
<?php
    }
   
    private function GenerateNav()
    {
?>
        <nav>
<?php
                $this->OnGenerateNav();
?>                
        </nav>
<?php
    }

    private function GenerateContent()
    {
?>
        <main>
            <div id="content">
<?php
            $this->OnGenerateContent();
?>
            </div>
        </main>
<?php
    }
    
    private function GenerateScript()
    {
?>
        <script>
            $(document).ready(
    function()
    {
        var obj = $("nav").find("a[data-view-name='<?php echo $this->model->pageName ?>']");
        if (obj)
            obj.addClass("active-nav-item");
        
        return false;
    });
        </script>
<?php
    }
    
    protected function OnGenerateExtraHead()
    {
    }

    protected function OnGenerateHeader()
    {
?>
            <div id="portrait"></div>
            <div id="fullName"><?php echo $this->model->person->FullName ?></div>
            <div id="universityName"><?php echo $this->model->person->UniversityName . "|" . $this->model->person->FacultyName ?></div>
<?php
    }
    
    protected function OnGenerateNav()
    {
        foreach($this->model->navItems as $navItem)
        {
            echo "                <a href=\"$navItem->Url\" title=\"$navItem->Title\" data-view-name=\"$navItem->Name\">$navItem->Title</a>\n";
        }
    }
    
    protected function OnGenerateContent()
    {
?>
            <h1><?php echo $this->model->pageTitle ?></h1><hr/>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus et lorem id felis nonummy placerat. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Duis risus. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Proin mattis lacinia justo. Curabitur vitae diam non enim vestibulum interdum. Integer pellentesque quam vel velit. Curabitur vitae diam non enim vestibulum interdum. Praesent in mauris eu tortor porttitor accumsan. Proin in tellus sit amet nibh dignissim sagittis. Ut tempus purus at lorem. Nunc dapibus tortor vel mi dapibus sollicitudin. Etiam quis quam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Phasellus et lorem id felis nonummy placerat. Fusce tellus. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit. Nullam rhoncus aliquam metus.</p>

<p>Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla, et sollicitudin sem purus in lacus. Nullam sit amet magna in magna gravida vehicula. Nunc dapibus tortor vel mi dapibus sollicitudin. Maecenas libero. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut tempus purus at lorem. Curabitur vitae diam non enim vestibulum interdum. Maecenas libero. Mauris elementum mauris vitae tortor. Curabitur vitae diam non enim vestibulum interdum. Ut tempus purus at lorem. Nunc auctor. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Sed convallis magna eu sem. Maecenas lorem. Praesent id justo in neque elementum ultrices.</p>

<p>Aliquam in lorem sit amet leo accumsan lacinia. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla, et sollicitudin sem purus in lacus. Vivamus ac leo pretium faucibus. Praesent dapibus. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Phasellus et lorem id felis nonummy placerat. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Integer tempor. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Aliquam erat volutpat. Duis risus. In enim a arcu imperdiet malesuada. Vivamus ac leo pretium faucibus. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Etiam posuere lacus quis dolor. Curabitur sagittis hendrerit ante. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Integer imperdiet lectus quis justo. Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Proin mattis lacinia justo. Quisque tincidunt scelerisque libero. Duis pulvinar. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam.</p>

<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. In laoreet, magna id viverra tincidunt, sem odio bibendum justo, vel imperdiet sapien wisi sed libero. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nulla non arcu lacinia neque faucibus fringilla. Nam quis nulla. Mauris suscipit, ligula sit amet pharetra semper, nibh ante cursus purus, vel sagittis velit mauris vel metus. Pellentesque ipsum. In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Etiam commodo dui eget wisi. Aenean placerat. Nunc tincidunt ante vitae massa. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Nulla pulvinar eleifend sem. Aenean fermentum risus id tortor. In rutrum. Donec iaculis gravida nulla. Sed ac dolor sit amet purus malesuada congue. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Morbi imperdiet, mauris ac auctor dictum, nisl ligula egestas nulla, et sollicitudin sem purus in lacus.</p>

<p>Phasellus et lorem id felis nonummy placerat. In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Aliquam in lorem sit amet leo accumsan lacinia. Vivamus luctus egestas leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In rutrum. Aliquam erat volutpat. Proin mattis lacinia justo. Nunc auctor. Etiam quis quam. Duis viverra diam non justo. Duis condimentum augue id magna semper rutrum. In convallis. Fusce wisi.</p>

<p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Nulla pulvinar eleifend sem. Donec ipsum massa, ullamcorper in, auctor et, scelerisque sed, est. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Quisque tincidunt scelerisque libero. Fusce aliquam vestibulum ipsum. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Curabitur bibendum justo non orci. Nulla quis diam. Etiam commodo dui eget wisi. Maecenas ipsum velit, consectetuer eu lobortis ut, dictum at dui. Integer pellentesque quam vel velit. Pellentesque ipsum.</p>

<p>Etiam bibendum elit eget erat. Aliquam erat volutpat. Aliquam erat volutpat. Nullam rhoncus aliquam metus. Pellentesque arcu. Duis viverra diam non justo. Sed ac dolor sit amet purus malesuada congue. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Nullam sapien sem, ornare ac, nonummy non, lobortis a enim. Nullam sit amet magna in magna gravida vehicula. Pellentesque arcu. Pellentesque ipsum. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Nullam sapien sem, ornare ac, nonummy non, lobortis a enim. Nullam sit amet magna in magna gravida vehicula. Praesent vitae arcu tempor neque lacinia pretium. Curabitur vitae diam non enim vestibulum interdum. Maecenas lorem. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam.</p>

<p>Integer vulputate sem a nibh rutrum consequat. In rutrum. Cras pede libero, dapibus nec, pretium sit amet, tempor quis. Maecenas lorem. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Donec vitae arcu. Aliquam erat volutpat. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Nulla accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel leo. Pellentesque sapien. Nullam rhoncus aliquam metus. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Cras elementum.</p>

<p>Nullam rhoncus aliquam metus. Etiam posuere lacus quis dolor. Fusce aliquam vestibulum ipsum. Fusce tellus. Donec vitae arcu. Integer vulputate sem a nibh rutrum consequat. Pellentesque sapien. Nullam dapibus fermentum ipsum. Praesent in mauris eu tortor porttitor accumsan. Fusce wisi. Mauris metus. Mauris dolor felis, sagittis at, luctus sed, aliquam non, tellus. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Praesent vitae arcu tempor neque lacinia pretium. Mauris tincidunt sem sed arcu. Nam quis nulla. Integer vulputate sem a nibh rutrum consequat. Praesent id justo in neque elementum ultrices. Vivamus porttitor turpis ac leo.</p>

<?php
    }
}
