unit uEmitenteModulo;

interface

uses
  System.SysUtils, System.Classes, Data.DB, Aurelius.Bind.BaseDataset,
  Aurelius.Bind.Dataset,

  uConexaoFactory,
  Aurelius.Engine.ObjectManager,
  Aurelius.Engine.DatabaseManager, Vcl.StdCtrls,
  uEmitenteDAO;

type
  TfrmEmitenteModulo = class(TDataModule)
    aDataset: TAureliusDataset;
    aDataSource: TDataSource;
    procedure DataModuleCreate(Sender: TObject);
    procedure DataModuleDestroy(Sender: TObject);
  private
    { Private declarations }
    Manager:TObjectManager;
  public
    { Public declarations }
  end;

var
  frmEmitenteModulo: TfrmEmitenteModulo;

implementation

{%CLASSGROUP 'Vcl.Controls.TControl'}

{$R *.dfm}

procedure TfrmEmitenteModulo.DataModuleCreate(Sender: TObject);
begin

  //Conecta ao banco
  Manager := TObjectManager.Create(frmConexaoFactory.CreateConnection);

  //atualiza strutura do banco
  tdatabasemanager.Update(frmConexaoFactory.CreateConnection);


  aDataSet.Close;
  aDataSet.Manager := Manager;
  aDataSet.SetSourceCriteria(Manager.Find<TEmitente>);
  aDataSet.Open;


end;

procedure TfrmEmitenteModulo.DataModuleDestroy(Sender: TObject);
begin
Manager.Free;
end;

end.
