program CardapioDigital;

uses
  Vcl.Forms,
  uprincipal in 'view\uprincipal.pas' {frmprincipal},
  uconexao in 'dao\uconexao.pas',
  uSistemaControl in 'controlle\uSistemaControl.pas',
  uUsuarioModel in 'model\uUsuarioModel.pas',
  uUsuarioDao in 'dao\uUsuarioDao.pas',
  uEnumerado in 'model\uEnumerado.pas',
  uClienteModel in 'model\uClienteModel.pas',
  uUsuarioView in 'view\uUsuarioView.pas' {frmUsuarioView},
  UsuarioModule in 'module\UsuarioModule.pas' {DataModule1: TDataModule},
  uUsuarioControl in 'controlle\uUsuarioControl.pas';

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;
  Application.CreateForm(TDataModule1, DataModule1);

  Application.CreateForm(Tfrmprincipal, frmprincipal);
  Application.CreateForm(TfrmUsuarioView, frmUsuarioView);

  Application.Run;
end.
