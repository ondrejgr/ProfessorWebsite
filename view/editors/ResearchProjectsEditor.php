        function CreateResearchProject(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Title][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Title)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[ShortText][]').attr('maxlength', '150').attr('style', 'width: 15em').val(obj.ShortText)).appendTo(div);
                $('<td></td>').append($('<textarea></textarea>').attr('name','dp[Content][]').attr('rows', '10').attr('cols', '50').text(obj.Content)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></td>');
            div.appendTo($("#researchProjects"));
        }

        function LoadResearchProjects()
        {
            EmptyTableAndCreateHeaders("#researchProjects", ["Title", "Short Description", "Long Description", ""]);
<?php
            foreach ($this->model->researchProjects->data as $item)
            {
                echo "            CreateResearchProject(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddResearchProject").click(function(){
            CreateResearchProject({"ID":"","Title":"","ShortText":"","Content":""});
        });
