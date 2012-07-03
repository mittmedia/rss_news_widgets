@RssNewsWidgets =
  add_delete_events: ->
    jQuery( '.delete_action' ).on 'click', ->

      for object_name in jQuery(@).attr("data-id").split(',')
        hidden_input = jQuery( "<input type='hidden' name='#{object_name}' />" )
        jQuery( 'form' ).append( hidden_input )

      element_class = jQuery( @ ).parent().parent().attr( 'class' )
      class_to_hide_array = element_class.split( ' ' )
      class_to_hide = class_to_hide_array[1]
      jQuery( ".#{class_to_hide}" ).css( 'background', '#ffebe8' )
      jQuery( ".#{class_to_hide}_rss_link" ).css( 'background', '#ffebe8' )
      jQuery( ".#{class_to_hide}" ).fadeOut( 'slow' )
      jQuery( ".#{class_to_hide}_rss_link" ).fadeOut( 'slow' )
      jQuery( ".spacer:first" ).fadeOut 'slow', () ->
        jQuery( ".spacer:first" ).remove()
      return
    return

jQuery =>
  @RssNewsWidgets.add_delete_events()
  return
