$( function() {
    console.log('test');
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
                $.ajax({
                    type: "POST",
                    url: "viewNotes/dragNote",
                    data: {
                        item: item,
                        replacedItem: replacedItem,
                        pinnedOrUnpinned: pinnedOrUnpinned
                    }
                });
            }
            console.log('Pin unpin ? ' + pinnedOrUnpinned);
            console.log("item : " + item);
            console.log("itemreplaced: "+ replacedItem);
        }
    }).disableSelection();
} );

$(document).ready(function() {
    var elems = document.querySelectorAll(".chevron");
    [].forEach.call(elems, function(el) {
        el.remove();
    });
});