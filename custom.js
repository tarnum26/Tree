$(".jqx-tree-item.jqx-item").live('mousedown', function(e) {
    if( (e.which == 1) ) {
        var parent = $(this).parent('.jqx-tree-item-li');
        var treeItem = tree.jqxTree('getItem', parent[0]);
        if (treeItem.isExpanded) {
            tree.jqxTree('collapseItem', parent[0]);
        }
        else {
            tree.jqxTree('expandItem', parent[0]);
        }
    }
    if( (e.which == 3) ) {
        var parent = $(this).parent('.jqx-tree-item-li');
        var items = $(parent).find('.jqx-tree-item-li');
//        console.log(items);
        tree.jqxTree('expandItem', parent[0]);
        $.each(items, function(i, item) {
            tree.jqxTree('expandItem', item);
        })
    }
    e.preventDefault();
}).live('contextmenu', function(e){
        e.preventDefault();
});
