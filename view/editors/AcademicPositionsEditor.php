        function CreateAcademicPosition(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Period][]').attr('maxlength', '30').attr('required', 'true').attr('style', 'width: 6em').val(obj.Period)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Position][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Position)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Place][]').attr('maxlength', '100').attr('style', 'width: 25em').val(obj.Place)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></td>');
            div.appendTo($("#academicPositions"));
        }

        function LoadAcademicPositions()
        {
            EmptyTableAndCreateHeaders("#academicPositions", ["Period", "Position", "Place", ""]);
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
