program clientweb;

uses
  Vcl.Forms,
  uclientweb in 'uclientweb.pas' {frmclientweb},
  uDM in 'uDM.pas' {DM: TDataModule};

{$R *.res}

begin
  Application.Initialize;
  Application.MainFormOnTaskbar := True;
  Application.CreateForm(Tfrmclientweb, frmclientweb);
  Application.CreateForm(TDM, DM);
  Application.Run;
end.
