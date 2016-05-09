        function EmptyTableAndCreateHeaders(name, titles)
        {
            $(name).empty();
            var head = $('<thead></thead>');
            var div = $('<tr></tr>').appendTo(head);
            for (var i = 0; i < titles.length; i++) 
            {
                $('<th></th>').append($('<label></label>')).text(titles[i]).appendTo(div);
            }
            head.appendTo($(name));
        }
