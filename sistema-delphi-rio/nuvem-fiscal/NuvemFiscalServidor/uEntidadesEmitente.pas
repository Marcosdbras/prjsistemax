unit uEntidadesEmitente;

interface
       uses
         Aurelius.Mapping.Attributes;

       type
          [Entity,AutoMapping]
          TPerson = class
             private
               FNome:string;
               FId:integer;

             public
                property Id:Integer read FId write FId;
                property Nome:String read FNome write FNome;

          end;

implementation

end.
