/**
 * 
 */

( function( $ ) {

	// On document ready
	  $(function() {
          $("#title-filter-menu").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
                var zid_val = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
                var dataString = "z_id="+zid_val; /* STORE THAT TO A DATA STRING */

                $.ajax({ /* THEN THE AJAX CALL */
                  type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                  url: "vysledky-data.php", /* PAGE WHERE WE WILL PASS THE DATA */
                  data: dataString, /* THE DATA WE WILL BE PASSING */
                  success: function(result){ /* GET THE TO BE RETURNED DATA */
                    $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
                  }
                });

              });
	  });
    
function pageIsSelectmenuDialog( page ) {
    var isDialog = false,
        id = page && page.attr( "id" );
    $( ".filterable-select" ).each( function() {
        if ( $( this ).attr( "id" ) + "-dialog" === id ) {
            isDialog = true;
            return false;
        }
    });
    return isDialog;
}
$.mobile.document
    // Upon creation of the select menu, we want to make use of the fact that the ID of the
    // listview it generates starts with the ID of the select menu itself, plus the suffix "-menu".
    // We retrieve the listview and insert a search input before it.
    .on( "selectmenucreate", ".filterable-select", function( event ) {
        var input,
            selectmenu = $( event.target ),
            list = $( "#" + selectmenu.attr( "id" ) + "-menu" ),
            form = list.jqmData( "filter-form" );
        // We store the generated form in a variable attached to the popup so we avoid creating a
        // second form/input field when the listview is destroyed/rebuilt during a refresh.
        if ( !form ) {
            input = $( "<input data-type='search'></input>" );
            form = $( "<form></form>" ).append( input );
            input.textinput();
            list
                .before( form )
                .jqmData( "filter-form", form ) ;
            form.jqmData( "listview", list );
        }
        // Instantiate a filterable widget on the newly created selectmenu widget and indicate that
        // the generated input form element is to be used for the filtering.
        selectmenu
            .filterable({
                input: input,
                children: "> option[value]"
            })
            // Rebuild the custom select menu's list items to reflect the results of the filtering
            // done on the select menu.
            .on( "filterablefilter", function() {
                selectmenu.selectmenu( "refresh" );
            });
    })
    // The custom select list may show up as either a popup or a dialog, depending on how much
    // vertical room there is on the screen. If it shows up as a dialog, then the form containing
    // the filter input field must be transferred to the dialog so that the user can continue to
    // use it for filtering list items.
    .on( "pagecontainerbeforeshow", function( event, data ) {
        var listview, form;
        // We only handle the appearance of a dialog generated by a filterable selectmenu
        if ( !pageIsSelectmenuDialog( data.toPage ) ) {
            return;
        }
        listview = data.toPage.find( "ul" );
        form = listview.jqmData( "filter-form" );
        // Attach a reference to the listview as a data item to the dialog, because during the
        // pagecontainerhide handler below the selectmenu widget will already have returned the
        // listview to the popup, so we won't be able to find it inside the dialog with a selector.
        data.toPage.jqmData( "listview", listview );
        // Place the form before the listview in the dialog.
        listview.before( form );
    })
    // After the dialog is closed, the form containing the filter input is returned to the popup.
    .on( "pagecontainerhide", function( event, data ) {
        var listview, form;
        // We only handle the disappearance of a dialog generated by a filterable selectmenu
        if ( !pageIsSelectmenuDialog( data.toPage ) ) {
            return;
        }
        listview = data.prevPage.jqmData( "listview" ),
        form = listview.jqmData( "filter-form" );
        // Put the form back in the popup. It goes ahead of the listview.
        listview.before( form );
    })
    .on("title-filter-menu", function(event, data) {
        window.console.log("jsem tu");
        });
    
}

)( jQuery );
