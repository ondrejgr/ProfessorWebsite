                <script>
                    function item_Delete(name, obj)
                    {
                        var div = $(obj).parent().parent();
                        if (div)
                        {
                            id = div.find("input[name*='[ID][]']").val();
                            if (id && id > 0)
                            {
                                $('<input/>').attr('type','hidden').attr('name',name).val(id).appendTo($("#deletedItems"));
                            }
                            div.remove();
                        }
                    }
                </script>
