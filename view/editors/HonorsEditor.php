        function CreateHonor(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','ho[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','ho[Date][]').attr('maxlength', '30').attr('required', 'true').attr('style', 'width: 6em').val(obj.Date)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','ho[Title][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Title)).appendTo(div);
                $('<td></td>').append($('<textarea></textarea>').attr('name','ho[Detail][]').attr('maxlength', '250').attr('cols', '60').attr('rows', '4').text(obj.Detail)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'hoDelete[]\', this);" /></td>');
            div.appendTo($("#honors"));
        }

        function LoadHonors()
        {
            EmptyTableAndCreateHeaders("#honors", ["Date", "Title", "Detail", ""]);
<?php
            foreach ($this->model->honors->data as $item)
            {
                echo "            CreateHonor(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddHonor").click(function(){
            CreateHonor({"ID":"","Date":"","Title":"","Detail":""});
        });
