unit uUsuarioModel;

interface
  uses System.SysUtils, uEnumerado, FireDac.Comp.Client;

   type TUsuarioModel = class
  private
    FAcao:TAcao;
    Femail: string;
    Fcodigo: Integer;
    Fcaminhoarquivofoto: string;
    Fsenha: string;
    Fnome: string;
    Ftelefone: string;
    Fcelular: string;

    procedure Setcaminhoarquivofoto(const Value: string);
    procedure Setcelular(const Value: string);
    procedure Setcodigo(const Value: Integer);
    procedure Setemail(const Value: string);
    procedure Setnome(const Value: string);
    procedure Setsenha(const Value: string);
    procedure Settelefone(const Value: string);
    procedure Setacao(const Value:TAcao);


      public

        function obterUsuarios:TFDQuery;
        function executarCRUD:boolean; //incluir, excluir, alterar

        //constructor  create(aCodigoUsuario:integer);
        procedure Carregar(aCodigoUsuario:integer);

        property codigo             : Integer read Fcodigo write Setcodigo;
        property nome               : string  read Fnome   write Setnome;
        property senha              : string  read Fsenha  write Setsenha;
        property caminhoarquivofoto : string  read Fcaminhoarquivofoto write Setcaminhoarquivofoto;
        property email              : string  read Femail write Setemail;
        property celular            : string  read Fcelular write Setcelular;
        property telefone           : string  read Ftelefone write Settelefone;
        property acao               : tAcao   read FAcao     write Setacao;





   end;
implementation

{ tusuario }

uses uUsuarioDao;




//constructor tusuarioModel.create(aCodigoUsuario: integer);
//begin
//   FCodigo := aCodigoUsuario;
//end;

function TUsuarioModel.executarCRUD: boolean;
var
  vUsuarioDao:TUsuarioDao;
begin

   result := false;

   vUsuarioDao := TUsuarioDao.create;

   try


     case FACAo of

      //incluir
      uEnumerado.tpincluir:begin

         result := vUsuarioDao.incluirUsuario(self);

      end;

      //alterar
      uEnumerado.tpalterar:begin

         result := vUsuarioDao.alterarUsuario(self);

      end;

      //excluir
      uEnumerado.tpexcluir:begin

         result := vUsuarioDao.excluirUsuario(self);

      end;

   end;



   finally
      FreeAndNil(vUsuarioDao);
   end;



end;

procedure TUsuarioModel.Carregar(aCodigoUsuario:integer);
var
  vUsuarioDao : TUsuarioDao;
begin

  vUsuarioDao := TUsuarioDao.Create;

  try
     vUsuarioDao.carregar(self,aCodigoUsuario);
  finally
    FreeAndNil(vUsuarioDao);
  end;

end;

function TUsuarioModel.obterUsuarios: TFDQuery;
var
   vUsuarioDao : tUsuarioDao;
begin

   vUsuarioDao := tUsuarioDao.create;

   try
     result := vUsuarioDao.obterUsuarios;
   finally
     FreeAndNil(vUsuarioDao);
   end;

end;

procedure TUsuarioModel.Setacao(const Value: TAcao);
begin
  FAcao := Value;
end;

procedure tusuarioModel.Setcaminhoarquivofoto(const Value: string);
begin
  Fcaminhoarquivofoto := Value;
end;

procedure tusuarioModel.Setcelular(const Value: string);
begin
  Fcelular := Value;
end;

procedure tusuarioModel.Setcodigo(const Value: Integer);
begin
  Fcodigo := Value;
end;

procedure tusuarioModel.Setemail(const Value: string);
begin
  Femail := Value;
end;

procedure tusuarioModel.Setnome(const Value: string);
begin
  Fnome := Value;
end;

procedure tusuarioModel.Setsenha(const Value: string);
begin
  Fsenha := Value;
end;

procedure tusuarioModel.Settelefone(const Value: string);
begin
  Ftelefone := Value;
end;


end.