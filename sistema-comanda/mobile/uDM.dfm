object DM: TDM
  OldCreateOrder = False
  OnCreate = DataModuleCreate
  Height = 313
  Width = 273
  object Conn: TFDConnection
    Params.Strings = (
      
        'Database=C:\Users\WIN 8.1\Documents\sistemas\sistema-comanda\mob' +
        'ile\DB\comanda_eletronica.db'
      'OpenMode=ReadWrite'
      'LockingMode=Normal'
      'DriverID=SQLite')
    LoginPrompt = False
    Left = 80
    Top = 56
  end
  object Query: TFDQuery
    Connection = Conn
    Left = 152
    Top = 104
  end
end
