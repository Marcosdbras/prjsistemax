unit uclientweb;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, uDWAbout, uRESTDWBase, uDM;

type
  Tfrmclientweb = class(TForm)
    RESTServicePooler1: TRESTServicePooler;
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  frmclientweb: Tfrmclientweb;

implementation

{$R *.dfm}

procedure Tfrmclientweb.FormCreate(Sender: TObject);
begin
RESTServicepooler1.ServerMethodClass := TDM;
RESTServicePooler1.Active := true;
end;

procedure Tfrmclientweb.FormDestroy(Sender: TObject);
begin
RESTServicePooler1.Active := false;
end;

end.
