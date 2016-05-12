                <script>
                    function ShowUploadGalleryItem(obj)
                    {
                        var div = $(obj).parent().parent();
                        if (div)
                        {
                            fileName = div.find("input[name='dp[File][]']");
                            if (fileName)
                            {
                                fileName.attr("required", "true");
                                fileName.show();
                            }
                        }
                        $(obj).hide();
                    }
                </script>
