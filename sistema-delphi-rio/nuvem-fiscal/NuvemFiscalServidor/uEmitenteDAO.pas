unit uEmitenteDAO;

interface
       uses
         Aurelius.Mapping.Attributes;

       type
          [Entity,AutoMapping]
          TEmitente = class
             private
               FId:integer;
               FNome:string;
               FCNPJ:string;
               FIE:string;


             public
                property Id:Integer  read FId   write FId;
                property Nome:String read FNome write FNome;
                property CNPJ:string read FCNPJ write FCNPJ;
                property IE:string   read FIE   write FIE;

          end;

implementation

end.
