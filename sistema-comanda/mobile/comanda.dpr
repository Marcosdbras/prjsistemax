program comanda;

uses
  System.StartUpCopy,
  FMX.Forms,
  ulogin in 'ulogin.pas' {frmlogin},
  uprincipal in 'uprincipal.pas' {frmprincipal},
  uresumo in 'uresumo.pas' {frmresumo},
  uadditem in 'uadditem.pas' {frmadditem},
  uDM in 'uDM.pas' {DM: TDataModule},
  uMD5 in 'uMD5.pas';

{$R *.res}

begin
  Application.Initialize;
  Application.CreateForm(TDM, DM);
  Application.CreateForm(Tfrmlogin, frmlogin);
  Application.Run;
end.
