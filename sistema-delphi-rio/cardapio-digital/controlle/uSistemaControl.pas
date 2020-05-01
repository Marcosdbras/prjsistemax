unit uSistemaControl;

//Controle de conexão

interface
uses System.SysUtils,  uconexao, uUsuarioModel;

    type
    TSistemaControl = class
    private
      FConexao : TConexao;
      FUsuarioModel : TUsuarioModel;
      class var FInstance: TSistemaControl;

    public
       constructor Create;
       destructor  Destroy; override; //sobrecarga


       procedure CarregarUsuario(aCodigoUsuario:integer);

       class function  GetInstace:TSistemaControl;

    property Conexao : TConexao read FConexao write FConexao;
    property UsuarioModel : TUsuarioModel read FUsuarioModel write FUsuarioModel;

    end;
implementation

{ TSistemaControl }


procedure TSistemaControl.CarregarUsuario(aCodigoUsuario:integer);
begin
  FUsuarioModel.Carregar(aCodigoUsuario);
end;

constructor TSistemaControl.Create;
begin
  FConexao := TConexao.Create;

  //veriicar
  FUsuarioModel := TUsuarioModel.Create();
end;

destructor TSistemaControl.Destroy;
begin

  freeandNil(FUsuarioModel);
  FreeAndNil(FConexao);
  inherited;

end;

class function TSistemaControl.GetInstace: TSistemaControl;
begin

  if not Assigned(Self.FInstance) then
  begin
    Self.FInstance := TSistemaControl.Create;
  end;

  result := Self.FInstance;
end;


end.
