unit uprincipal;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.ComCtrls,
  System.Actions, Vcl.ActnList, Vcl.ActnMan, Vcl.ToolWin,
  Vcl.ActnCtrls, Vcl.ActnMenus, Vcl.Menus;

type
  Tfrmprincipal = class(TForm)
    btnConexao: TButton;
    StatusBar1: TStatusBar;
    MainMenu1: TMainMenu;
    Ca1: TMenuItem;
    Usurios1: TMenuItem;
    procedure btnConexaoClick(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
    procedure Usurios1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmprincipal: Tfrmprincipal;

implementation

{$R *.dfm}

uses uconexao, uSistemaControl, uUsuarioView;



procedure Tfrmprincipal.btnConexaoClick(Sender: TObject);
var
  vConexao : tConexao;
begin


  try

    vConexao := TConexao.Create;
    vConexao.GetConn.Connected := true;
    if vConexao.GetConn.Connected then
       showmessage('Conectado...');

  finally
     FreeandNil(vConexao);
  end;


end;

procedure Tfrmprincipal.FormCreate(Sender: TObject);

  begin

    TSistemaControl.GetInstace().CarregarUsuario(1);

    statusbar1.Panels[0].Text := 'VERSÃO 1.0.0';
    statusbar1.Panels[1].Text := 'USUÁRIO: '+TSistemaControl.GetInstace().UsuarioModel.nome;

  end;

procedure Tfrmprincipal.FormDestroy(Sender: TObject);
begin
   TSistemaControl.GetInstace().Destroy;
end;

procedure Tfrmprincipal.Usurios1Click(Sender: TObject);
begin
  frmUsuarioView := TFrmUsuarioView.create(self);
  frmUsuarioView.ShowModal;
  frmUsuarioView.Free;
end;

initialization
     ReportMemoryLeaksOnShutdown := true;


end.
