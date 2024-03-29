unit uUsuariosDao;

interface

uses
  SysUtils, 
  Generics.Collections, 
  Aurelius.Mapping.Attributes, 
  Aurelius.Types.Blob, 
  Aurelius.Types.DynamicProperties, 
  Aurelius.Types.Nullable, 
  Aurelius.Types.Proxy, 
  Aurelius.Criteria.Dictionary,
  FireDac.comp.client,
  FireDac.DApt,
  FMX.Graphics,
  Soap.EncdDecd,
  server;

type
  Tusuarios = class;
  TusuariosTableDictionary = class;
  
  [Entity]
  [Table('usuarios')]
  [Id('Fcodigo', TIdGenerator.IdentityOrSequence)]
  Tusuarios = class
  private
    [Column('codigo', [TColumnProp.Required, TColumnProp.NoInsert, TColumnProp.NoUpdate])]
    Fcodigo: Integer;
    
    [Column('nomeusuario', [], 40)]
    Fnomeusuario: Nullable<string>;
    
    [Column('email', [], 100)]
    Femail: Nullable<string>;
    
    [Column('telefone', [], 20)]
    Ftelefone: Nullable<string>;
    
    [Column('tipousuario', [], 20)]
    Ftipousuario: Nullable<string>;
    
    [Column('senha', [], 100)]
    Fsenha: Nullable<string>;
    
    [Column('celular', [], 20)]
    Fcelular: Nullable<string>;
    
    [Column('foto', [TColumnProp.Lazy])]
    Ffoto: TBlob;

    Flogin: string;
    Fcodusu: string;


    procedure Setlogin(const Value: string);
    procedure Setcodusu(const Value: string);



  public
    property codigo: Integer read Fcodigo write Fcodigo;
    property nomeusuario: Nullable<string> read Fnomeusuario write Fnomeusuario;
    property email: Nullable<string> read Femail write Femail;
    property telefone: Nullable<string> read Ftelefone write Ftelefone;
    property tipousuario: Nullable<string> read Ftipousuario write Ftipousuario;
    property senha: Nullable<string> read Fsenha write Fsenha;
    property celular: Nullable<string> read Fcelular write Fcelular;
    property foto: TBlob read Ffoto write Ffoto;

    property login:string read Flogin write Setlogin;
    property codusu:string read Fcodusu write Setcodusu;


    function validaLogin(out erro: string): Boolean;




  end;
  
  TDicDictionary = class
  private
    Fusuarios: TusuariosTableDictionary;
    function Getusuarios: TusuariosTableDictionary;

  public
    destructor Destroy; override;
    property usuarios: TusuariosTableDictionary read Getusuarios;
  end;
  
  TusuariosTableDictionary = class
  private
    Fcodigo: TDictionaryAttribute;
    Fnomeusuario: TDictionaryAttribute;
    Femail: TDictionaryAttribute;
    Ftelefone: TDictionaryAttribute;
    Ftipousuario: TDictionaryAttribute;
    Fsenha: TDictionaryAttribute;
    Fcelular: TDictionaryAttribute;
    Ffoto: TDictionaryAttribute;


  public
    constructor Create;
    property codigo: TDictionaryAttribute read Fcodigo;
    property nomeusuario: TDictionaryAttribute read Fnomeusuario;
    property email: TDictionaryAttribute read Femail;
    property telefone: TDictionaryAttribute read Ftelefone;
    property tipousuario: TDictionaryAttribute read Ftipousuario;
    property senha: TDictionaryAttribute read Fsenha;
    property celular: TDictionaryAttribute read Fcelular;
    property foto: TDictionaryAttribute read Ffoto;
  end;
  
function Dic: TDicDictionary;

implementation

var
  __Dic: TDicDictionary;


function Dic: TDicDictionary;
begin
  if __Dic = nil then __Dic := TDicDictionary.Create;
  result := __Dic
end;

{ TDicDictionary }

destructor TDicDictionary.Destroy;
begin
  if Fusuarios <> nil then Fusuarios.Free;
  inherited;
end;

function TDicDictionary.Getusuarios: TusuariosTableDictionary;
begin
  if Fusuarios = nil then Fusuarios := TusuariosTableDictionary.Create;
  result := Fusuarios;
end;

{ TusuariosTableDictionary }

constructor TusuariosTableDictionary.Create;
begin
  inherited;
  Fcodigo := TDictionaryAttribute.Create('codigo');
  Fnomeusuario := TDictionaryAttribute.Create('nomeusuario');
  Femail := TDictionaryAttribute.Create('email');
  Ftelefone := TDictionaryAttribute.Create('telefone');
  Ftipousuario := TDictionaryAttribute.Create('tipousuario');
  Fsenha := TDictionaryAttribute.Create('senha');
  Fcelular := TDictionaryAttribute.Create('celular');
  Ffoto := TDictionaryAttribute.Create('foto');
end;


procedure Tusuarios.Setcodusu(const Value: string);
begin
  Fcodusu := Value;
end;

procedure Tusuarios.Setlogin(const Value: string);
begin
  Flogin := Value;
end;

function  Tusuarios.validaLogin(out erro: string): Boolean;
var Query:TFDQuery;
begin
  try
    Query := nil;

    try

        Query := TFDquery.Create(nil);
        Query.Connection := frmserver.conn;
        with Query do
        begin
           Active := false;
           Sql.Clear;
           Sql.Add('Select * from usuarios where (email = :email and senha = :senha)');
           ParamByName('email').AsString := copy(Login,1,100);
           ParamByName('senha').AsString:=  Senha;
           Active := true;

           if RecordCount > 0 then
           begin
             codusu := fieldbyname('codigo').Asstring;
             erro := '0';
             Result := True;
           end
           else
           begin
             {TODO 1 -Marcos Br�s -Implemntat: Se n�o achar email e senha / ent�o verificar celular e email / ou achar nomeusuario e senha }
             Active := false;
             Sql.Clear;
             Sql.Add('Select * from usuarios where (celular = :celular and senha = :senha)');
             ParamByName('celular').AsString := copy(Login,1,20);
             ParamByName('senha').AsString:=  Senha;
             Active := true;

             if RecordCount > 0 then
             begin
               codusu := fieldbyname('codigo').Asstring;
               erro := '0';
               Result := True;
             end
             else
             begin
               Active := false;
               Sql.Clear;
               Sql.Add('Select * from usuarios where (nomeusuario = :nomeusuario and senha = :senha)');
               ParamByName('nomeusuario').AsString := copy(Login,1,40);
               ParamByName('senha').AsString:=  Senha;
               Active := true;

               if RecordCount > 0 then
               begin
                 codusu := fieldbyname('codigo').Asstring;
                 erro := '0';
                 Result := True;
               end
               else
               begin
                 codigo := 0;
                 erro := '201-Login ou senha n�o encontrado';
                 Result := False;
               end;
             end;
           end;
        end;


      except on ex : exception do
          begin
             erro := '500-Erro ao validar login '+ex.Message;
             Result := False;
          end;

      end;

  finally
    freeandnil(Query);

  end;




end;





initialization
  RegisterEntity(Tusuarios);

finalization
  if __Dic <> nil then __Dic.Free

end.
