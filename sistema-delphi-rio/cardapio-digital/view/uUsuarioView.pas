unit uUsuarioView;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Data.DB, Vcl.Grids, Vcl.DBGrids,
  Vcl.StdCtrls;

type
  TfrmUsuarioView = class(TForm)
    DBGrid1: TDBGrid;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmUsuarioView: TfrmUsuarioView;

implementation
      uses uUsuarioControl, UsuarioModule, uUsuarioDao, uEnumerado;
{$R *.dfm}

procedure TfrmUsuarioView.Button1Click(Sender: TObject);
var
   vControleUsuario: TUsuarioControl;

begin
   vControleUsuario := TUsuarioControl.create;
   try
     vControleUsuario.UsuarioModel.acao := uEnumerado.tpincluir;
     vControleUsuario.UsuarioModel.nome := 'MASTER';

     if vControleUsuario.executarCRUD then
        begin

          showmessage('Salvo com sucesso!');

        end;

     //self.CarregarUsuarios;

     //datamodule1.tbUsuario.Close;

     //datamodule1.CarregarUsuarios;

     //datamodule1.tbUsuario.Open;




   finally
     FreeAndNil(vControleUsuario);
   end;
end;

end.
