unit lista_usuarios;

interface

uses
  System.SysUtils, System.Classes, JS, Web, WEBLib.Graphics, WEBLib.Controls,
  WEBLib.Forms, WEBLib.Dialogs, XData.Web.Connection, Vcl.StdCtrls,
  WEBLib.StdCtrls, Vcl.Controls, XData.Web.Client, JS, Data.DB, WEBLib.DB,
  WEBLib.Grids, WEBLib.DBCtrls, XData.Web.JsonDataset, XData.Web.Dataset;

type
  TForm1 = class(TWebForm)
    XDataWebConnection1: TXDataWebConnection;
    XDataWebClient1: TXDataWebClient;
    WebEdit1: TWebEdit;
    WebEdit2: TWebEdit;
    WebButton1: TWebButton;
    XDataWebDataSet1: TXDataWebDataSet;
    WebDBTableControl1: TWebDBTableControl;
    WebDataSource1: TWebDataSource;
    XDataWebDataSet1codigo: TIntegerField;
    XDataWebDataSet1nomeusuario: TStringField;
    XDataWebDataSet1email: TStringField;
    XDataWebDataSet1telefone: TStringField;
    XDataWebDataSet1tipousuario: TStringField;
    XDataWebDataSet1celular: TStringField;
    procedure WebButton1Click(Sender: TObject);
    procedure XDataWebClient1Load(Response: TXDataClientResponse);
    procedure WebFormShow(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.dfm}

procedure TForm1.WebButton1Click(Sender: TObject);
begin
   xdatawebclient1.RawInvoke('IMyService.Sum',[strtoint(webedit1.text),strtoint(webedit2.text)]);
end;

procedure TForm1.WebFormShow(Sender: TObject);
begin
 xdatawebdataset1.Load;
end;

procedure TForm1.XDataWebClient1Load(Response: TXDataClientResponse);
begin
   //Colhendo resultado do RawInvoke

   showmessage(inttostr(
         Integer(TJSObject(Response.result)['value'])
   ));
end;

end.