unit uDM;

interface

uses
  System.SysUtils, System.Classes, FireDAC.Stan.Intf, FireDAC.Stan.Option,
  FireDAC.Stan.Error, FireDAC.UI.Intf, FireDAC.Phys.Intf, FireDAC.Stan.Def,
  FireDAC.Stan.Pool, FireDAC.Stan.Async, FireDAC.Phys, FireDAC.FMXUI.Wait,
  Data.DB, FireDAC.Comp.Client, FireDAC.Phys.SQLite, FireDAC.Phys.SQLiteDef,
  FireDAC.Stan.ExprFuncs, FireDAC.Stan.Param, FireDAC.DatS, FireDAC.DApt.Intf,
  FireDAC.DApt, FireDAC.Comp.DataSet;

type
  TDM = class(TDataModule)
    Conn: TFDConnection;
    Query: TFDQuery;
    procedure DataModuleCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  DM: TDM;

implementation

{%CLASSGROUP 'FMX.Controls.TControl'}

{$R *.dfm}

procedure TDM.DataModuleCreate(Sender: TObject);
begin


with Conn do
   begin

     Params.Values['DriverID'] := 'SQLite';

     {$IFDEF IOS}
         Params.Values['Database'] := TPath.Combine(TPath.GetDocumentsPath,'comanda_eletronica.db');
     {$ENDIF}


     {$IFDEF ANDROID}
         Params.Values['Database'] := TPath.Combine(TPath.GetDocumentsPath,'comanda_eletronica.db');
     {$ENDIF}


     {$IFDEF MSWINDOWS}

         if fileexists(System.SysUtils.GetCurrentDir +  '\DB\comanda_eletronica.db') then

             Params.Values['Database'] := System.SysUtils.GetCurrentDir +  '\DB\comanda_eletronica.db'

         else

            Params.Values['Database'] := System.SysUtils.GetCurrentDir +  '\..\..\DB\comanda_eletronica.db';


     {$ENDIF}


     try
        Connected := true;

     except  on e:exception do
         raise Exception.Create('Erro ao conectar o banco de dados'+e.Message);


     end;


   end;



end;

end.
