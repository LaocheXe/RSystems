    $(document).ready(function(){
      refreshTable();
    });

    function refreshTable(){
        $('#tableHolder').load('/e107_plugins/roster/roster_shortcodes.php', function(){
           setTimeout(refreshTable, 1000);
        });
    };