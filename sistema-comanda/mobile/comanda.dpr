program comanda;

uses
  System.StartUpCopy,
  FMX.Forms,
  ulogin in 'ulogin.pas' {frmlogin},
  uprincipal in 'uprincipal.pas' {frmprincipal},
  uresumo in 'uresumo.pas' {frmresumo},
  uadditem in 'uadditem.pas' {frmadditem};

{$R *.res}

begin
  Application.Initialize;
  Application.CreateForm(Tfrmlogin, frmlogin);
  Application.Run;
end.
