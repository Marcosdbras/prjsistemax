unit ulogin;

interface

uses
  System.SysUtils, System.Types, System.UITypes, System.Classes, System.Variants,
  FMX.Types, FMX.Controls, FMX.Forms, FMX.Graphics, FMX.Dialogs, FMX.Edit,
  FMX.Layouts, FMX.Controls.Presentation, FMX.StdCtrls, FMX.Objects,
  FMX.TabControl, Rest.Types;

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
    Label2: TLabel;
    Rectangle1: TRectangle;
    Rectangle3: TRectangle;
    Rectangle4: TRectangle;
    Rectangle5: TRectangle;
    Rectangle6: TRectangle;
    Label3: TLabel;
    Label5: TLabel;
    Label6: TLabel;
    Label7: TLabel;
    tabobterchave: TTabItem;
    Label8: TLabel;
    edtusuarioserial: TEdit;
    edtsenhaserial: TEdit;
    Rectangle7: TRectangle;
    Label9: TLabel;
    Image1: TImage;
    edtsenha: TEdit;
    procedure btnacessarClick(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure btnconfiguracoesClick(Sender: TObject);
    procedure Label4Click(Sender: TObject);
    procedure Rectangle2Click(Sender: TObject);
    procedure FormShow(Sender: TObject);
    procedure Rectangle7Click(Sender: TObject);
    procedure Label6Click(Sender: TObject);


  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmlogin: Tfrmlogin;

implementation

{$R *.fmx}

uses uprincipal, uDM, uMD5;

procedure Tfrmlogin.btnacessarClick(Sender: TObject);
var
   erro:string;
begin


  if not DM.login(erro,edtlogin.Text,md5(edtsenha.Text)) then
     begin

       showmessage(erro);
       exit;

     end;






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


procedure Tfrmlogin.FormShow(Sender: TObject);
begin
   with DM.query do
      begin

        active := false;
        sql.clear;
        sql.Add('select* from config');
        active := true;

        if fieldbyname('cusuhash').AsString <> '' then
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

             lbltitulo.Text := 'Configurações';
             tabcontrol.ActiveTab := tabconfig;

           end;

      end;
end;

procedure Tfrmlogin.Label4Click(Sender: TObject);
begin
 tabcontrol.GotoVisibleTab(0, ttabtransition.Slide);
 lbltitulo.Text := 'Acesso';
end;

procedure Tfrmlogin.Label6Click(Sender: TObject);
begin
   tabcontrol.GotoVisibleTab(2, ttabtransition.Slide);
   lbltitulo.Text := 'Administrador da Conta';

   edtusuarioserial.Text := '';
   edtsenhaserial.Text := '';


end;

procedure Tfrmlogin.Rectangle2Click(Sender: TObject);
begin
if edtservidor.Text = '' then
   begin

     showmessage('Você deve informar o caminho do servidor!');
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

procedure Tfrmlogin.Rectangle7Click(Sender: TObject);
var
  erro:string;

begin
  if not DM.login(erro,edtusuarioserial.Text,md5(edtsenhaserial.Text)) then
     begin

       showmessage(erro);
       exit;

     end;

  edtcusuhash.Text := dm.hash;


  tabcontrol.GotoVisibleTab(1, ttabtransition.Slide);
   lbltitulo.Text := 'Configurações';





end;

End.
