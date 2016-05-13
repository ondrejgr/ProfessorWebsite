        function CreateTeaching(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Period][]').attr('maxlength', '30').attr('required', 'true').attr('style', 'width: 8em').val(obj.Period)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Title][]').attr('maxlength', '50').attr('style', 'width: 15em').val(obj.Title)).appendTo(div);
                $('<td></td>').append($('<textarea></textarea>').attr('name','dp[Detail][]').attr('rows', '10').attr('cols', '50').text(obj.Detail)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></td>');
            div.appendTo($("#teaching"));
        }

        function LoadTeaching()
        {
            EmptyTableAndCreateHeaders("#teaching", ["Period", "Title", "Detail", ""]);
<?php
            foreach ($this->model->teaching->data as $item)
            {
                echo "            CreateTeaching(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddTeaching").click(function(){
            CreateTeaching({"ID":"","Period":"","Title":"","Detail":""});
        });
