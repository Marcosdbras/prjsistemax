program pServer;

uses
  Vcl.Forms,
  Server in 'Server.pas' {frmserver},
  MyService in 'MyService.pas',
  uUsuariosDao in 'Dao\uUsuariosDao.pas',
  uGeral in 'Funcao\uGeral.pas',
  uMD5 in 'Funcao\uMD5.pas';

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;
  Application.CreateForm(Tfrmserver, frmserver);
  Application.Run;
end.
