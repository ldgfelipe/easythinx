@extends('layout.template')
@section('title', 'Welcome')

@section('content')

    <link rel="stylesheet" href="//unpkg.com/grapesjs/dist/css/grapes.min.css">
    <script src="//unpkg.com/grapesjs"></script>

    <link rel="stylesheet" href="stylesheets/toastr.min.css">
    <link rel="stylesheet" href="stylesheets/grapes.min.css?v0.20.1">
    <link rel="stylesheet" href="stylesheets/grapesjs-preset-webpage.min.css">
    <link rel="stylesheet" href="stylesheets/tooltip.css">
    <link rel="stylesheet" href="stylesheets/demos.css?v3">
    <link href="https://unpkg.com/grapick/dist/grapick.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage@1.0.2"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic@1.0.1"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms@2.0.5"></script>
    <script src="https://unpkg.com/grapesjs-component-countdown@1.0.1"></script>
    <script src="https://unpkg.com/grapesjs-plugin-export@1.0.11"></script>
    <script src="https://unpkg.com/grapesjs-tabs@1.0.6"></script>
    <script src="https://unpkg.com/grapesjs-custom-code@1.0.1"></script>
    <script src="https://unpkg.com/grapesjs-touch@0.1.1"></script>
    <script src="https://unpkg.com/grapesjs-parser-postcss@1.0.1"></script>
    <script src="https://unpkg.com/grapesjs-tooltip@0.1.7"></script>
    <script src="https://unpkg.com/grapesjs-tui-image-editor@0.1.3"></script>
    <script src="https://unpkg.com/grapesjs-typed@1.0.5"></script>
    <script src="https://unpkg.com/grapesjs-style-bg@1.0.5"></script>

    <style type="text/css">
        .icons-flex {
            background-size: 70% 65% !Important;
            height: 15px;
            width: 17px;
            opacity: 0.9;
        }

        .icon-dir-row {
            background: url("./img/flex-dir-row.png") no-repeat center;
        }

        .icon-dir-row-rev {
            background: url("./img/flex-dir-row-rev.png") no-repeat center;
        }

        .icon-dir-col {
            background: url("./img/flex-dir-col.png") no-repeat center;
        }

        .icon-dir-col-rev {
            background: url("./img/flex-dir-col-rev.png") no-repeat center;
        }

        .icon-just-start {
            background: url("./img/flex-just-start.png") no-repeat center;
        }

        .icon-just-end {
            background: url("./img/flex-just-end.png") no-repeat center;
        }

        .icon-just-sp-bet {
            background: url("./img/flex-just-sp-bet.png") no-repeat center;
        }

        .icon-just-sp-ar {
            background: url("./img/flex-just-sp-ar.png") no-repeat center;
        }

        .icon-just-sp-cent {
            background: url("./img/flex-just-sp-cent.png") no-repeat center;
        }

        .icon-al-start {
            background: url("./img/flex-al-start.png") no-repeat center;
        }

        .icon-al-end {
            background: url("./img/flex-al-end.png") no-repeat center;
        }

        .icon-al-str {
            background: url("./img/flex-al-str.png") no-repeat center;
        }

        .icon-al-center {
            background: url("./img/flex-al-center.png") no-repeat center;
        }

        [data-tooltip]::after {
            background: rgba(51, 51, 51, 0.9);
        }

        .gjs-pn-commands {
            min-height: 40px;
        }

        #gjs-sm-float {
            display: none;
        }

        .gjs-logo-version {
            background-color: #756467;
        }

        .gjs-pn-btn.gjs-pn-active {
            box-shadow: none;
        }

        .CodeMirror {
            min-height: 450px;
            margin-bottom: 8px;
        }

        .grp-handler-close {
            background-color: transparent;
            color: #ddd;
        }

        .grp-handler-cp-wrap {
            border-color: transparent;
        }
    </style>

    <div style="display: none">
        <div class="gjs-logo-cont">
            <a href="https://grapesjs.com"><img class="gjs-logo" src="img/grapesjs-logo-cl.png"></a>
            <div class="gjs-logo-version"></div>
        </div>
    </div>

    <div class="ad-cont">
        <!-- <script async type="text/javascript" src="//cdn.carbonads.com/carbon.js?zoneid=1673&serve=C6AILKT&placement=grapesjscom"
            id="_carbonads_js"></script> -->
        <div id="native-carbon"></div>
        <script async type="text/javascript" src="./js/carbon-v2.js"></script>
    </div>

    <div id="gjs" style="height:0px; overflow:hidden">

