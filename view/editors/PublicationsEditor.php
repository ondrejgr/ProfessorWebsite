        function CreatePubTypeList(parent, value=-1)
        {
            var obj = $('<select></select>');
            obj.attr('name','dp[PubType][]').attr('required', 'true');
            obj.append($('<option></option>').val('1').text('Journal paper'));
            obj.append($('<option></option>').val('2').text('Conference paper'));
            obj.append($('<option></option>').val('3').text('Book chapter'));
            obj.append($('<option></option>').val('4').text('Book'));
            if (value != -1)
            {
                obj.val(value);
            }
            obj.appendTo(parent);
            return parent;
        }

        function CreatePublication(obj)
        {
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                CreatePubTypeList($('<td></td>'), obj.PubType).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','number').attr('name','dp[Year][]').attr('min', '1900').attr('max', '2100').attr('required', 'true').attr('style', 'width: 5em').val(obj.Year)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','number').attr('name','dp[Month][]').attr('min', '1').attr('max', '12').attr('required', 'true').attr('style', 'width: 5em').val(obj.Month)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Title][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Title)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Author][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Author)).appendTo(div);
                $('<div></div>').append($('<textarea></textarea>').attr('name','dp[Detail][]').attr('rows', '10').attr('cols', '70').text(obj.Detail)).appendTo(div);
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></td>');
            div.appendTo($("#publications"));
        }

        function LoadPublications()
        {
            EmptyTableAndCreateHeaders("#publications", ["Type", "Year", "Month", "Title", "Author", "Detail", ""]);
<?php
            foreach ($this->model->publications->data as $item)
            {
                echo "            CreatePublication(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddPublication").click(function(){
            CreatePublication({"ID":"","PubType":"","Year":"","Month":"","Title":"","Author":"","Detail":""});
        });
