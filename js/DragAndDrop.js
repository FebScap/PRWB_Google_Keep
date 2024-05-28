$( function() {
    var prevParent;
    var item = null;
    var replacedItem = null;
    $( "#pinnedNotes, #otherNotes" ).sortable({
        connectWith: ".connectedSortable",
        start: function(event, ui) {
            prevParent = ui.item.parent()[0].id;
        },
        update: function(event, ui) {
            item = ui.item.attr('id');
            replacedItem = ui.item.prev().attr('id');
        },
        stop: function(event, ui) {
            var pinnedOrUnpinned = prevParent !== ui.item.parent()[0].id;
            if (item != null) {
                if (replacedItem === undefined) replacedItem = -1;
                $.ajax({
                    type: "POST",
                    url: "viewNotes/dragNote",
                    data: {
                        itemId: item,
                        replacedItemId: replacedItem,
                        hasChanged: pinnedOrUnpinned
                    },
                    success: function () {
                        console.log('succesfully sended ')
                    },
                    error: function (xhr, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }
            console.log('Pin unpin ? ' + pinnedOrUnpinned);
            console.log("item : " + item);
            console.log("itemreplaced: "+ replacedItem);
        }
    }).disableSelection();
} );