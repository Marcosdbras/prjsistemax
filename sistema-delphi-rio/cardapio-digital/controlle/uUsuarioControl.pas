unit uUsuarioControl;

interface
uses System.SysUtils, uUsuarioModel, FireDac.Comp.Client;

   type TUsuarioControl = class
      private
         FUsuarioModel :  TUsuarioModel;

      public
         constructor create;
         Destructor Destroy; override;
         function obterUsuarios:TFDQuery;
         function executarCRUD:boolean;

         property UsuarioModel : TUsuarioModel read FUsuarioModel write FUsuarioModel;


   end;
implementation



{ TUsuarioControl }

constructor TUsuarioControl.create;
begin
  FUsuarioModel := TUsuarioModel.Create;
end;

destructor TUsuarioControl.Destroy;
begin

  FreeAndNil(FUsuarioModel);

  inherited;

end;

function TUsuarioControl.executarCRUD: boolean;
begin
   Result := FUsuarioModel.executarCRUD;
end;

function TUsuarioControl.obterUsuarios: TFDQuery;
begin
   Result := FUsuarioModel.obterUsuarios;
end;

end.
