unit ulogin;

interface

uses
  System.SysUtils, System.Types, System.UITypes, System.Classes, System.Variants,
  FMX.Types, FMX.Controls, FMX.Forms, FMX.Graphics, FMX.Dialogs, FMX.Edit,
  FMX.Layouts, FMX.Controls.Presentation, FMX.StdCtrls, FMX.Objects,
  FMX.TabControl;

type
  Tfrmlogin = class(TForm)
    rctacesso: TRectangle;
    lbltitulo: TLabel;
    Layout1: TLayout;
    Label1: TLabel;
    edtlogin: TEdit;
    btnacessar: TRectangle;
    lblacesso: TLabel;
    TabControl: TTabControl;
    tablogin: TTabItem;
    tabconfig: TTabItem;
    Layout2: TLayout;
    Label3: TLabel;
    Edit1: TEdit;
    Rectangle2: TRectangle;
    Label4: TLabel;
    btnconfiguracoes: TLabel;
    procedure btnacessarClick(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure btnconfiguracoesClick(Sender: TObject);
    procedure Label4Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure Rectangle2Click(Sender: TObject);


  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmlogin: Tfrmlogin;

implementation

{$R *.fmx}

uses uprincipal;

procedure Tfrmlogin.btnacessarClick(Sender: TObject);
begin

  //verifica se form existe
  if not assigned(frmprincipal) then
     begin
       //cria form principal
       Application.CreateForm(tfrmprincipal, frmprincipal);

       //mostrar form principal
       frmprincipal.Show;

       //torna principal
       application.MainForm := frmprincipal;

       //fecha form login
       frmlogin.Close;

     end;

end;

procedure Tfrmlogin.btnconfiguracoesClick(Sender: TObject);
begin
   tabcontrol.GotoVisibleTab(1, ttabtransition.Slide);
   lbltitulo.Text := 'Configurações';

end;

procedure Tfrmlogin.FormClose(Sender: TObject; var Action: TCloseAction);
begin
//limpa memória /  garbage
action := tcloseaction.caFree;
frmlogin := nil;
end;


procedure Tfrmlogin.FormCreate(Sender: TObject);
begin
  tabcontrol.ActiveTab := tablogin;
end;

procedure Tfrmlogin.Label4Click(Sender: TObject);
begin
 tabcontrol.GotoVisibleTab(0, ttabtransition.Slide);
 lbltitulo.Text := 'Acesso';
end;

procedure Tfrmlogin.Rectangle2Click(Sender: TObject);
begin
   tabcontrol.GotoVisibleTab(0, ttabtransition.Slide);
 lbltitulo.Text := 'Acesso';
end;

End.