<?php
        if(isset($page)){
            echo $page->html;
        }
?>
    </div>

    <div id="info-panel" style="display:none">
        <br />
        <svg class="info-panel-logo" xmlns="https://www.w3.org/2000/svg" version="1">
            <g id="gjs-logo">
                <path
                    d="M40 5l-12.9 7.4 -12.9 7.4c-1.4 0.8-2.7 2.3-3.7 3.9 -0.9 1.6-1.5 3.5-1.5 5.1v14.9 14.9c0 1.7 0.6 3.5 1.5 5.1 0.9 1.6 2.2 3.1 3.7 3.9l12.9 7.4 12.9 7.4c1.4 0.8 3.3 1.2 5.2 1.2 1.9 0 3.8-0.4 5.2-1.2l12.9-7.4 12.9-7.4c1.4-0.8 2.7-2.2 3.7-3.9 0.9-1.6 1.5-3.5 1.5-5.1v-14.9 -12.7c0-4.6-3.8-6-6.8-4.2l-28 16.2"
                    style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-width:10;stroke:#fff" />
            </g>
        </svg>
        <br />
        <div class="info-panel-label">
            <b>GrapesJS Webpage Builder</b> is a simple showcase of what is possible to achieve with the
            <a class="info-panel-link gjs-four-color" target="_blank"
                href="https://github.com/artf/grapesjs">GrapesJS</a>
            core library
            <br /><br />
            For any hint about the demo check the
            <a class="info-panel-link gjs-four-color" target="_blank"
                href="https://github.com/artf/grapesjs-preset-webpage">Webpage Preset repository</a>
            and open an issue. For problems with the builder itself, open an issue on the main
            <a class="info-panel-link gjs-four-color" target="_blank" href="https://github.com/artf/grapesjs">GrapesJS
                repository</a>
            <br /><br />
            Being a free and open source project contributors and supporters are extremely welcome.
            If you like the project support it with a donation of your choice or become a backer/sponsor via
            <a class="info-panel-link gjs-four-color" target="_blank" href="https://opencollective.com/grapesjs">Open
                Collective</a>
        </div>
    </div>

    <script type="text/javascript">
    localStorage.clear()

        var lp = './img/';
        var plp = 'https://via.placeholder.com/350x250/';
        var images = [
            lp + 'team1.jpg', lp + 'team2.jpg', lp + 'team3.jpg', plp + '78c5d6/fff/image1.jpg', plp +
            '459ba8/fff/image2.jpg', plp + '79c267/fff/image3.jpg',
            plp + 'c5d647/fff/image4.jpg', plp + 'f28c33/fff/image5.jpg', plp + 'e868a2/fff/image6.jpg', plp +
            'cc4360/fff/image7.jpg',
            lp + 'work-desk.jpg', lp + 'phone-app.png', lp + 'bg-gr-v.png'
        ];




        var idpagina='<?php
                    $idpage="";
                                    if(isset($_REQUEST['idpage']) and $_REQUEST['idpage']!=NULL){
                                            $idpage=$_REQUEST['idpage'];
                                        }else{
                                            $idpage=0;
                                        }
                                    echo $idpage;
                            ?>';


        var visitas="<?php
        $visitas=0;
        if(isset($_REQUEST['idpage']) and $_REQUEST['idpage']!=NULL){
            $visitas=$page->visitas ? $page->visitas : 0;
        }
                echo $visitas;
        ?>";
        var editor = grapesjs.init({
            height: '100%',
            container: '#gjs',
            fromElement: true,
            showOffsets: true,
            assetManager: {
                embedAsBase64: true,
                assets: images
            },
            selectorManager: {
                componentFirst: true
            },
            styleManager: {
                sectors: [{
                    name: 'General',
                    properties: [{
                            extend: 'float',
                            type: 'radio',
                            default: 'none',
                            options: [{
                                    value: 'none',
                                    className: 'fa fa-times'
                                },
                                {
                                    value: 'left',
                                    className: 'fa fa-align-left'
                                },
                                {
                                    value: 'right',
                                    className: 'fa fa-align-right'
                                }
                            ],
                        },
                        'display',
                        {
                            extend: 'position',
                            type: 'select'
                        },
                        'top',
                        'right',
                        'left',
                        'bottom',
                    ],
                }, {
                    name: 'Dimension',
                    open: false,
                    properties: [
                        'width',
                        {
                            id: 'flex-width',
                            type: 'integer',
                            name: 'Width',
                            units: ['px', '%'],
                            property: 'flex-basis',
                            toRequire: 1,
                        },
                        'height',
                        'max-width',
                        'min-height',
                        'margin',
                        'padding'
                    ],
                }, {
                    name: 'Typography',
                    open: false,
                    properties: [
                        'font-family',
                        'font-size',
                        'font-weight',
                        'letter-spacing',
                        'color',
                        'line-height',
                        {
                            extend: 'text-align',
                            options: [{
                                    id: 'left',
                                    label: 'Left',
                                    className: 'fa fa-align-left'
                                },
                                {
                                    id: 'center',
                                    label: 'Center',
                                    className: 'fa fa-align-center'
                                },
                                {
                                    id: 'right',
                                    label: 'Right',
                                    className: 'fa fa-align-right'
                                },
                                {
                                    id: 'justify',
                                    label: 'Justify',
                                    className: 'fa fa-align-justify'
                                }
                            ],
                        },
                        {
                            property: 'text-decoration',
                            type: 'radio',
                            default: 'none',
                            options: [{
                                    id: 'none',
                                    label: 'None',
                                    className: 'fa fa-times'
                                },
                                {
                                    id: 'underline',
                                    label: 'underline',
                                    className: 'fa fa-underline'
                                },
                                {
                                    id: 'line-through',
                                    label: 'Line-through',
                                    className: 'fa fa-strikethrough'
                                }
                            ],
                        },
                        'text-shadow'
                    ],
                }, {
                    name: 'Decorations',
                    open: false,
                    properties: [
                        'opacity',
                        'border-radius',
                        'border',
                        'box-shadow',
                        'background', // { id: 'background-bg', property: 'background', type: 'bg' }
                    ],
                }, {
                    name: 'Extra',
                    open: false,
                    buildProps: [
                        'transition',
                        'perspective',
                        'transform'
                    ],
                }, {
                    name: 'Flex',
                    open: false,
                    properties: [{
                        name: 'Flex Container',
                        property: 'display',
                        type: 'select',
                        defaults: 'block',
                        list: [{
                                value: 'block',
                                name: 'Disable'
                            },
                            {
                                value: 'flex',
                                name: 'Enable'
                            }
                        ],
                    }, {
                        name: 'Flex Parent',
                        property: 'label-parent-flex',
                        type: 'integer',
                    }, {
                        name: 'Direction',
                        property: 'flex-direction',
                        type: 'radio',
                        defaults: 'row',
                        list: [{
                            value: 'row',
                            name: 'Row',
                            className: 'icons-flex icon-dir-row',
                            title: 'Row',
                        }, {
                            value: 'row-reverse',
                            name: 'Row reverse',
                            className: 'icons-flex icon-dir-row-rev',
                            title: 'Row reverse',
                        }, {
                            value: 'column',
                            name: 'Column',
                            title: 'Column',
                            className: 'icons-flex icon-dir-col',
                        }, {
                            value: 'column-reverse',
                            name: 'Column reverse',
                            title: 'Column reverse',
                            className: 'icons-flex icon-dir-col-rev',
                        }],
                    }, {
                        name: 'Justify',
                        property: 'justify-content',
                        type: 'radio',
                        defaults: 'flex-start',
                        list: [{
                            value: 'flex-start',
                            className: 'icons-flex icon-just-start',
                            title: 'Start',
                        }, {
                            value: 'flex-end',
                            title: 'End',
                            className: 'icons-flex icon-just-end',
                        }, {
                            value: 'space-between',
                            title: 'Space between',
                            className: 'icons-flex icon-just-sp-bet',
                        }, {
                            value: 'space-around',
                            title: 'Space around',
                            className: 'icons-flex icon-just-sp-ar',
                        }, {
                            value: 'center',
                            title: 'Center',
                            className: 'icons-flex icon-just-sp-cent',
                        }],
                    }, {
                        name: 'Align',
                        property: 'align-items',
                        type: 'radio',
                        defaults: 'center',
                        list: [{
                            value: 'flex-start',
                            title: 'Start',
                            className: 'icons-flex icon-al-start',
                        }, {
                            value: 'flex-end',
                            title: 'End',
                            className: 'icons-flex icon-al-end',
                        }, {
                            value: 'stretch',
                            title: 'Stretch',
                            className: 'icons-flex icon-al-str',
                        }, {
                            value: 'center',
                            title: 'Center',
                            className: 'icons-flex icon-al-center',
                        }],
                    }, {
                        name: 'Flex Children',
                        property: 'label-parent-flex',
                        type: 'integer',
                    }, {
                        name: 'Order',
                        property: 'order',
                        type: 'integer',
                        defaults: 0,
                        min: 0
                    }, {
                        name: 'Flex',
                        property: 'flex',
                        type: 'composite',
                        properties: [{
                            name: 'Grow',
                            property: 'flex-grow',
                            type: 'integer',
                            defaults: 0,
                            min: 0
                        }, {
                            name: 'Shrink',
                            property: 'flex-shrink',
                            type: 'integer',
                            defaults: 0,
                            min: 0
                        }, {
                            name: 'Basis',
                            property: 'flex-basis',
                            type: 'integer',
                            units: ['px', '%', ''],
                            unit: '',
                            defaults: 'auto',
                        }],
                    }, {
                        name: 'Align',
                        property: 'align-self',
                        type: 'radio',
                        defaults: 'auto',
                        list: [{
                            value: 'auto',
                            name: 'Auto',
                        }, {
                            value: 'flex-start',
                            title: 'Start',
                            className: 'icons-flex icon-al-start',
                        }, {
                            value: 'flex-end',
                            title: 'End',
                            className: 'icons-flex icon-al-end',
                        }, {
                            value: 'stretch',
                            title: 'Stretch',
                            className: 'icons-flex icon-al-str',
                        }, {
                            value: 'center',
                            title: 'Center',
                            className: 'icons-flex icon-al-center',
                        }],
                    }]
                }],
            },
            plugins: [
                'gjs-blocks-basic',
                'grapesjs-plugin-forms',
                'grapesjs-component-countdown',
                'grapesjs-plugin-export',
                'grapesjs-tabs',
                'grapesjs-custom-code',
                'grapesjs-touch',
                'grapesjs-parser-postcss',
                'grapesjs-tooltip',
                'grapesjs-tui-image-editor',
                'grapesjs-typed',
                'grapesjs-style-bg',
                'grapesjs-preset-webpage',
            ],
            pluginsOpts: {
                'gjs-blocks-basic': {
                    flexGrid: true
                },
                'grapesjs-tui-image-editor': {
                    script: [
                        // 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.7/fabric.min.js',
                        'https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js',
                        'https://uicdn.toast.com/tui-color-picker/v2.2.7/tui-color-picker.min.js',
                        'https://uicdn.toast.com/tui-image-editor/v3.15.2/tui-image-editor.min.js'
                    ],
                    style: [
                        'https://uicdn.toast.com/tui-color-picker/v2.2.7/tui-color-picker.min.css',
                        'https://uicdn.toast.com/tui-image-editor/v3.15.2/tui-image-editor.min.css',
                    ],
                },
                'grapesjs-tabs': {
                    tabsBlock: {
                        category: 'Extra'
                    }
                },
                'grapesjs-typed': {
                    block: {
                        category: 'Extra',
                        content: {
                            type: 'typed',
                            'type-speed': 40,
                            strings: [
                                'Text row one',
                                'Text row two',
                                'Text row three',
                            ],
                        }
                    }
                },
                'grapesjs-preset-webpage': {
                    modalImportTitle: 'Import Template',
                    modalImportLabel: '<div style="margin-bottom: 10px; font-size: 13px;">Paste here your HTML/CSS and click Import</div>',
                    modalImportContent: function(editor) {
                        return editor.getHtml() + '<style>' + editor.getCss() + '</style>'
                    },
                },

            },
        });

        editor.I18n.addMessages({
            en: {
                styleManager: {
                    properties: {
                        'background-repeat': 'Repeat',
                        'background-position': 'Position',
                        'background-attachment': 'Attachment',
                        'background-size': 'Size',
                    }
                },
            }
        });

        var pn = editor.Panels;
        var modal = editor.Modal;
        var cmdm = editor.Commands;


        cmdm.add('savepage',function(){


           modal.setTitle('Guardando Plantilla');
            modal.setContent(`
            <label style="color:#fff;">Nombre de la pagina</label>
            <input type='text' id='nombrepage'  style="background-color:#fff; width:100%; " oninput='generaurl()' /><br /><br />
            <label style="color:#fff;">tags de busqueda</label>
            <input type='text' id='metatags' placeholder='tags de busqueda' style="background-color:#fff; width:100%; " /><br /><br />

            <label style="color:#fff;"> Url de pagina</label>
            <input type='text' id='url' placeholder='tags de busqueda' style="background-color:#fff; width:100%; " /><br /><br />


            <label style="color:#fff;">Estado de Pagina</label>
            <select id='status' style="background-color:#fff; width:100%; " >
                <option value='0'>Borrador</option>
                <option value='1'>Publicado</option>
                </select><br /><br />


            <div class='btn btn-primary' id='btnguardar' onclick='GuardaPlantilla()'>Guardar</div>
            <div style='display:none;' id='guardando'>Guardando espere un momento</div>

                `);
            modal.open();
            <?php
        if(isset($page) and $page->id!=NULL){
?>
         $('#nombrepage').val('<?php  echo $page->nombrepage; ?>');
         $('#metatags').val('<?php  echo $page->metatags; ?>');
         $('#status').val('<?php  echo $page->status; ?>');
         $('#url').val('<?php  echo $page->url; ?>');
  <?php
                }
        ?>
        });

        function generaurl(){
            $('#url').val($('#nombrepage').val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, ''));
        }

        function GuardaPlantilla(){
            $('#btnguardar').css('display','none');
            $('#guardando').css('display','block');
            var payload={
                    html:editor.getHtml()+'<style>'+editor.getCss()+'</style>',
                    nombrepage:$('#nombrepage').val(),
                    metatags:$('#metatags').val(),
                    status:$('#status').val(),
                    url:$('#url').val(),
                    visitas:visitas,
                    idpage:idpagina,
                    action:'<?php
                        $action="";
                        if(isset($_REQUEST['idpage']) and $_REQUEST['idpage']!=NULL){
                                            $action="update";
                                        }else{
                                            $action="create";
                                        }
                                    echo $action;
                                ?>'
                            }

            ///// inicia guardando información con fetch

            fetch('<?php echo env('APP_URL'); ?>guardaplantilla',{
                method:'POST',
                headers:{
                    'Content-type':'application/json',
                    'X-CSRF-TOKEN': "<?php echo csrf_token(); ?>",
                },
                body:JSON.stringify(payload)
            })
            .then(res=>res.json())
            .then((res)=>{
                if(payload.action==='create'){
                    modal.setContent(`Plantilla Guardada id generado ${res.id}`);
                    idpagina=res.id

                }
                if(payload.action==='update'){
                    modal.setContent(`Plantilla Actuzalizada`);
                }

                setTimeout(()=>{
                    modal.close();
                    localStorage.clear()
                    window.location.href="<?php echo env('APP_URL'); ?>webbuilder"
                },1000)

            })

        }

        pn.addButton('options',{
            id: 'savepage',
            className: 'fa fa-floppy-o',
            command: function() {
                editor.runCommand('savepage')
            },
            attributes: {
                'title': 'Guardar',
                'data-tooltip-pos': 'bottom',
            },
        });


        // Update canvas-clear command
        cmdm.add('canvas-clear', function() {
            if (confirm('¿Seguro que desea limpiar el area de trabajo?')) {
                editor.runCommand('core:canvas-clear')
                setTimeout(function() {
                    localStorage.clear()
                }, 0)
            }
        });




        // Add info command
        var mdlClass = 'gjs-mdl-dialog-sm';
        var infoContainer = document.getElementById('info-panel');

        cmdm.add('open-info', function() {
            var mdlDialog = document.querySelector('.gjs-mdl-dialog');
            mdlDialog.className += ' ' + mdlClass;
            infoContainer.style.display = 'block';
            modal.setTitle('About this demo');
            modal.setContent(infoContainer);
            modal.open();
            modal.getModel().once('change:open', function() {
                mdlDialog.className = mdlDialog.className.replace(mdlClass, '');
            })
        });

        pn.addButton('options', {
            id: 'open-info',
            className: 'fa fa-question-circle',
            command: function() {
                editor.runCommand('open-info')
            },
            attributes: {
                'title': 'About',
                'data-tooltip-pos': 'bottom',
            },
        });

        cmdm.add('closepage',function(){

            if(confirm('¿Desea salir del editor?')){
                window.location.href="<?php echo env('APP_URL'); ?>webbuilder"
            }
        })

        pn.addButton('options',{
            id: 'closepage',
            className: 'fa fa-times',
            command: function() {
                editor.runCommand('closepage')
            },
            attributes: {
                'title': 'Cerrar Editor',
                'data-tooltip-pos': 'bottom',
            },
        })


        // Simple warn notifier
        var origWarn = console.warn;
        toastr.options = {
            closeButton: true,
            preventDuplicates: true,
            showDuration: 250,
            hideDuration: 150
        };
        console.warn = function(msg) {
            if (msg.indexOf('[undefined]') == -1) {
                toastr.warning(msg);
            }
            origWarn(msg);
        };


        // Add and beautify tooltips
        [
            ['sw-visibility', 'Show Borders'],
            ['preview', 'Preview'],
            ['fullscreen', 'Fullscreen'],
            ['export-template', 'Export'],
            ['undo', 'Undo'],
            ['redo', 'Redo'],
            ['gjs-open-import-webpage', 'Import'],
            ['canvas-clear', 'Clear canvas'],
            ['savepage','Save']
            ['closepage','Close Page']

        ]
        .forEach(function(item) {
            pn.getButton('options', item[0]).set('attributes', {
                title: item[1],
                'data-tooltip-pos': 'bottom'
            });
        });
        [
            ['open-sm', 'Style Manager'],
            ['open-layers', 'Layers'],
            ['open-blocks', 'Blocks']
        ]
        .forEach(function(item) {
            pn.getButton('views', item[0]).set('attributes', {
                title: item[1],
                'data-tooltip-pos': 'bottom'
            });
        });
        var titles = document.querySelectorAll('*[title]');

        for (var i = 0; i < titles.length; i++) {
            var el = titles[i];
            var title = el.getAttribute('title');
            title = title ? title.trim() : '';
            if (!title)
                break;
            el.setAttribute('data-tooltip', title);
            el.setAttribute('title', '');
        }


        // Store and load events
        editor.on('storage:load', function(e) {
            console.log('Loaded ', e)
        });
        editor.on('storage:store', function(e) {
            console.log('Stored ', e)
        });


        // Do stuff on load
        editor.on('load', function() {
            var $ = grapesjs.$;

            // Show borders by default
            pn.getButton('options', 'sw-visibility').set('active', 1);

            // Show logo with the version
            var logoCont = document.querySelector('.gjs-logo-cont');
            document.querySelector('.gjs-logo-version').innerHTML = 'v' + grapesjs.version;
            var logoPanel = document.querySelector('.gjs-pn-commands');
            logoPanel.appendChild(logoCont);


            // Load and show settings and style manager
            var openTmBtn = pn.getButton('views', 'open-tm');
            openTmBtn && openTmBtn.set('active', 1);
            var openSm = pn.getButton('views', 'open-sm');
            openSm && openSm.set('active', 1);

            // Remove trait view
            pn.removeButton('views', 'open-tm');

            // Add Settings Sector
            var traitsSector = $('<div class="gjs-sm-sector no-select">' +
                '<div class="gjs-sm-sector-title"><span class="icon-settings fa fa-cog"></span> <span class="gjs-sm-sector-label">Settings</span></div>' +
                '<div class="gjs-sm-properties" style="display: none;"></div></div>');
            var traitsProps = traitsSector.find('.gjs-sm-properties');
            traitsProps.append($('.gjs-trt-traits'));
            $('.gjs-sm-sectors').before(traitsSector);
            traitsSector.find('.gjs-sm-sector-title').on('click', function() {
                var traitStyle = traitsProps.get(0).style;
                var hidden = traitStyle.display == 'none';
                if (hidden) {
                    traitStyle.display = 'block';
                } else {
                    traitStyle.display = 'none';
                }
            });

            // Open block manager
            var openBlocksBtn = editor.Panels.getButton('views', 'open-blocks');
            openBlocksBtn && openBlocksBtn.set('active', 1);

            // Move Ad
            $('#gjs').append($('.ad-cont'));
        });

    </script>


@endsection()
