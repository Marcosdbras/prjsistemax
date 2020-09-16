unit MyService;

interface

uses
  SysUtils,
  XData.Server.Module,
  XData.Service.Common,
  Server,
  uUsuariosDao,
  json;

type
  [ServiceContract]
  IMyService = interface(IInvokable)
    ['{207FEADD-0F6F-47CB-BE55-D1031F9382FB}']
    [HttpGet] function Sum(A, B: double): double;
    [HttpPost] function validalogin(login, senha: string): string;
    // By default, any service operation responds to (is invoked by) a POST request from the client.
    function EchoString(Value: string): string;
  end;

  [ServiceImplementation]
  TMyService = class(TInterfacedObject, IMyService)
  private
    function Sum(A, B: double): double;
    function validalogin(login, senha: string): string;
    function EchoString(Value: string): string;
  end;

implementation

function TMyService.Sum(A, B: double): double;
begin
  Result := A + B;
end;

function TMyService.EchoString(Value: string): string;
begin
  Result := Value;
end;

function TMyService.validalogin(login, senha: string): string;
  var erro:string;
      Usuarios :TUsuarios;
      Json:TJsonObject;
begin
   try



     jSon := TJsonObject.Create;

     Usuarios := tUsuarios.Create;
     Usuarios.Login := login;
     Usuarios.Senha := senha;

     if not Usuarios.validaLogin(erro) then
     begin

        //'{"suceso":"N", "erro":"Usu�rio n�o informado","codusuario":""}'
        JSon.AddPair('Status', 'Erro');
        JSon.AddPair('erro',erro);
        Json.AddPair('CodigoUsuario','0');


     end
     else
     begin

       //'{"suceso":"S", "erro":"","codusuario":"10"}';
       JSon.AddPair('Status','Sucesso');
       JSon.AddPair('erro','0');
       JSon.AddPair('CodigoUsuario',Usuarios.codusu);

     end;

     Result := '['+Json.ToString+']';

     //Result := '"Status":"sucesso","erro":"erro","codigo":"codigo"';

     //Result := 'Sucesso';


   finally

      //FreeandNil(JSon);
      //FreeandNil(Usuario);

      JSon.DisposeOf;
      Usuarios.DisposeOf;

   end;


end;


{
begin
  with frmserver do
     begin
        qrconsulta.Active := false;
        qrconsulta.SQL.Clear;
        qrconsulta.SQL.Add('select * from usuarios where (nomeusuario = :nomeusuario) and (senha = :senha)');
        qrconsulta.ParamByName('nomeusuario').AsString  := login;
        qrconsulta.ParamByName('senha').AsString := senha;
        qrconsulta.Active := true;
        if qrconsulta.RecordCount > 0 then
           begin
             Result := qrconsulta.FieldByName('nomeusuario').AsString;
           end
        else
           begin
               Result := '';
           end;
     end;
end;
}

initialization
  RegisterServiceType(TypeInfo(IMyService));
  RegisterServiceType(TMyService);

end.
