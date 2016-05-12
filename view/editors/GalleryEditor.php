
        function CreateGalleryItem(obj,is_new=false)
        {
            var fileInput = $('<input/>').attr('type','file').attr('name','dp[File][]').attr('accept', 'image').attr('style', 'width: 25em').hide();
            var div = $('<tr></tr>');
                $('<input/>').attr('type','hidden').attr('name','dp[ID][]').val(obj.ID).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','date').datepicker({ dateFormat: 'dd.mm.yy'}).attr('name','dp[Date][]').attr('pattern', '(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}').attr('maxlength', '10').attr('required', 'true').attr('style', 'width: 6em').val(obj.Date)).appendTo(div);
                $('<td></td>').append($('<input/>').attr('type','text').attr('name','dp[Title][]').attr('maxlength', '50').attr('required', 'true').attr('style', 'width: 15em').val(obj.Title)).appendTo(div);
                $('<td></td>').append(fileInput).appendTo(div);
            var changeImage = $('<input type="button" value="Change Image" onclick="return ShowUploadGalleryItem(this);" />');
                $('<td></td>').append(changeImage).appendTo(div);;
                div.append('<td><input type="button" value="Delete" onclick="return item_Delete(\'dpDelete[]\', this);" /></td>');
            div.appendTo($("#galleryItems"));
            
            if (is_new)
                ShowUploadGalleryItem(changeImage);
        }

        function LoadGallery()
        {
            EmptyTableAndCreateHeaders("#galleryItems", ["Date", "Title", ""]);
<?php
            foreach ($this->model->gallery->data as $item)
            {
                echo "            CreateGalleryItem(" . json_encode($item) . ");\n";
            }
?>
        }

        $("#cmdAddGaleryItem").click(function(){
            CreateGalleryItem({"ID":"","Date":"","Title":""}, true);
        });
