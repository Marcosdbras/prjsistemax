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
    lblservidor: TLabel;
    edtporta: TEdit;
    Rectangle2: TRectangle;
    Label4: TLabel;
    btnconfiguracoes: TLabel;
    edtservidor: TEdit;
    edtusuario_servidor: TEdit;
    edtsenha_servidor: TEdit;
    edtcusuhash: TEdit;
    procedure btnacessarClick(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure btnconfiguracoesClick(Sender: TObject);
    procedure Label4Click(Sender: TObject);
    procedure Rectangle2Click(Sender: TObject);
    procedure FormShow(Sender: TObject);


  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmlogin: Tfrmlogin;

implementation

{$R *.fmx}

uses uprincipal, uDM;

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
   lbltitulo.Text := 'Configura��es';

end;

procedure Tfrmlogin.FormClose(Sender: TObject; var Action: TCloseAction);
begin
//limpa mem�ria /  garbage
action := tcloseaction.caFree;
frmlogin := nil;
end;


procedure Tfrmlogin.FormShow(Sender: TObject);
begin
   with DM.query do
      begin

        active := false;
        sql.clear;
        sql.Add('select* from config');
        active := true;

        if fieldbyname('servidor').AsString <> '' then
           begin

             edtservidor.Text := fieldbyname('servidor').AsString;
             edtporta.Text := fieldbyname('porta').AsString;
             edtusuario_servidor.Text := fieldbyname('porta').AsString;
             edtsenha_servidor.Text := fieldbyname('senha').AsString;
             edtcusuhash.Text := fieldbyname('cusuhash').AsString;
             tabcontrol.ActiveTab := tablogin;

           end
        else
           begin

             lbltitulo.Text := 'Configura��es';
             tabcontrol.ActiveTab := tabconfig;

           end;

      end;
end;

procedure Tfrmlogin.Label4Click(Sender: TObject);
begin
 tabcontrol.GotoVisibleTab(0, ttabtransition.Slide);
 lbltitulo.Text := 'Acesso';
end;

procedure Tfrmlogin.Rectangle2Click(Sender: TObject);
begin
if edtservidor.Text = '' then
   begin

     showmessage('Voc� deve informar o caminho do servidor!');
     exit;

   end;
//endif

with DM.Query do
   begin

      active := false;
      sql.Clear;
      sql.Add('delete from config');
      execsql;


      active  := false;
      sql.Clear;
      sql.Add('insert into config (servidor,cusuhash, porta, usuario, senha) values (:servidor, :cusuhash, :porta, :usuario, :senha)');
      parambyname('servidor').AsString := edtservidor.Text;
      parambyname('cusuhash').AsString := edtcusuhash.Text;
      parambyname('porta').AsString := edtporta.Text;
      parambyname('usuario').AsString := edtusuario_servidor.text;
      parambyname('senha').AsString := edtsenha_servidor.Text;
      execsql;





   end;



 tabcontrol.GotoVisibleTab(0, ttabtransition.Slide);
 lbltitulo.Text := 'Acesso';
end;

End.
