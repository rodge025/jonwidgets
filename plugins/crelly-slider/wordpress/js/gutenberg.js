var el = wp.element.createElement;
var registerBlockType = wp.blocks.registerBlockType;

var sliders = null;
var options = null;

registerBlockType( 'crelly-slider/select-slider', {
    title: 'Crelly Slider',
    icon: 'universal-access-alt',
    category: 'layout',
    attributes: {
        sliderAlias: {
            type: 'string'
        }
    },

    edit: function (props) {
        if(sliders == null) {
            jQuery.ajax({
                type : 'POST',
                url : ajaxurl,
                async: false,
                data : {
                    action: 'crellyslider_getSlidersList',
                },
                success: function(response) {                    
                    sliders = JSON.parse(response);

                    var attributes = props.attributes;
                    var savedAlias = attributes.sliderAlias;
            
                    options = [];
                    for(var i = 0; i < sliders.length; i++) {
                        var s = sliders[i];
                        if(s['alias'] == savedAlias) {
                            o = el('option', {value: s['alias'], selected:true}, s['name']);
                        }
                        else {
                            o = el('option', {value: s['alias']}, s['name']);
                        }
                        options.push(o);
                    }
                },

                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Cannot request sliders list');
                    console.log(XMLHttpRequest.responseText);
                }
            });
        }
        
        console.log("edit")
        console.log(props);
        return el(
            'select',
            {
                className: props.className,
                onChange: function(event) {
                    var alias = event.target.value;
                    if(alias == 'crellyslider-no-slider') {
                        alias = null;
                    }
                    props.setAttributes({
                        sliderAlias: alias
                    });
                }
            },
            el('option', {value: 'crellyslider-no-slider'}, crellyslider_translations.select_slider),
            options
        );
    },

    save: function(props) {
        var attributes = props.attributes;
        var alias = attributes.sliderAlias;
        console.log(props);
        return el('div', {className: props.className + 'crellyslider-block-slider-' + alias}, '[crellyslider alias="' + alias + '"]');
    },
});