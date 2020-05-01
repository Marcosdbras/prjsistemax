object frmEmitenteModulo: TfrmEmitenteModulo
  OldCreateOrder = False
  OnCreate = DataModuleCreate
  OnDestroy = DataModuleDestroy
  Height = 279
  Width = 313
  object aDataset: TAureliusDataset
    FieldDefs = <>
    CreateSelfField = False
    Left = 71
    Top = 24
  end
  object aDataSource: TDataSource
    DataSet = aDataset
    Left = 135
    Top = 72
  end
end
