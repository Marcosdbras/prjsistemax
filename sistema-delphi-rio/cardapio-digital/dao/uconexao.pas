unit uconexao;
interface
    uses
      Aurelius.Drivers.Interfaces, Aurelius.Drivers.FireDac,  FireDAC.Dapt,
      System.SysUtils, System.Classes, FireDAC.Stan.Intf, FireDAC.Stan.Option,
      FireDAC.Stan.Error, FireDAC.UI.Intf, FireDAC.Phys.Intf, FireDAC.Stan.Def,
      FireDAC.Stan.Pool, FireDAC.Stan.Async, FireDAC.Phys, FireDAC.VCLUI.Wait,
      Aurelius.Sql.Firebird, Aurelius.Schema.Firebird, Aurelius.Comp.Connection,
      Data.DB, FireDAC.Comp.Client, FireDAC.Phys.FB, FireDAC.Phys.FBDef;


  type TConexao = class
       private
         fConn : TFDConnection;
         procedure ConfigurarConexao;


       public
         constructor Create;
         Destructor Destroy; override;

         function CriarQuery:TFDQuery;
         function GetConn:TfDConnection;
  end;

implementation

{ TConexao }

procedure TConexao.ConfigurarConexao;
begin
   FConn.Params.DriverID :=  'FB';
   FConn.Params.Database :=  'C:\Users\WIN 8.1\Documents\sistemas\sistema-delphi-rio\cardapio-digital\db\dbfinanceiro.fdb';
   FConn.Params.UserName :=  'SYSDBA';
   FConn.Params.Password :=  'masterkey';
   FConn.LoginPrompt := false;
end;

constructor TConexao.Create;
begin
  FConn := TFDConnection.Create(nil);

  self.ConfigurarConexao;
end;

function TConexao.CriarQuery: TFDQuery;
var
  vQuery : TFDQuery;
begin
   vQuery := TFDQuery.Create(nil);
   vQuery.Connection := FConn;

   result := vQuery;
end;

destructor TConexao.Destroy;
begin
  Freeandnil(FConn);
  inherited;
end;

function TConexao.GetConn: TfDConnection;
begin
result := FConn;
end;

end.