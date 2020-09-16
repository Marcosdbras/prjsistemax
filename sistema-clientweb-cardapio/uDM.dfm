object DM: TDM
  OldCreateOrder = False
  OnCreate = ServerMethodDataModuleCreate
  Encoding = esASCII
  Height = 235
  Width = 337
  object DWServerContext1: TDWServerContext
    IgnoreInvalidParams = False
    ContextList = <
      item
        DWParams = <>
        ContentType = 'text/html'
        ContextName = 'index'
        Routes = [crAll]
        ContextRules = dwcrindex
        IgnoreBaseHeader = False
      end
      item
        DWParams = <>
        ContentType = 'text/html'
        ContextName = 'ecardapio'
        Routes = [crAll]
        ContextRules = dwcrecardapio
        IgnoreBaseHeader = False
      end>
    BaseContext = 'www'
    RootContext = 'index'
    Left = 104
    Top = 48
  end
  object dwcrindex: TDWContextRules
    ContentType = 'text/html'
    MasterHtml.Strings = (
      '<!DOCTYPE html>'
      '<html lang="pt-br">'
      '<head>'
      '    <meta charset="utf-8">'
      
        '       <meta name="viewport" content="width=device-width, initia' +
        'l-scale=1">'
      #9'   '
      #9'   '
      
        #9'   <link href="https://fonts.googleapis.com/css?family=Raleway:' +
        '300,400,500,600,700" rel="stylesheet">'
      
        '                  <link href="https://fonts.googleapis.com/css?f' +
        'amily=Open+Sans:300,400,600,700" rel="stylesheet">'
      
        '                  <link href="https://fonts.googleapis.com/css?f' +
        'amily=Rochester" rel="stylesheet">'#9'   '
      #9'   '
      
        #9'   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com' +
        '/bootstrap/3.3.5/css/bootstrap.min.css">'
      
        '                   <link rel="stylesheet" href="https://maxcdn.b' +
        'ootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> '#9' ' +
        '  '
      
        #9'   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.' +
        '5.1/jquery.min.js"></script>'
      '</head>'
      '<body>'
      '       <p>Index...</p>'
      '</body>'
      '</html>')
    MasterHtmlTag = '$body'
    IncludeScriptsHtmlTag = '{%incscripts%}'
    Items = <>
    OnBeforeRenderer = dwcrindexBeforeRenderer
    Left = 208
    Top = 32
  end
  object dwcrecardapio: TDWContextRules
    ContentType = 'text/html'
    MasterHtml.Strings = (
      '<!DOCTYPE html>'
      '<html lang="en">'
      '<head>'
      '<meta charset="utf-8">'
      
        '<meta name="viewport" content="width=device-width, initial-scale' +
        '=1">'
      '<title>Bar do Billy</title>'
      '<meta name="description" content="">'
      '<meta name="author" content="">'
      ''
      '<!-- Favicons'
      '    ================================================== -->'
      
        '<link rel="shortcut icon" href="img/favicon.ico" type="image/x-i' +
        'con">'
      '<link rel="apple-touch-icon" href="img/apple-touch-icon.png">'
      
        '<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch' +
        '-icon-72x72.png">'
      
        '<link rel="apple-touch-icon" sizes="114x114" href="img/apple-tou' +
        'ch-icon-114x114.png">'
      ''
      '<!-- Bootstrap -->'
      
        '<link rel="stylesheet" type="text/css"  href="css/bootstrap.css"' +
        '>'
      
        '<link rel="stylesheet" type="text/css" href="fonts/font-awesome/' +
        'css/font-awesome.css">'
      ''
      '<!-- Stylesheet'
      '    ================================================== -->'
      '<link rel="stylesheet" type="text/css"  href="css/style.css">'
      
        '<link href="https://fonts.googleapis.com/css?family=Raleway:300,' +
        '400,500,600,700" rel="stylesheet">'
      
        '<link href="https://fonts.googleapis.com/css?family=Open+Sans:30' +
        '0,400,600,700" rel="stylesheet">'
      
        '<link href="https://fonts.googleapis.com/css?family=Rochester" r' +
        'el="stylesheet">'
      ''
      
        '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements' +
        ' and media queries -->'
      
        '<!-- WARNING: Respond.js doesn'#39't work if you view the page via f' +
        'ile:// -->'
      '<!--[if lt IE 9]>'
      
        '      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5s' +
        'hiv.min.js"></script>'
      
        '      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.' +
        'min.js"></script>'
      '    <![endif]-->'
      '</head>'
      
        '<body id="page-top" data-spy="scroll" data-target=".navbar-fixed' +
        '-top">'
      '<!-- Navigation'
      '    ==========================================-->'
      '<nav id="menu" class="navbar navbar-default navbar-fixed-top">'
      '  <div class="container"> '
      
        '    <!-- Brand and toggle get grouped for better mobile display ' +
        '-->'
      '    <div class="navbar-header">'
      
        '      <button type="button" class="navbar-toggle collapsed" data' +
        '-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> ' +
        '<span class="sr-only">Toggle navigation</span> <span class="icon' +
        '-bar"></span> <span class="icon-bar"></span> <span class="icon-b' +
        'ar"></span> </button>'
      '    </div>'
      '    '
      
        '    <!-- Collect the nav links, forms, and other content for tog' +
        'gling -->'
      
        '    <div class="collapse navbar-collapse" id="bs-example-navbar-' +
        'collapse-1">'
      '      <ul class="nav navbar-nav">'
      '        <li><a href="#aba1" class="page-scroll">PRATOS</a></li>'
      '        <li><a href="#aba2" class="page-scroll">ESPETOS</a></li>'
      '        <li><a href="#aba3" class="page-scroll">POR'#199#213'ES</a></li>'
      
        '        <li><a href="#aba4" class="page-scroll">CERVEJAS</a></li' +
        '>'
      '        <li><a href="#aba5" class="page-scroll">DRINKS</a></li>'
      
        '        <li><a href="#aba6" class="page-scroll">REFRIGERANTES / ' +
        'SUCOS</a></li>'
      '      </ul>'
      '    </div>'
      '    <!-- /.navbar-collapse --> '
      '  </div>'
      '</nav>'
      '<!-- Header -->'
      '<header id="header">'
      '  <div class="intro">'
      '    <div class="overlay">'
      '      <div class="container">'
      '        <div class="row">'
      '          <div class="intro-text">'
      '            <h1><img src="img/logo.png" /></h1>'
      '          </div>'
      '        </div>'
      '      </div>'
      '    </div>'
      '  </div>'
      '</header>'
      '<!-- Features Section -->'
      '<div id="aba1" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>PRATOS</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/feijoada.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 59,90</span>'
      
        '                    <h4 class="item-name">Feijoada (Quarta e S'#225'b' +
        'ado)</h4>'
      
        '                    <p class="item-description">A famosa feijoad' +
        'a do Bar do Billy para duas pessoas, quem compra n'#227'o procura out' +
        'ra!<br>'
      
        '    Acompanhamentos: Arroz, Couve, Bisteca, Torresmo, Farofa, Mo' +
        'lho Especial e Banana. </p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/alcaparras' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 25,90</span>'
      
        '                    <h4 class="item-name">Fil'#233' de Peixe Grelhado' +
        ' com Alcaparras</h4>'
      
        '                    <p class="item-description">+ 3 acompanhamen' +
        'tos: Arroz, Feij'#227'o, Batata Frita, Mandioca, Pur'#234' ou Vinagrete.</' +
        'p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/peixetomat' +
        'e.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 25,90</span>'
      
        '                    <h4 class="item-name">Fil'#233' de Peixe '#224' dor'#234' c' +
        'om molho espanhol</h4>'
      
        '                    <p class="item-description">+ 3 acompanhamen' +
        'tos: Arroz, Feij'#227'o, Batata Frita, Mandioca, Pur'#234' ou Vinagrete.</' +
        'p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/filemignon' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 26,90</span>'
      '                    <h4 class="item-name">Fil'#233' Mignon</h4>'
      
        '                    <p class="item-description">Acompanha arroz,' +
        ' feij'#227'o e batata frita.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/file_frang' +
        'o.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 16,90</span>'
      '                    <h4 class="item-name">Fil'#233' de Frango</h4>'
      
        '                    <p class="item-description">Acompanha arroz,' +
        ' feij'#227'o e batata frita.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/strogonoff' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 26,90</span>'
      
        '                    <h4 class="item-name">Strogonoff de Frango</' +
        'h4>'
      
        '                    <p class="item-description">Acompanha arroz,' +
        ' feij'#227'o e batata palha.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/parmegiana' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 34,90</span>'
      
        '                    <h4 class="item-name">Parmegiana de Fil'#233' Mig' +
        'non</h4>'
      
        '                    <p class="item-description">Acompanha arroz,' +
        ' feij'#227'o e batata palha.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/pratos/parmegiana' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 24,90</span>'
      
        '                    <h4 class="item-name">Parmegiana de Frango</' +
        'h4>'
      
        '                    <p class="item-description">Acompanha arroz,' +
        ' feij'#227'o e batata palha.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Features Section -->'
      '<div id="aba2" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>ESPETOS</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/carne.jpg' +
        '">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">Carne</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/frango.jp' +
        'g">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">Frango</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/apimentad' +
        'a.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">Lingui'#231'a Toscana</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/apimentad' +
        'a.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      
        '                    <h4 class="item-name">Lingui'#231'a Apimentada</h' +
        '4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/paoalho.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">P'#227'o com Alho</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/carnebaco' +
        'n.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Carne com Bacon</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/frangobac' +
        'on.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Frango com Bacon</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/costela.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Costela Bovina</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/kafta.jpg' +
        '">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Kafta</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/coracao.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Cora'#231#227'o</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/coalho.jp' +
        'g">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      '                    <h4 class="item-name">Queijo Coalho</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/provolone' +
        'bacon.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      
        '                    <h4 class="item-name">Provolone com Bacon</h' +
        '4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/espetos/provolone' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 6,49</span>'
      
        '                    <h4 class="item-name">Mussarela Defumada</h4' +
        '>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '                '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Features Section -->'
      '<div id="aba3" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>POR'#199#213'ES</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/batata.jp' +
        'g">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 18,90</span>'
      '                    <h4 class="item-name">Batata Frita</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/mandioca.' +
        'jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 18,90</span>'
      '                    <h4 class="item-name">Mandioca Frita</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/polenta.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 18,90</span>'
      '                    <h4 class="item-name">Polenta Frita</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/torresmo.' +
        'jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 18,90</span>'
      '                    <h4 class="item-name">Torresmo</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/panceta.j' +
        'pg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 21,90</span>'
      '                    <h4 class="item-name">Panceta</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/feijao.jp' +
        'g">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">Feij'#227'o</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/porcoes/arroz.jpg' +
        '">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      '                    <h4 class="item-name">Arroz Branco</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '                '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Features Section -->'
      '<div id="aba4" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>CERVEJAS</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/cervejas/budweise' +
        'r.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      
        '                    <h4 class="item-name">Budweiser Long Neck</h' +
        '4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/cervejas/eisebahn' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 5,90</span>'
      
        '                    <h4 class="item-name">Eisebahn Long Neck</h4' +
        '>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '              '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/cervejas/heineken' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 7,90</span>'
      
        '                    <h4 class="item-name">Heineken Long Neck</h4' +
        '>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/cervejas/heineken' +
        '600.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 13,90</span>'
      '                    <h4 class="item-name">Heineken 600ml</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/cervejas/original' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 12,90</span>'
      '                    <h4 class="item-name">Original 600ml</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '                '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Features Section -->'
      '<div id="aba5" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>DRINKS</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/drinks/caipirinha' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 11,90</span>'
      
        '                    <h4 class="item-name">Caipirinha Cacha'#231'a</h4' +
        '>'
      
        '                    <p class="item-description">Frutas: Morango,' +
        ' Lim'#227'o, Abacaxi, Kiwi e Lima da Persia.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/drinks/vodka.jpg"' +
        '>'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 14,90</span>'
      '                    <h4 class="item-name">Caipirinha Vodka</h4>'
      
        '                    <p class="item-description">Frutas: Morango,' +
        ' Lim'#227'o, Abacaxi, Kiwi e Lima da Persia.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/drinks/gintonica.' +
        'jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 16,90</span>'
      
        '                    <h4 class="item-name">Gin T'#244'nica Seagers</h4' +
        '>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/drinks/gintonica2' +
        '.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 24,90</span>'
      '                    <h4 class="item-name">Gin T'#244'nica Bombay</h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      
        '        '#9#9'    <img class="item-image" src="img/drinks/gintanquer' +
        'ay.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 29,90</span>'
      
        '                    <h4 class="item-name">Gin T'#244'nica Tanqueray</' +
        'h4>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '                '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Features Section -->'
      '<div id="aba6" class="text-center">'
      '  <div class="container">'
      '    <div class="section-title">'
      '      <h2>REFRIGERANTES / SUCOS</h2>'
      '    </div>'
      '    <div class="row">'
      '      '#9
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      '        '#9#9'    <img class="item-image" src="img/refri/suco.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 7,90</span>'
      '                    <h4 class="item-name">Suco Natural</h4>'
      
        '                    <p class="item-description">Frutas: Laranja,' +
        ' Mel'#226'ncia e Abacaxi.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      '        '#9#9'    <img class="item-image" src="img/refri/lata.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 4,90</span>'
      '                    <h4 class="item-name">Refrigerantes</h4>'
      
        '                    <p class="item-description">Coca-Cola, Fanta' +
        ', Guaran'#225' e Schweppes.</p>'
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '        '
      '        <div class="category-items">'
      '            <div class="media menu-item">'
      '    '#9#9#9'<div class="media-left">'
      '        '#9#9'    <img class="item-image" src="img/refri/agua.jpg">'
      '    '#9#9#9'</div>'
      '                <div class="media-body media-middle">'
      '                    <span class="item-price">R$ 2,90</span>'
      
        '                    <h4 class="item-name">'#193'gua com ou sem g'#225's</h' +
        '4>'
      '                    '
      '                </div>'
      #9#9#9'</div>'
      #9#9'</div>'
      '                '
      '    </div>'
      '  </div>'
      '</div>'
      ''
      '<!-- Contact Section -->'
      '<div id="contact" class="text-center">'
      '  <div class="container text-center">'
      '    <div class="col-md-4">'
      '      <h3>Delivery</h3>'
      '      <div class="contact-item">'
      '        <p>Conhe'#231'a nosso aplicativo "Chama O Billy"</p>'
      
        '        <p><a href="https://apps.apple.com/br/app/chama-o-billy/' +
        'id1478127270" target="_blank"><i class="fa fa-apple"></i></a> '
      '        '
      
        '        <a href="https://play.google.com/store/apps/details?id=c' +
        'om.br.chamaobilly&hl=pt_BR" target="_blank"><i class="fa fa-andr' +
        'oid"></i></a>'
      '        </p>'
      '      </div>'
      '    </div>'
      '    '
      '    <div class="col-md-4">'
      '      <h3>Endere'#231'o</h3>'
      '      <div class="contact-item">'
      '        <p>Rua Jovina, 359, Vila Mascote</p>'
      '        <p>S'#227'o Paulo - SP</p>'
      '      </div>'
      '    </div>'
      '    <div class="col-md-4">'
      '      <h3>Hor'#225'rio de Funcionamento</h3>'
      '      <div class="contact-item">'
      '        <p>Ter'#231'a '#224' s'#225'bado: 11:00 - 22:00</p>'
      '        <p>Domingo: 11:00 - 20:00</p>'
      '      </div>'
      '    </div>'
      '  </div>'
      '  '
      '</div>'
      ''
      ''
      ''
      '<div id="footer">'
      '  <div class="container">'
      '    <div class="col-md-12">'
      
        '      <small>Criado com amor por</small> <i class="fa fa-love"><' +
        '/i><a href="http://www.cardapiando.com.br">Cardapiando</a>'
      '  '
      '      <div class="social" style="float:right;">'
      '        <ul>'
      
        '          <li><a href="https://www.facebook.com/chamaobilly" tar' +
        'get="_blank"><i class="fa fa-facebook"></i></a></li>'
      
        '          <li><a href="https://www.instagram.com/chamaobilly/" t' +
        'arget="_blank"><i class="fa fa-instagram"></i></a></li>'
      '        </ul>'
      '      </div>'
      '    </div>'
      '  </div>'
      '</div>'
      
        '<script type="text/javascript" src="js/jquery.1.11.1.js"></scrip' +
        't> '
      '<script type="text/javascript" src="js/bootstrap.js"></script> '
      
        '<script type="text/javascript" src="js/SmoothScroll.js"></script' +
        '> '
      
        '<script type="text/javascript" src="js/jqBootstrapValidation.js"' +
        '></script> '
      '<script type="text/javascript" src="js/contact_me.js"></script> '
      '<script type="text/javascript" src="js/main.js"></script>'
      '</body>'
      '</html>')
    MasterHtmlTag = '$body'
    IncludeScriptsHtmlTag = '{%incscripts%}'
    Items = <>
    OnBeforeRenderer = dwcrecardapioBeforeRenderer
    Left = 200
    Top = 88
  end
end
