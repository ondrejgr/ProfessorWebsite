        function CreateEducationTraining(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','et[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','et[Degree][]').attr('maxlength', '10').attr('required', 'true').attr('style', 'width: 6em').val(obj.Degree)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','number').attr('name','et[Year][]').attr('min', '1900').attr('max', '2100').attr('required', 'true').attr('style', 'width: 5em').val(obj.Year)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','et[Position][]').attr('maxlength', '50').attr('style', 'width: 15em').val(obj.Position)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','et[Place][]').attr('maxlength', '100').attr('style', 'width: 25em').val(obj.Place)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'etDelete[]\', this);" /></td>');
            div.appendTo($("#educationTraining"));
        }

        function LoadEducationTraining()
        {
            EmptyTableAndCreateHeaders("#educationTraining", ["Degree", "Year", "Position", "Place", ""]);
<?php
            foreach ($this->model->educationTraining->data as $item)
            {
                echo "            CreateEducationTraining(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddEducationTraining").click(function(){
            CreateEducationTraining({"ID":"","Degree":"","Year":"","Position":"","Place":""});
        });
