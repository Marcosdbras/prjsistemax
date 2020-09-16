unit uDM;

interface

uses
  System.SysUtils,
  System.Classes,
  uDWAbout,
  uDWDataModule,
  uRESTDWServerContext;

type
  TDM = class(TServerMethodDataModule)
    DWServerContext1: TDWServerContext;
    dwcrindex: TDWContextRules;
    dwcrecardapio: TDWContextRules;
    procedure dwcrindexBeforeRenderer(aSelf: TComponent);
    procedure ServerMethodDataModuleCreate(Sender: TObject);
    procedure cabeçalho;

    procedure rodape;
    procedure dwcrecardapioBeforeRenderer(aSelf: TComponent);
    procedure cabecalhoCardapio;
    procedure rodapeCardapio;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  DM: TDM;

implementation

{%CLASSGROUP 'Vcl.Controls.TControl'}

{$R *.dfm}

procedure TDM.cabecalhoCardapio;
begin
//-----
end;

procedure TDM.cabeçalho;
begin
//-----
end;

procedure TDM.rodape;
begin
//-----
end;



procedure TDM.rodapeCardapio;
begin
//---------------
end;

procedure TDM.dwcrecardapioBeforeRenderer(aSelf: TComponent);
begin

//----

end;

procedure TDM.dwcrindexBeforeRenderer(aSelf: TComponent);
begin
//TDWContextRules(aSelf).MasterHtml.LoadFromFile('..\..\www\templates\index.html');
//TDWContextRules(aSelf).MasterHtml.LoadFromFile('..\..\www\cardapio\index.html');

//TDWContextRules(aSelf).MasterHtml.Clear;
//TDWContextRules(aSelf).MasterHtml.Add('');

TDWContextRules(aSelf).MasterHtml.Clear;
TDWContextRules(aSelf).MasterHtml.Add('');
TDWContextRules(aSelf).MasterHtml.Add('<!DOCTYPE html>');
TDWContextRules(aSelf).MasterHtml.Add('<html lang="en">');
TDWContextRules(aSelf).MasterHtml.Add('<head>');
TDWContextRules(aSelf).MasterHtml.Add('<meta charset="utf-8">');
TDWContextRules(aSelf).MasterHtml.Add('<meta name="viewport" content="width=device-width, initial-scale=1">');
TDWContextRules(aSelf).MasterHtml.Add('<title>Bar do Billy</title>');
TDWContextRules(aSelf).MasterHtml.Add('<meta name="description" content="">');
TDWContextRules(aSelf).MasterHtml.Add('<meta name="author" content="">');

TDWContextRules(aSelf).MasterHtml.Add('<!-- Favicons ================================================== -->');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="apple-touch-icon" href="img/apple-touch-icon.png">');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">');

TDWContextRules(aSelf).MasterHtml.Add('<!-- Bootstrap -->');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="stylesheet" type="text/css"  href="css/bootstrap.css">');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">');

TDWContextRules(aSelf).MasterHtml.Add('<!-- Stylesheet    ================================================== -->');
TDWContextRules(aSelf).MasterHtml.Add('<link rel="stylesheet" type="text/css"  href="css/style.css">');
TDWContextRules(aSelf).MasterHtml.Add('<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">');
TDWContextRules(aSelf).MasterHtml.Add('<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">');
TDWContextRules(aSelf).MasterHtml.Add('<link href="https://fonts.googleapis.com/css?family=Rochester" rel="stylesheet">');

TDWContextRules(aSelf).MasterHtml.Add('<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->');
TDWContextRules(aSelf).MasterHtml.Add('<!-- WARNING: Respond.js doesnt work if you view the page via file:// -->');
TDWContextRules(aSelf).MasterHtml.Add('<!--[if lt IE 9]>');
TDWContextRules(aSelf).MasterHtml.Add('<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>');
TDWContextRules(aSelf).MasterHtml.Add('<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>');
TDWContextRules(aSelf).MasterHtml.Add('<![endif]-->');
TDWContextRules(aSelf).MasterHtml.Add('</head>');



end;


procedure TDM.ServerMethodDataModuleCreate(Sender: TObject);
begin
//dwcrindex.Items.ContextByName['texto'].SetDisplayName('Aprentação');
end;

end.
